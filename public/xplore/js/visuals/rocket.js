/*
 * XV-04 — The Rocketdyne F-1, the engine that lifted the Saturn V (five of them, 1.5 million lbf
 * each), firing. Quarter cut-away, hung from its gimbal on a thrust frame.
 * Built to the real engine at 1 unit = 1 m: 5.8 m from gimbal to nozzle exit, 3.6 m across the exit,
 * a 0.9 m throat, expansion 10:1 at the end of the tube-wall nozzle and 16:1 at the exit.
 * LOX/RP-1, gas-generator cycle. The Mark 10 turbopump hangs on the side of the chamber: LOX pump,
 * fuel pump and a two-stage turbine on one shaft. The gas generator drives the turbine; its fuel-rich
 * exhaust runs through the heat exchanger and down the big duct to the manifold wrapped around the
 * nozzle at 10:1, then out through the shingles of the nozzle extension as a cool film on its wall.
 * Chamber and nozzle down to 10:1 are brazed tubes, stiffened by hatbands; RP-1 runs down half of
 * them and back up the other half to the injector, whose face is split by the copper baffles that
 * cured the F-1's combustion instability. LOX goes straight into the dome.
 * Colour = temperature: the cryogenic LOX, the fuel warming in the tube wall, gas generator and turbine
 * gas, the ~3,500 K combustion gas expanding through the throat, the cooler film that leaves a dark
 * collar around the plume before it catches fire, and the plume's shock diamonds.
 */
import {
  THREE, Stage, mergeParts, circleSegments, lines, centerline, latheX, capAt, sectionHatch,
  gradientSRGB, rng, smoothstep, lerp, clamp, glowPoints, trailRibbons, spanBetween, GLSL_GRADIENT, FX,
} from './core.js';

/* thrust chamber contour (x along the axis, from the throat; metres) */
const X0 = -1.1, XC = -0.55, XT = 0, XM = 2.2, XE = 4.1;    // injector, end of the cylinder, throat, 10:1, exit
const RC = 0.56, RT = 0.45, RE = 1.78, WALL = 0.05, EXW = 0.03;
const PIVOT = -1.85;                                        // gimbal, on top of the LOX dome

function R(x) {
  if (x <= XC) return RC;
  if (x <= XT) { const u = (x - XC) / (XT - XC); return RT + (RC - RT) * (0.5 + 0.5 * Math.cos(Math.PI * u)); }
  const u = Math.min(1, (x - XT) / (XE - XT));
  return RT + (RE - RT) * (0.85 * (1 - (1 - u) ** 1.8) + 0.15 * u) * (1 - Math.exp(-u / 0.03));
}
const RM = R(XM);

/* Exhaust plume + shock diamonds as one ray-marched volume (nozzle frame, x = distance from exit).
 * An over-expanded sea-level plume: the jet necks down after the exit, its boundary pinches at each
 * shock-cell node and bulges between; compact white-hot knots (Mach disks) sit on the axis at the nodes,
 * ~1.8 exit diameters apart, blurring and cooling downstream. Around it, for the first exit diameter or so,
 * the F-1's fuel-rich turbine-exhaust film runs as a cool, dark sheath until it mixes and burns. */
const SHOCK_L = 26.0, SHOCK_RB = 1.7 * RE;
const PLUME = (RE) => {
  // cell length from Pack's relation L ≈ 1.22·Dj·√(Mj²−1): ~1.8 exit diameters; boundary ripple ~±11 %
  const D = 2 * RE, LC0 = 1.8 * D, X1 = 0.58 * LC0, A = 0.11;
  const cellAt = (x) => (x - X1) / (LC0 * (1 + 0.012 * x));
  const shape = (x) => (1 - A * (0.5 + 0.5 * Math.cos(2 * Math.PI * cellAt(x)))) * (1 + 0.03 * x);
  const R0 = (0.97 * RE) / shape(0);
  return { D, LC0, X1, A, R0, cellAt, Rj: (x) => R0 * shape(x) };
};
const shockMaterial = (RE) => {
  const P = PLUME(RE);
  return new THREE.ShaderMaterial({
    uniforms: { uInv: { value: new THREE.Matrix4() }, uTime: { value: 0 }, uFx: FX },
    vertexShader: /* glsl */ `
      varying vec3 vW;
      void main() { vec4 w = modelMatrix * vec4(position, 1.0); vW = w.xyz; gl_Position = projectionMatrix * viewMatrix * w; }`,
    fragmentShader: /* glsl */ `
      ${GLSL_GRADIENT}
      uniform mat4 uInv; uniform float uTime; uniform float uFx;
      varying vec3 vW;
      const float L = ${SHOCK_L.toFixed(3)}, RB = ${SHOCK_RB.toFixed(3)};
      const float D = ${P.D.toFixed(4)}, LC0 = ${P.LC0.toFixed(4)}, X1 = ${P.X1.toFixed(4)}, A = ${P.A.toFixed(4)}, R0 = ${P.R0.toFixed(4)};
      vec3 plume(vec3 p) {
        float x = p.x; if (x < 0.0 || x > L) return vec3(0.0);
        float r = length(p.yz);
        float lc = LC0 * (1.0 + 0.012 * x);
        float c = (x - X1) / lc;
        float Rj = R0 * (1.0 - A * (0.5 + 0.5 * cos(6.2831853 * c))) * (1.0 + 0.03 * x);
        float start = smoothstep(0.0, 0.3, x), far = exp(-x / 12.0) * (1.0 - smoothstep(19.0, 26.0, x));
        // the turbine-exhaust film: a cool sheath around the core until it catches fire
        float sheath = smoothstep(Rj * 0.66, Rj * 0.9, r) * (1.0 - smoothstep(Rj * 0.98, Rj * 1.08, r)) * (1.0 - smoothstep(0.45 * D, 1.5 * D, x));
        float burn = smoothstep(0.6 * D, 1.7 * D, x);
        float body = (1.0 - smoothstep(Rj * 0.45, Rj * 1.02, r)) * 0.24 * far * (1.0 - 0.85 * sheath);
        float edge = exp(-pow((r - Rj) / 0.11, 2.0)) * 0.13 * exp(-x / 7.0) * (0.3 + 0.7 * burn);
        // faint oblique shocks converging into each node
        float k = floor(c + 0.5), dc = c - k;
        float rs = Rj * min(1.0, 2.0 * abs(dc));
        float sheet = exp(-pow((r - rs) / 0.07, 2.0)) * 0.1 * far;
        // compact knot (Mach disk) on the axis at each node, growing diffuse downstream
        float kk = max(k, 0.0);
        float wa = 0.32 * D * (1.0 + 0.18 * kk), wr = 0.12 * D * (1.0 + 0.22 * kk);
        float m = abs(dc * lc) / wa + r / wr;                  // L1 metric -> pointed diamond knot
        float knot = (k >= 0.0 ? 1.0 : 0.0) * (exp(-m * m * 1.1) * 2.2 + exp(-m * m * 5.0) * 2.2) * exp(-0.5 * kk);
        float flick = 0.92 + 0.08 * sin(uTime * 43.0 + k * 3.1);
        vec3 col = xvGradient(0.5 - 0.012 * x) * body + xvGradient(mix(0.3, 0.8, burn)) * edge
                 + xvGradient(0.3) * sheath * 0.035
                 + xvGradient(0.62) * sheet + xvGradient(0.96 - 0.08 * kk) * knot;
        return col * start * flick;
      }
      void main() {
        vec3 o = (uInv * vec4(cameraPosition, 1.0)).xyz;
        vec3 d = normalize((uInv * vec4(vW, 1.0)).xyz - o);
        float a = d.y * d.y + d.z * d.z, b = 2.0 * (o.y * d.y + o.z * d.z), c = o.y * o.y + o.z * o.z - RB * RB;
        float disc = b * b - 4.0 * a * c;
        if (disc < 0.0) discard;
        float s = sqrt(disc);
        float t0 = (-b - s) / (2.0 * a), t1 = (-b + s) / (2.0 * a);
        float tx0 = (0.0 - o.x) / d.x, tx1 = (L - o.x) / d.x;
        t0 = max(max(t0, min(tx0, tx1)), 0.0); t1 = min(t1, max(tx0, tx1));
        if (t1 <= t0) discard;
        const int N = 72;
        float dt = (t1 - t0) / float(N);
        vec3 acc = vec3(0.0);
        for (int i = 0; i < N; i++) acc += plume(o + d * (t0 + (float(i) + 0.5) * dt)) * dt;
        gl_FragColor = vec4(acc * 1.6 * uFx, 1.0);
      }`,
    transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
  });
};

export const ROCKET_VIEW = {
  camera: { fov: 26, position: [-3.5, 5.97, 18.9], target: [3.0, 0.3, 0] },   // ~12 % further out than first drawn
  refAspect: 1.9,
  drift: (t) => ({ yaw: Math.sin(t * 0.05) * 0.07, pitch: Math.sin(t * 0.04) * 0.025 }),
  speed: 1,
};

export function mountRocket(el, opts = {}) {
  const stage = opts.stage || new Stage(el, { ...ROCKET_VIEW, ...opts, hud: false });
  const { scene } = stage;
  const Y = new THREE.Vector3(0, 1, 0), Z = new THREE.Vector3(0, 0, 1);
  const rand = rng(41);

  // gimbal: pivot group at the gimbal block, engine hangs off it
  const pivot = new THREE.Group();
  pivot.position.x = PIVOT;
  scene.add(pivot);
  const eng = new THREE.Group();
  eng.position.x = -PIVOT;
  pivot.add(eng);

  /* cut-away helpers: everything round is cut open toward the camera -------------------------- */
  // a window over the lower front: the upper front keeps the tube wall, hatbands and manifold that make it an F-1
  const camDir = Math.atan2(stage.basePos.z - stage.target.z, stage.basePos.y - stage.target.y);
  const CUTC = camDir + 0.5, CUT = 0.78;
  const th0 = CUTC + CUT, th1 = CUTC + Math.PI * 2 - CUT;
  const inCut = (a) => { const d = ((a - CUTC) % (2 * Math.PI) + 3 * Math.PI) % (2 * Math.PI) - Math.PI; return Math.abs(d) < CUT; };
  const cutSolid = (poly, segs, hatch = 0.035) => {
    const g = mergeParts([latheX([...poly, poly[0]], segs, th0, th1), capAt(poly, th0), capAt(poly, th1)]);
    return { g, hatch: hatch ? sectionHatch(poly, th0, th1, hatch) : [] };
  };
  const circle = (x, r, rt, n = 18) => {
    const out = [];
    for (let i = 0; i < n; i++) { const a = (i / n) * Math.PI * 2; out.push([x + rt * Math.cos(a), r + rt * Math.sin(a)]); }
    return out;
  };
  // a hollow tube bent into a ring round the axis (manifolds): outer and inner skins, an annular cut face
  const cutTube = (x, r, rt, t, segs, hatchStep = 0.012) => {
    const o = circle(x, r, rt, 28), i = circle(x, r, rt - t, 28);
    const cap = (th) => {
      const sh = new THREE.Shape(o.map(([a, b]) => new THREE.Vector2(a, b)));
      sh.holes.push(new THREE.Path(i.map(([a, b]) => new THREE.Vector2(a, b))));
      const g = new THREE.ShapeGeometry(sh), p2 = g.attributes.position, c = Math.cos(th), sn = Math.sin(th);
      for (let k = 0; k < p2.count; k++) { const xx = p2.getX(k), rr = p2.getY(k); p2.setXYZ(k, xx, rr * c, rr * sn); }
      return g;
    };
    const ring = [...o, o[0], i[0], ...i.slice(1).reverse(), i[0]];          // keyhole: hatch only the wall
    return { g: mergeParts([latheX([...o, o[0]], segs, th0, th1), latheX([...i, i[0]], segs, th0, th1), cap(th0), cap(th1)]), hatch: sectionHatch(ring, th0, th1, hatchStep) };
  };
  const arcs = (out, x, r, step = 0.06) => {
    for (let a = th0; a < th1 - 1e-6; a += step) { const b = Math.min(th1, a + step); out.push(x, r * Math.cos(a), r * Math.sin(a), x, r * Math.cos(b), r * Math.sin(b)); }
  };
  const solidParts = [], hatch = [], detail = [], faint = [];
  const add = ({ g, hatch: h }) => { solidParts.push(g); hatch.push(...h); };

  /* thrust chamber and the tube-wall nozzle down to 10:1 ------------------------------------ */
  const inner = [], outer = [];
  for (let i = 0; i <= 80; i++) { const x = lerp(X0, XM, i / 80); inner.push([x, R(x)]); }
  for (let i = 80; i >= 0; i--) { const x = lerp(X0, XM, i / 80); outer.push([x, R(x) + WALL]); }
  add(cutSolid([...inner, ...outer], 120));
  // the nozzle extension, 10:1 to 16:1: a thinner skirt bolted on at the turbine-exhaust manifold
  const exIn = [], exOut = [];
  for (let i = 0; i <= 40; i++) { const x = lerp(XM, XE, i / 40); exIn.push([x, R(x)]); }
  for (let i = 40; i >= 0; i--) { const x = lerp(XM, XE, i / 40); exOut.push([x, R(x) + EXW + (i === 40 ? 0.05 : 0)]); }
  add(cutSolid([...exIn, [XE, R(XE) + EXW + 0.05], ...exOut.slice(1)], 140, 0.03));
  add(cutSolid([[XM - 0.05, RM + WALL], [XM - 0.05, RM + 0.11], [XM + 0.05, RM + 0.11], [XM + 0.05, RM + EXW]], 140, 0));   // bolted flange
  for (let x = XM + 0.28; x < XE - 0.1; x += 0.24) { arcs(detail, x, R(x) + EXW + 0.002); arcs(faint, x, R(x) - 0.004); }   // shingle steps, outside and in
  // turbine exhaust manifold: the big hollow torus round the nozzle at 10:1
  const MX = XM + 0.12, MR = RM + 0.33, MT = 0.24;
  add(cutTube(MX, MR, MT, 0.03, 160));
  // fuel inlet manifold near the top of the chamber, the return manifold at 10:1, hatbands down the bell
  const XF = -0.85, FR = RC + WALL + 0.08;
  add(cutTube(XF, FR, 0.08, 0.018, 110, 0.008));
  add(cutTube(XM - 0.12, RM + WALL + 0.05, 0.05, 0.014, 140, 0.007));
  for (const x of [0.4, 0.8, 1.15, 1.5, 1.85]) add(cutSolid(circle(x, R(x) + WALL + 0.02, 0.02, 8), 120, 0));
  // actuator collar just above the throat
  const XA = -0.35, CR = RC + 0.2;
  add(cutSolid([[XA - 0.1, R(XA - 0.1) + WALL], [XA - 0.1, CR], [XA + 0.1, CR], [XA + 0.1, R(XA + 0.1) + WALL]], 110, 0.03));

  // LOX dome on the injector, gimbal pad on top
  // the LOX dome is a shell over the injector plate, not a solid
  const dome = [];
  for (let i = 0; i <= 16; i++) { const a = (i / 16) * Math.PI / 2; dome.push([X0 - 0.42 * Math.sin(a), Math.max(0.2, (RC + WALL) * Math.cos(a))]); }
  for (let i = 16; i >= 0; i--) { const a = (i / 16) * Math.PI / 2; dome.push([X0 - 0.06 - 0.33 * Math.sin(a), Math.max(0.2, (RC + WALL - 0.035) * Math.cos(a))]); }
  add(cutSolid(dome, 96, 0.025));
  add(cutSolid([[X0 - 0.06, 0], [X0 - 0.06, RC + WALL - 0.035], [X0, RC + WALL - 0.035], [X0, 0]], 96, 0.025));   // injector plate
  // injector face: orifice rings and the baffles (one ring, twelve radial blades) standing off it
  const inj = [];
  for (let ring = 1; ring <= 4; ring++) {
    const rr = ring * 0.12, n = ring * 8;
    for (let k = 0; k < n; k++) {
      const a = (k / n) * Math.PI * 2;
      if (!inCut(a) && ring < 4) continue;
      circleSegments(inj, new THREE.Vector3(X0 + 0.002, Math.cos(a) * rr, Math.sin(a) * rr), Y, Z, 0.018, 10);
    }
  }
  const BH = 0.07, BR = 0.3;
  for (let i = 0; i < 48; i++) {
    const a0 = (i / 48) * Math.PI * 2, a1 = ((i + 1) / 48) * Math.PI * 2;
    for (const x of [X0 + 0.003, X0 + BH]) inj.push(x, BR * Math.cos(a0), BR * Math.sin(a0), x, BR * Math.cos(a1), BR * Math.sin(a1));
  }
  for (let k = 0; k < 12; k++) {
    const a = (k / 12) * Math.PI * 2, c = Math.cos(a), s = Math.sin(a);
    for (const x of [X0 + 0.003, X0 + BH]) inj.push(x, BR * c, BR * s, x, RC * c, RC * s);
    inj.push(X0 + 0.003, BR * c, BR * s, X0 + BH, BR * c, BR * s);
  }
  eng.add(lines(stage, inj, stage.mat.dim));

  // the tube wall: 178 tubes down to the throat, split in two below it (drawn at half density)
  const tubes = [];
  const NT = 89;
  for (let k = 0; k < 2 * NT; k++) {
    const primary = k % 2 === 0, a = th0 + ((k + 0.5) / (2 * NT)) * (th1 - th0);
    const xs = primary ? X0 + 0.05 : XT + 0.12;
    for (let i = 0; i < 50; i++) {
      const xa = lerp(xs, XM - 0.14, i / 50), xb = lerp(xs, XM - 0.14, (i + 1) / 50);
      const ra = R(xa) + WALL + 0.002, rb = R(xb) + WALL + 0.002;
      tubes.push(xa, ra * Math.cos(a), ra * Math.sin(a), xb, rb * Math.cos(a), rb * Math.sin(a));
    }
  }
  eng.add(lines(stage, tubes, stage.mat.faint));

  /* Mark 10 turbopump (cut away): LOX pump forward, fuel pump, two-stage turbine aft ------------ */
  const TP = 1.3;
  const tp = new THREE.Group(); tp.position.y = TP; eng.add(tp);
  const pumpOut = [[-1.98, 0.24], [-1.76, 0.24], [-1.76, 0.47], [-1.32, 0.47], [-1.24, 0.3], [-1.06, 0.3], [-1.06, 0.45],
    [-0.62, 0.45], [-0.54, 0.28], [-0.42, 0.28], [-0.42, 0.4], [0.05, 0.4], [0.16, 0.3], [0.3, 0.3]];
  const pumpPoly = [...pumpOut, ...pumpOut.slice().reverse().map(([x, r]) => [x, r - 0.045])];
  const pc = cutSolid(pumpPoly, 96, 0.03);
  tp.add(stage.wire(pc.g, { crease: 22 }));
  tp.add(lines(stage, pc.hatch, stage.mat.hatch));
  // rotor: shaft, LOX inducer + impeller, fuel impeller, two turbine wheels
  const rotor = new THREE.Group(); tp.add(rotor);
  const tblades = [];
  for (const [x, tw] of [[-0.26, 0.45], [-0.06, -0.45]]) {
    for (let k = 0; k < 44; k++) {
      const bl = new THREE.BoxGeometry(0.06, 0.08, 0.014);
      bl.rotateY(tw); bl.translate(x, 0.31, 0); bl.rotateX((k / 44) * Math.PI * 2);
      tblades.push(bl);
    }
  }
  rotor.add(stage.wire(mergeParts([
    latheX([[-1.95, 0], [-1.95, 0.04], [-1.78, 0.07], [-1.7, 0.055], [0.22, 0.055], [0.22, 0]], 40),
    latheX([[-1.58, 0], [-1.58, 0.42], [-1.53, 0.42], [-1.53, 0]], 56),
    latheX([[-0.88, 0], [-0.88, 0.4], [-0.83, 0.4], [-0.83, 0]], 56),
    latheX([[-0.3, 0], [-0.3, 0.27], [-0.22, 0.27], [-0.22, 0]], 56),
    latheX([[-0.1, 0], [-0.1, 0.27], [-0.02, 0.27], [-0.02, 0]], 56),
    ...tblades,
  ]), { crease: 30 }));
  const rl = [];
  for (let bI = 0; bI < 3; bI++) {                                 // LOX inducer: three helical blades
    for (let i = 0; i < 24; i++) {
      const u0 = i / 24, u1 = (i + 1) / 24;
      for (const r of [0.07, 0.2]) {
        const a0 = (bI / 3) * Math.PI * 2 + u0 * 3 * Math.PI, a1 = (bI / 3) * Math.PI * 2 + u1 * 3 * Math.PI;
        rl.push(lerp(-1.95, -1.78, u0), r * Math.cos(a0), r * Math.sin(a0), lerp(-1.95, -1.78, u1), r * Math.cos(a1), r * Math.sin(a1));
      }
      if (i % 4 === 0) { const a = (bI / 3) * Math.PI * 2 + u0 * 3 * Math.PI, x = lerp(-1.95, -1.78, u0); rl.push(x, 0.07 * Math.cos(a), 0.07 * Math.sin(a), x, 0.2 * Math.cos(a), 0.2 * Math.sin(a)); }
    }
  }
  for (const [xa, xb, r1] of [[-1.62, -1.585, 0.42], [-0.92, -0.885, 0.4]]) {   // impellers: backswept vanes
    for (let j = 0; j < 12; j++) {
      for (let i = 0; i < 8; i++) {
        const r0 = lerp(0.1, r1, i / 8), r2 = lerp(0.1, r1, (i + 1) / 8);
        const a0 = (j / 12) * Math.PI * 2 + 0.9 * (i / 8), a1 = (j / 12) * Math.PI * 2 + 0.9 * ((i + 1) / 8);
        for (const x of [xa, xb]) rl.push(x, r0 * Math.cos(a0), r0 * Math.sin(a0), x, r2 * Math.cos(a1), r2 * Math.sin(a1));
      }
    }
  }
  rotor.add(lines(stage, rl, stage.mat.line));

  /* ducts, ghosted so the flows inside show ---------------------------------------------------- */
  const tube = (pts, r, seg = 64) => new THREE.TubeGeometry(new THREE.CatmullRomCurve3(pts.map((p) => new THREE.Vector3(...p))), seg, r, 14, false);
  const P_LOX = [[-3.3, TP + 1.05, 0], [-2.7, TP + 0.55, 0], [-2.25, TP + 0.04, 0], [-1.98, TP, 0]];
  const P_FUEL = [[-3.2, TP + 1.15, -0.8], [-1.9, TP + 0.95, -0.72], [-1.05, TP + 0.35, -0.5], [-0.85, TP + 0.1, -0.45]];
  const domeAt = (x, a) => { const r = (RC + WALL) * Math.sqrt(Math.max(0, 1 - ((X0 - x) / 0.42) ** 2)); return [x, r * Math.cos(a), r * Math.sin(a)]; };
  const P_LOXD = (s) => [[-1.55, TP - 0.42, s * 0.2], [-1.62, 0.78, s * 0.55], [-1.48, ...domeAt(-1.36, s * 1.0).slice(1).map((v) => v * 1.5)], domeAt(-1.36, s * 1.0)];
  const P_FUELD = (s) => [[-0.86, TP - 0.4, s * 0.18], [-0.95, 0.82, s * 0.5], [XF - 0.02, FR * Math.cos(s * 0.75) + 0.08, FR * Math.sin(s * 0.75) + s * 0.06], [XF, FR * Math.cos(s * 0.75), FR * Math.sin(s * 0.75)]];
  const EA = -0.32;                                                 // the exhaust duct joins the manifold here
  const P_EXH = [[0.3, TP, 0], [0.75, TP - 0.03, -0.12], [1.3, TP + 0.05, -0.4], [1.85, MR * Math.cos(EA) + 0.32, MR * Math.sin(EA) - 0.12],
    [MX, MR * Math.cos(EA) + 0.02, MR * Math.sin(EA)]];
  const GX = -0.2;                                                  // gas generator over the turbine
  const ggG = new THREE.LatheGeometry([[0, 0.86], [0.06, 0.86], [0.1, 0.8], [0.1, 0.56], [0.06, 0.5], [0.06, 0.4], [0, 0.4]].map(([r, y]) => new THREE.Vector2(r, y)), 32);
  ggG.translate(GX, TP, 0);
  const ghost = stage.lineMaterial({ width: 1.1, opacity: 0.75 });
  eng.add(stage.wire(mergeParts([
    tube(P_LOX, 0.19), tube(P_FUEL, 0.13), tube(P_LOXD(1), 0.11), tube(P_LOXD(-1), 0.11),
    tube(P_FUELD(1), 0.08), tube(P_FUELD(-1), 0.08), tube(P_EXH, MT, 96),
    tube([[-1.3, TP + 0.44, 0.08], [-0.8, TP + 0.85, 0.06], [GX, TP + 0.9, 0.02]], 0.03),
    tube([[-0.8, TP + 0.43, -0.06], [-0.5, TP + 0.8, -0.04], [GX, TP + 0.88, -0.02]], 0.03),
    ggG,
  ]), { faces: false, material: ghost, crease: 30 }));
  // heat exchanger on the exhaust duct (warms LOX and helium to pressurise the stage's tanks)
  const hx = new THREE.CylinderGeometry(0.27, 0.27, 0.55, 40, 1); hx.rotateZ(Math.PI / 2); hx.translate(0.78, TP - 0.03, -0.12);
  const hxC = [-1, 1].map((s) => { const c = new THREE.CylinderGeometry(0.2, 0.27, 0.1, 40, 1); c.rotateZ(-s * Math.PI / 2); c.translate(0.78 + s * 0.325, TP - 0.03, -0.12); return c; });
  eng.add(stage.wire(mergeParts([hx, ...hxC]), { crease: 30 }));

  /* gimbal, thrust frame + struts, actuators --------------------------------------------------- */
  const gim = new THREE.BoxGeometry(0.34, 0.46, 0.46); gim.translate(PIVOT - 0.02, 0, 0);
  eng.add(stage.wire(latheX([[PIVOT + 0.14, 0], [PIVOT + 0.14, 0.17], [X0 - 0.42, 0.2], [X0 - 0.42, 0]], 48), { crease: 20 }));
  const RING_X = PIVOT - 0.95, RING_R = 1.55;
  const ringG = new THREE.TorusGeometry(RING_R, 0.06, 14, 120); ringG.rotateY(Math.PI / 2); ringG.translate(RING_X, 0, 0);
  const lugs = [0, 1, 2, 3].map((k) => { const g = new THREE.BoxGeometry(0.13, 0.13, 0.13); const a = (k / 4) * Math.PI * 2 + Math.PI / 4; g.translate(RING_X, RING_R * Math.cos(a), RING_R * Math.sin(a)); return g; });
  scene.add(stage.wire(mergeParts([gim, ringG, ...lugs]), { crease: 30 }));
  const unitCyl = new THREE.CylinderGeometry(0.04, 0.04, 1, 14, 1); unitCyl.translate(0, 0.5, 0);
  for (let k = 0; k < 4; k++) {
    const a = (k / 4) * Math.PI * 2 + Math.PI / 4;
    const w = stage.wire(unitCyl, { crease: 30 });
    spanBetween(w, new THREE.Vector3(RING_X, RING_R * Math.cos(a), RING_R * Math.sin(a)), new THREE.Vector3(PIVOT - 0.19, 0.16 * Math.cos(a), 0.16 * Math.sin(a)));
    scene.add(w);
  }
  const actG = { barrel: new THREE.CylinderGeometry(0.085, 0.085, 1, 24, 1), rod: new THREE.CylinderGeometry(0.04, 0.04, 1, 16, 1) };
  actG.barrel.translate(0, 0.5, 0); actG.rod.translate(0, 0.5, 0);
  const acts = [
    { P: new THREE.Vector3(RING_X, -RING_R, 0), C: new THREE.Vector3(XA, -CR, 0) },
    { P: new THREE.Vector3(RING_X, 0, -RING_R), C: new THREE.Vector3(XA, 0, -CR) },
  ].map((a) => {
    const barrel = stage.wire(actG.barrel, { crease: 30 }), rod = stage.wire(actG.rod, { crease: 30 });
    scene.add(barrel, rod);
    return { ...a, barrel, rod, Cw: new THREE.Vector3() };
  });

  eng.add(stage.wire(mergeParts(solidParts), { crease: 22 }));
  eng.add(lines(stage, hatch, stage.mat.hatch), lines(stage, detail, stage.mat.dim), lines(stage, faint, stage.mat.faint));
  scene.add(lines(stage, centerline([], new THREE.Vector3(-3.6, 0, 0), new THREE.Vector3(14, 0, 0)),
    stage.lineMaterial({ width: 1, opacity: 0.22, depthTest: false })));

  /* propellant and turbine-gas flows as time-sampled paths (engine frame) ---------------------- */
  const curvePts = (pts, n, jit, rr) => {
    const c = new THREE.CatmullRomCurve3(pts.map((p) => new THREE.Vector3(...p)));
    const ja = rr() * Math.PI * 2, jr = Math.sqrt(rr()) * jit;
    return c.getSpacedPoints(n).map((v) => [v.x, v.y + jr * Math.cos(ja), v.z + jr * Math.sin(ja)]);
  };
  const around = (x, r, a) => [x, TP + r * Math.cos(a), r * Math.sin(a)];
  const pumped = (pts, xi, rI, xo, rO, aOut, inducer) => {           // through an impeller and round its volute
    let a = rand() * Math.PI * 2;
    const r0 = 0.07 + rand() * 0.12;
    if (inducer) for (let i = 1; i <= 14; i++) { a += (3 * Math.PI) / 14; pts.push(around(lerp(-1.95, -1.78, i / 14), r0, a)); }
    else for (let i = 1; i <= 4; i++) pts.push(around(xi, lerp(rI, r0, i / 4), a));
    for (let i = 1; i <= 8; i++) { a += 0.12; pts.push(around(xo, lerp(r0, rO, i / 8), a)); }
    let aEnd = aOut; while (aEnd < a + 0.3) aEnd += Math.PI * 2;
    for (let i = 1; i <= 10; i++) pts.push(around(xo + 0.05, rO + 0.02, lerp(a, aEnd, i / 10)));
    return pts;
  };
  const loxPath = () => {
    const s = rand() < 0.5 ? 1 : -1;
    const pts = pumped(curvePts(P_LOX, 14, 0.08, rand), 0, 0, -1.55, 0.44, Math.atan2(s * 0.2, -0.42), true);
    pts.push(...curvePts(P_LOXD(s), 12, 0.04, rand).slice(1));
    const a = rand() * Math.PI * 2, r = Math.sqrt(rand()) * 0.48;   // across the dome to the injector face
    pts.push([X0 - 0.2, r * 0.6 * Math.cos(a), r * 0.6 * Math.sin(a)], [X0 - 0.01, r * Math.cos(a), r * Math.sin(a)]);
    return pts;
  };
  const fuelPath = () => {
    const s = rand() < 0.5 ? 1 : -1;
    const pts = curvePts(P_FUEL, 14, 0.05, rand);
    pumped(pts, -0.95, 0.3, -0.86, 0.42, Math.atan2(s * 0.18, -0.4), false);
    pts.push(...curvePts(P_FUELD(s), 10, 0.03, rand).slice(1));
    const a0 = s * 0.75, a1 = a0 + s * (0.4 + rand() * 1.4);           // round the fuel inlet manifold
    for (let i = 1; i <= 6; i++) { const a = lerp(a0, a1, i / 6); pts.push([XF, FR * Math.cos(a), FR * Math.sin(a)]); }
    return pts;
  };
  const turbPath = () => {
    const pts = [];
    const jr = rand() * 0.05, ja = rand() * Math.PI * 2;
    for (let i = 0; i <= 6; i++) pts.push([GX + jr * Math.cos(ja), TP + lerp(0.84, 0.42, i / 6), jr * Math.sin(ja)]);
    let a = (rand() - 0.5) * 2.4;
    for (let i = 1; i <= 4; i++) pts.push(around(GX, lerp(0.37, 0.33, i / 4), a * (i / 4)));
    for (let i = 1; i <= 12; i++) { a += 0.35; pts.push(around(lerp(-0.3, 0.0, i / 12), 0.31, a)); }
    for (let i = 1; i <= 4; i++) pts.push(around(lerp(0.0, 0.3, i / 4), lerp(0.31, 0.1, i / 4), a + 0.2 * i));
    pts.push(...curvePts(P_EXH, 26, 0.09, rand).slice(1));
    // round the manifold, out through the shingles and down the extension wall as a film, into the plume
    const end = EA + (rand() < 0.5 ? 1 : -1) * rand() * Math.PI, rw = 0.9 + rand() * 0.08;
    for (let i = 1; i <= 14; i++) { const b = lerp(EA, end, i / 14), rr = MR + (rand() - 0.5) * 0.12; pts.push([MX, rr * Math.cos(b), rr * Math.sin(b)]); }
    pts.push([XM + 0.22, (R(XM + 0.22) - 0.02) * Math.cos(end), (R(XM + 0.22) - 0.02) * Math.sin(end)]);
    for (let i = 1; i <= 16; i++) { const x = lerp(XM + 0.22, XE, i / 16), r = R(x) * rw; pts.push([x, r * Math.cos(end), r * Math.sin(end)]); }
    const PLm = PLUME(RE);
    for (let i = 1; i <= 10; i++) { const d = i * 0.28, r = PLm.Rj(d) * rw * (1 + 0.02 * i); pts.push([XE + d, r * Math.cos(end), r * Math.sin(end)]); }
    return pts;
  };
  const makeFlow = (n, build, temp, speed = 14) => {
    const K = 10, rib = trailRibbons(stage, n, K, { width: 1.5, ghost: 0.4 });
    eng.add(rib.mesh);
    const paths = Array.from({ length: n }, build);
    const u = Float32Array.from({ length: n }, (_, i) => rand() * (paths[i].length - 1));
    return { rib, paths, u, K, temp, speed };
  };
  const flows = [
    makeFlow(200, loxPath, (f) => 0.0 + 0.05 * f),                                  // LOX at −183 °C
    makeFlow(160, fuelPath, (f) => 0.1 + 0.04 * f),                                 // RP-1
    makeFlow(260, turbPath, (f) => (f < 0.15 ? 0.56 : f < 0.75 ? 0.5 - 0.12 * (f - 0.15) / 0.6 : 0.36 - 0.1 * (f - 0.75) / 0.25)),   // GG gas
  ];
  const samplePath = (pth, u, out, o) => {
    const i = Math.min(pth.length - 2, Math.max(0, Math.floor(u))), w = clamp(u - i, 0, 1), a = pth[i], b = pth[i + 1];
    out[o] = a[0] + (b[0] - a[0]) * w; out[o + 1] = a[1] + (b[1] - a[1]) * w; out[o + 2] = a[2] + (b[2] - a[2]) * w;
  };

  /* combustion gas, plume, coolant ----------------------------------------------------------- */
  // (1) combustion gas through chamber, throat and bell (engine frame); the film owns the outer rim
  const NI = opts.particles || 1200, KI = 14, HI = 0.022;
  const PI_ = new Float32Array(NI * 3), VJ = new Float32Array(NI);
  const vel = (x) => { const a = RT / R(x); return x < XT ? 0.4 + 3.2 * a * a : 3.6 + 2.6 * (1 - a); };
  let TRANSIT = 0; for (let x = X0; x < XE; x += 0.01) TRANSIT += 0.01 / vel(x);
  const spawnI = (i, any) => {
    PI_[i * 3 + 1] = Math.sqrt(rand()) * 0.93; PI_[i * 3 + 2] = rand() * Math.PI * 2;
    VJ[i] = 0.82 + 0.36 * rand();                       // per-particle speed spread decorrelates arrivals
    let x = X0 + BH;
    if (any) { let tt = rand() * TRANSIT / VJ[i]; while (tt > 0 && x < XE) { const h = Math.min(0.02, tt); x += vel(x) * VJ[i] * h; tt -= h; } }
    PI_[i * 3] = x;
  };
  for (let i = 0; i < NI; i++) spawnI(i, true);
  const temp = (x) => { const a = RT / R(x); return x < XT ? 1.0 - 0.08 * a * a : 0.92 - 0.36 * (1 - a); };
  const inRib = trailRibbons(stage, NI, KI, { width: 1.4, ghost: 0.25 });
  eng.add(inRib.mesh);
  // (2) exhaust plume streaks riding inside the pinching jet envelope (kept faint)
  const PL = PLUME(RE);
  const NP = 2400, KP = 14, HP = 0.024, LIFE = 4.2;
  const plRib = trailRibbons(stage, NP, KP, { width: 1.3, intensity: 0.3 });
  eng.add(plRib.mesh);
  const PP = new Float32Array(NP * 4);       // radius fraction, angle, speed, age
  const spawnP = (i, age) => { PP[i * 4] = Math.sqrt(rand()) * 0.86; PP[i * 4 + 1] = rand() * Math.PI * 2; PP[i * 4 + 2] = 5.6 + rand() * 1.5; PP[i * 4 + 3] = age; };
  for (let i = 0; i < NP; i++) spawnP(i, rand() * LIFE);
  // (3) RP-1 in the tube wall: down from the inlet manifold to 10:1 in one set of tubes, back up to the injector in the other
  const NC = 1000;
  const cool = glowPoints(NC, { core: 0.4 });
  cool.renderOrder = 3;
  eng.add(cool);
  const XR = XM - 0.12;
  const CL = Array.from({ length: NC }, (_, i) => ({ a: th0 + rand() * (th1 - th0), down: i % 2 === 0, x: lerp(X0, XR, rand()), v: 0.5 + rand() * 0.25 }));
  // (4) shock diamonds: a ray-marched volume hung off the nozzle exit (gimbals with the engine)
  const shockG = new THREE.CylinderGeometry(SHOCK_RB, SHOCK_RB, SHOCK_L, 48, 1, false);
  shockG.rotateZ(-Math.PI / 2); shockG.translate(SHOCK_L / 2, 0, 0);
  const shockM = shockMaterial(RE);
  const shock = new THREE.Mesh(shockG, shockM);
  shock.position.x = XE; shock.renderOrder = 4; shock.frustumCulled = false;
  eng.add(shock);

  const col = [0, 0, 0];
  const cp = cool.geometry.attributes.position.array, cc = cool.geometry.attributes.color.array;
  const cs = cool.geometry.attributes.size.array, ca = cool.geometry.attributes.alpha.array;

  stage.onUpdate((t, dt) => {
    // gimbal wander, turbopump spin
    pivot.rotation.set(0, Math.sin(t * 0.45) * 0.04, Math.sin(t * 0.33 + 1.2) * 0.032);
    rotor.rotation.x = t * 7;
    for (const F of flows) {
      const D = F.rib.data;
      for (let i = 0; i < F.paths.length; i++) {
        const pth = F.paths[i], L = pth.length - 1;
        F.u[i] += dt * F.speed;
        if (F.u[i] >= L) F.u[i] -= L;
        const fa = Math.floor(99 * smoothstep(0, 2, F.u[i]) * (1 - smoothstep(L - 4, L, F.u[i])));
        for (let k = 0; k < F.K; k++) {
          const uu = Math.max(0, F.u[i] - k * 0.8), o = (i * F.K + k) * 4;
          samplePath(pth, uu, D, o);
          D[o + 3] = fa + clamp(F.temp(uu / L), 0, 1) * 0.999;
        }
      }
      F.rib.commit();
    }
    pivot.updateMatrixWorld(true);
    for (const A of acts) {
      A.Cw.copy(A.C).applyMatrix4(eng.matrixWorld);
      const L = A.P.distanceTo(A.Cw);
      spanBetween(A.barrel, A.P, A.Cw, false); A.barrel.scale.set(1, L * 0.62, 1);
      spanBetween(A.rod, A.Cw, A.P, false); A.rod.scale.set(1, L * 0.55, 1);
    }
    cool.material.uniforms.uScale.value = stage.pointScale;

    // (1) combustion gas
    const TD = inRib.data;
    for (let i = 0; i < NI; i++) {
      let x = PI_[i * 3];
      x += vel(x) * VJ[i] * dt;
      if (x > XE) { spawnI(i, false); x = PI_[i * 3] + (x - XE) * 0.1; }
      PI_[i * 3] = x;
      const eta = PI_[i * 3 + 1], th = PI_[i * 3 + 2];
      const fi = smoothstep(X0, X0 + 0.25, x) * (1 - smoothstep(XE - 0.15, XE, x) * 0.6);
      const aCode = Math.floor(fi * 99);
      let xk = x;
      for (let k = 0; k < KI; k++) {
        const r = eta * R(xk) * (xk > XM ? 0.86 : 0.94), o = (i * KI + k) * 4;
        TD[o] = xk; TD[o + 1] = r * Math.cos(th); TD[o + 2] = r * Math.sin(th);
        TD[o + 3] = aCode + clamp(temp(xk), 0, 1) * 0.999;
        const xn = xk - vel(xk) * VJ[i] * HI;
        if (xn > X0) xk = xn;
      }
    }
    inRib.commit();

    // (2) plume streaks
    const PD = plRib.data;
    for (let i = 0; i < NP; i++) {
      PP[i * 4 + 3] += dt;
      if (PP[i * 4 + 3] > LIFE) spawnP(i, 0);
      const f = PP[i * 4], an = PP[i * 4 + 1], sp = PP[i * 4 + 2], age = PP[i * 4 + 3];
      const ca2 = Math.cos(an), sa = Math.sin(an);
      const dHead = sp * age;
      const fade = (1 - smoothstep(16.0, 25.0, dHead)) * smoothstep(0, 0.1, age);
      const aCode = Math.floor(clamp(fade, 0, 1) * 99);
      for (let k = 0; k < KP; k++) {
        const d = Math.max(0, dHead - sp * k * HP), r = f * PL.Rj(d), p = (i * KP + k) * 4;
        PD[p] = XE + d; PD[p + 1] = r * ca2; PD[p + 2] = r * sa;
        PD[p + 3] = aCode + clamp(0.55 * Math.exp(-d / 13), 0, 1) * 0.999;
      }
    }
    plRib.commit();

    // (3) coolant: down the down-tubes, back up the up-tubes, warming all the way
    for (let i = 0; i < NC; i++) {
      const c = CL[i];
      if (c.down) { c.x += c.v * dt; if (c.x > XR) { c.down = false; } }
      else { c.x -= c.v * dt; if (c.x < X0 + 0.05) { c.down = true; c.x = XF; } }
      const r = R(c.x) + WALL + 0.03, o = i * 3;
      cp[o] = c.x; cp[o + 1] = r * Math.cos(c.a); cp[o + 2] = r * Math.sin(c.a);
      const f = c.down ? (c.x - XF) / (XR - XF) : 1 + (XR - c.x) / (XR - X0);   // 0 → 1 going down, 1 → 2 coming back up
      gradientSRGB(0.1 + 0.2 * f, col);
      cc[o] = col[0]; cc[o + 1] = col[1]; cc[o + 2] = col[2];
      cs[i] = 0.04; ca[i] = 0.75 * smoothstep(X0 + 0.05, X0 + 0.3, c.x);
    }
    // (4) shock diamonds
    shock.updateMatrixWorld(true);
    shockM.uniforms.uInv.value.copy(shock.matrixWorld).invert();
    shockM.uniforms.uTime.value = t;
    for (const a of ['position', 'color', 'size', 'alpha']) cool.geometry.attributes[a].needsUpdate = true;
  });

  return stage;
}
