/*
 * XV-07 — Shell-and-tube heat exchanger (single pass), quarter cut-away incl. channel heads.
 * Tube side: hot fluid drops in through the left nozzle, spreads in the channel head, runs the
 * tube bundle, collects in the right head and leaves at the bottom.
 * Shell side: cold fluid from the top-right nozzle follows a potential-flow field solved around
 * the segmental baffles (stream function, SOR), weaving through the bundle to the bottom-left.
 * Colour = temperature (counter-flow).
 */
import {
  THREE, Stage, mergeParts, lines, circleSegments, latheX, capAt, sectionHatch, rng, smoothstep, lerp, clamp,
  trailRibbons,
} from './core.js';

const XS = -3.3, XE = 3.3, RS = 1.0, WALL = 0.06;
const BAF = [-2.5, -1.5, -0.5, 0.5, 1.5, 2.5];      // baffle stations; windows alternate top / bottom
const BCUT = 0.42;                                  // baffle cut height (window edge at |y| = BCUT)
const TUBE_R = 0.045;
const IN_X = [2.6, 2.9], OUT_X = [-2.9, -2.6];      // shell nozzles (top-right in, bottom-left out)

export const EXCHANGER_VIEW = {
  camera: { fov: 26, position: [-3.9, 4.05, 11.5], target: [0.1, -0.15, 0] },
  refAspect: 1.9,
  drift: (t) => ({ yaw: Math.sin(t * 0.05) * 0.08, pitch: Math.sin(t * 0.04) * 0.03 }),
  speed: 1,
};

/* ---------------------------------------------------------- shell-side flow field */

function solveShellFlow() {
  const NX = 240, NY = 72, R = RS - 0.03;
  const x = (i) => lerp(XS, XE, i / (NX - 1)), y = (j) => lerp(-R, R, j / (NY - 1));
  const psi = new Float32Array(NX * NY), fixed = new Uint8Array(NX * NY);
  const set = (i, j, v) => { psi[j * NX + i] = v; fixed[j * NX + i] = 1; };
  for (let i = 0; i < NX; i++) {
    const X = x(i);
    set(i, NY - 1, X < IN_X[0] ? 1 : X > IN_X[1] ? 0 : 1 - (X - IN_X[0]) / (IN_X[1] - IN_X[0]));   // top wall + inlet
    set(i, 0, X > OUT_X[1] ? 0 : X < OUT_X[0] ? 1 : (OUT_X[1] - X) / (OUT_X[1] - OUT_X[0]));      // bottom wall + outlet
  }
  for (let j = 0; j < NY; j++) { set(0, j, 1); set(NX - 1, j, 0); }                                // tube sheets
  BAF.forEach((bx, k) => {
    const i = Math.round(((bx - XS) / (XE - XS)) * (NX - 1));
    const windowTop = k % 2 === 0;
    for (let j = 0; j < NY; j++) {
      const Y = y(j);
      if (windowTop && Y < BCUT) set(i, j, 0);       // baffle hangs from the bottom (ψ of bottom wall)
      if (!windowTop && Y > -BCUT) set(i, j, 1);     // baffle hangs from the top (ψ of top wall)
    }
  });
  for (let i = 1; i < NX - 1; i++) for (let j = 1; j < NY - 1; j++) if (!fixed[j * NX + i]) psi[j * NX + i] = 0.5;
  const w = 1.9;
  for (let it = 0; it < 700; it++) {
    for (let j = 1; j < NY - 1; j++) for (let i = 1; i < NX - 1; i++) {
      const k = j * NX + i;
      if (fixed[k]) continue;
      psi[k] += w * (0.25 * (psi[k - 1] + psi[k + 1] + psi[k - NX] + psi[k + NX]) - psi[k]);
    }
  }
  // velocity: flow runs from the right inlet to the left outlet
  const dx = (XE - XS) / (NX - 1), dy = (2 * R) / (NY - 1);
  const U = new Float32Array(NX * NY), V = new Float32Array(NX * NY);
  for (let j = 1; j < NY - 1; j++) for (let i = 1; i < NX - 1; i++) {
    const k = j * NX + i;
    U[k] = -(psi[k + NX] - psi[k - NX]) / (2 * dy);
    V[k] = (psi[k + 1] - psi[k - 1]) / (2 * dx);
  }
  const vel = (X, Y, out) => {
    const fi = clamp((X - XS) / dx, 0, NX - 1.001), fj = clamp((Y + R) / dy, 0, NY - 1.001);
    const i = fi | 0, j = fj | 0, a = fi - i, b = fj - j, k = j * NX + i;
    out[0] = (U[k] * (1 - a) + U[k + 1] * a) * (1 - b) + (U[k + NX] * (1 - a) + U[k + NX + 1] * a) * b;
    out[1] = (V[k] * (1 - a) + V[k + 1] * a) * (1 - b) + (V[k + NX] * (1 - a) + V[k + NX + 1] * a) * b;
    return out;
  };
  return { vel, R };
}

/* ---------------------------------------------------------- mount */

export function mountExchanger(el, opts = {}) {
  const stage = opts.stage || new Stage(el, { ...EXCHANGER_VIEW, ...opts, hud: false });
  const { scene } = stage;
  const rand = rng(61);
  const Yv = new THREE.Vector3(0, 1, 0), Zv = new THREE.Vector3(0, 0, 1);

  const camDir = Math.atan2(stage.basePos.z - stage.target.z, stage.basePos.y - stage.target.y);
  const CUT = 1.0;
  const th0 = camDir + CUT, th1 = camDir + Math.PI * 2 - CUT;
  const cutLathe = (poly, seg = 110) => mergeParts([latheX([...poly, poly[0]], seg, th0, th1), capAt(poly, th0), capAt(poly, th1)]);

  /* shell + channel heads, all cut away ------------------------------------------------ */
  const F = 0.14, FR = RS + 0.26;
  const shell = [[XS, RS], [XE, RS], [XE, FR], [XE - F, FR], [XE - F, RS + WALL], [XS + F, RS + WALL], [XS + F, FR], [XS, FR]];
  const headPoly = (x0, dir) => {
    const outer = [[x0, FR], [x0 + dir * 0.12, FR], [x0 + dir * 0.12, RS + WALL], [x0 + dir * 0.6, RS + WALL]];
    for (let i = 1; i <= 14; i++) { const a = (i / 14) * Math.PI / 2; outer.push([x0 + dir * (0.6 + 0.44 * Math.sin(a)), (RS + WALL) * Math.cos(a)]); }
    const inner = [];
    for (let i = 14; i >= 1; i--) { const a = (i / 14) * Math.PI / 2; inner.push([x0 + dir * (0.6 + 0.38 * Math.sin(a)), RS * Math.cos(a)]); }
    inner.push([x0 + dir * 0.6, RS], [x0, RS]);
    const p = [...outer, ...inner];
    return dir > 0 ? p : p.reverse();
  };
  const hL = headPoly(XS, -1), hR = headPoly(XE, 1);
  scene.add(stage.wire(mergeParts([cutLathe(shell, 120), cutLathe(hL, 90), cutLathe(hR, 90)]), { crease: 24 }));
  scene.add(lines(stage, [...sectionHatch(shell, th0, th1, 0.035), ...sectionHatch(hL, th0, th1, 0.035), ...sectionHatch(hR, th0, th1, 0.035)], stage.mat.hatch));
  const bolts = [];
  for (const xf of [XS - 0.002, XE + 0.002, XS - 0.122, XE + 0.122]) for (let k = 0; k < 36; k++) {
    const a = th0 + ((k + 0.5) / 36) * (th1 - th0);
    circleSegments(bolts, new THREE.Vector3(xf, Math.cos(a) * (RS + 0.16), Math.sin(a) * (RS + 0.16)), Yv, Zv, 0.026, 10);
  }
  scene.add(lines(stage, bolts, stage.mat.dim));

  // nozzles (tube side on the heads, shell side on the shell) + saddles
  const noz = (x, dir) => {
    const y0 = dir * (RS + WALL - 0.08);
    const g = new THREE.CylinderGeometry(0.2, 0.2, 0.62, 32, 1, true); g.translate(x, y0 + dir * 0.31, 0);
    const fl = new THREE.CylinderGeometry(0.31, 0.31, 0.07, 32, 1); fl.translate(x, y0 + dir * 0.6, 0);
    return [g, fl];
  };
  const saddle = (x) => {
    const s = new THREE.Shape();
    s.moveTo(-0.9, -1.65); s.lineTo(0.9, -1.65); s.lineTo(0.9, -1.55); s.lineTo(0.75, -1.5); s.lineTo(0.75, -0.68);
    s.absarc(0, 0, RS + WALL + 0.01, -Math.PI / 2 + 0.78, -Math.PI / 2 - 0.78, true);
    s.lineTo(-0.75, -1.5); s.lineTo(-0.9, -1.55); s.lineTo(-0.9, -1.65);
    const g = new THREE.ExtrudeGeometry(s, { depth: 0.16, bevelEnabled: false, curveSegments: 24 });
    g.translate(0, 0, -0.08); g.rotateY(Math.PI / 2); g.translate(x, 0, 0);
    return g;
  };
  scene.add(stage.wire(mergeParts([...noz(-3.62, 1), ...noz(3.62, -1), ...noz(2.75, 1), ...noz(-2.75, -1), saddle(-2.0), saddle(2.0)]), { crease: 26 }));

  /* tube bundle, tube sheets, baffles, tie rods ------------------------------------------- */
  const tubes = [];
  const PITCH = 0.27;
  for (let i = -5; i <= 5; i++) for (let j = -5; j <= 5; j++) {
    const y = i * PITCH * 0.866, z = (j + (i % 2 ? 0.5 : 0)) * PITCH;
    if (Math.hypot(y, z) < RS - 0.17) tubes.push([y, z]);
  }
  const tubeG = new THREE.CylinderGeometry(TUBE_R, TUBE_R, XE - XS, 12, 1, true); tubeG.rotateZ(Math.PI / 2);
  scene.add(stage.wire(mergeParts(tubes.map(([y, z]) => tubeG.clone().translate(0, y, z))),
    { faces: false, material: stage.lineMaterial({ width: 1.0, opacity: 0.34 }), crease: 40 }));
  const sheet = [];
  for (const x of [XS + 0.001, XE - 0.001]) {
    circleSegments(sheet, new THREE.Vector3(x, 0, 0), Yv, Zv, RS, 96);
    for (const [y, z] of tubes) circleSegments(sheet, new THREE.Vector3(x, y, z), Yv, Zv, TUBE_R + 0.01, 10);
  }
  scene.add(lines(stage, sheet, stage.mat.line));
  const baf = [], bafHoles = [];
  BAF.forEach((x, k) => {
    const top = k % 2 === 0, yc = top ? BCUT : -BCUT;
    const seg = [];
    for (let i = 0; i <= 96; i++) {
      const a = (i / 96) * Math.PI * 2, y = Math.cos(a) * (RS - 0.01), z = Math.sin(a) * (RS - 0.01);
      if ((top && y > yc) || (!top && y < yc)) continue;
      seg.push([y, z]);
    }
    for (let i = 0; i + 1 < seg.length; i++) baf.push(x, seg[i][0], seg[i][1], x, seg[i + 1][0], seg[i + 1][1]);
    const zc = Math.sqrt((RS - 0.01) ** 2 - yc * yc);
    baf.push(x, yc, -zc, x, yc, zc);
    for (const [y, z] of tubes) if ((top && y < yc - 0.03) || (!top && y > yc + 0.03)) circleSegments(bafHoles, new THREE.Vector3(x, y, z), Yv, Zv, TUBE_R + 0.01, 8);
  });
  scene.add(lines(stage, baf, stage.mat.line));
  scene.add(lines(stage, bafHoles, stage.mat.dim));
  const rods = [];
  for (const [y, z] of [[0.72, 0.42], [-0.72, -0.42], [0.1, -0.86], [-0.1, 0.86]]) rods.push(XS, y, z, XE, y, z);
  scene.add(lines(stage, rods, stage.mat.faint));

  /* tube side: nozzle -> head -> tube -> head -> nozzle -------------------------------------- */
  const perTube = 10, NT = tubes.length * perTube, KT = 12, HT = 0.05;
  const tRib = trailRibbons(stage, NT, KT, { width: 2.0, ghost: 0.35, intensity: 1.2 });
  scene.add(tRib.mesh);
  const LH = 1.05;                           // path length through each head
  const LTOT = LH + (XE - XS) + LH;
  const bez = (a, b, c, u, out) => { const v = 1 - u; for (let k = 0; k < 3; k++) out[k] = v * v * a[k] + 2 * v * u * b[k] + u * u * c[k]; return out; };
  const tubePath = (ti, s, out) => {
    const [ty, tz] = tubes[ti];
    if (s < LH) return bez([-3.62, RS + 0.35, 0], [-3.6, ty * 0.4, tz * 0.4], [XS, ty, tz], s / LH, out);
    if (s < LH + (XE - XS)) { out[0] = XS + (s - LH); out[1] = ty; out[2] = tz; return out; }
    return bez([XE, ty, tz], [3.6, ty * 0.4, tz * 0.4], [3.62, -(RS + 0.35), 0], (s - LH - (XE - XS)) / LH, out);
  };
  const tubeT = (s) => clamp(0.98 - 0.5 * clamp((s - LH) / (XE - XS), 0, 1), 0, 1);
  const TS = new Float32Array(NT);
  for (let i = 0; i < NT; i++) TS[i] = rand() * LTOT;
  const speedAt = (s) => (s < LH || s > LH + (XE - XS) ? 0.55 : 1.2);

  /* shell side: advected through the solved field ------------------------------------------ */
  const field = solveShellFlow();
  const NS = opts.particles || 1300, KS = 16, HS = 0.045;
  const sRib = trailRibbons(stage, NS, KS, { width: 1.5, ghost: 0.35, intensity: 1.0 });
  scene.add(sRib.mesh);
  const SP = new Float32Array(NS * 4);   // x, y, zFrac, phase
  const spawnS = (i, any) => {
    if (any) { SP[i * 4] = lerp(-3.1, 3.1, rand()); SP[i * 4 + 1] = lerp(-0.9, 0.9, rand()); }
    else { SP[i * 4] = lerp(IN_X[0] + 0.03, IN_X[1] - 0.03, rand()); SP[i * 4 + 1] = field.R - 0.02; }
    SP[i * 4 + 2] = rand() * 2 - 1; SP[i * 4 + 3] = rand() * 6.28;
  };
  for (let i = 0; i < NS; i++) spawnS(i, true);
  const vtmp = [0, 0];
  const SPEED = 0.55;
  const xy = [0, 0];                          // RK2 step in place (no per-sample allocations)
  const step2D = (x, y, h) => {
    field.vel(x, y, vtmp);
    const mx = x + vtmp[0] * SPEED * h * 0.5, my = y + vtmp[1] * SPEED * h * 0.5;
    field.vel(mx, my, vtmp);
    xy[0] = x + vtmp[0] * SPEED * h; xy[1] = y + vtmp[1] * SPEED * h;
    return xy;
  };
  const shellT = (x) => clamp(0.02 + 0.55 * (XE - x) / (XE - XS), 0, 1);
  const P3 = [0, 0, 0];
  const place = (x, y, zf, ph, out, o) => {
    const yy = y + 0.018 * Math.sin(x * 31 + ph);                      // weaving through the bundle
    const zmax = Math.sqrt(Math.max(0, (RS - 0.08) ** 2 - yy * yy));
    out[o] = x; out[o + 1] = yy; out[o + 2] = zf * zmax + 0.018 * Math.cos(x * 27 + ph);
  };

  /* channel heads: slow, churning plenum fluid (hot in the inlet head, cooled in the outlet head) --- */
  const NHP = 320, KH = 12, HH = 0.09;
  const hRib = trailRibbons(stage, 2 * NHP, KH, { width: 1.5, ghost: 0.3 });
  scene.add(hRib.mesh);
  const inHead = (side) => {                          // random point inside a channel head (not in the dish rim)
    const x = side < 0 ? lerp(XS - 0.85, XS - 0.12, rand()) : lerp(XE + 0.12, XE + 0.85, rand());
    const depth = Math.abs(x - (side < 0 ? XS : XE));
    const rmax = depth < 0.6 ? RS - 0.08 : (RS - 0.08) * Math.cos(Math.asin(clamp((depth - 0.6) / 0.38, 0, 1)));
    const r = Math.sqrt(rand()) * rmax, a = rand() * Math.PI * 2;
    return [x, r * Math.cos(a), r * Math.sin(a)];
  };
  const headPaths = [];
  const newHeadPath = (side) => {
    const [ty, tz] = tubes[Math.floor(rand() * tubes.length)];
    const noz = side < 0 ? [-3.62, RS + 0.25, 0] : [3.62, -(RS + 0.25), 0];
    const mid = inHead(side), mid2 = inHead(side);
    const face = side < 0 ? [XS - 0.01, ty, tz] : [XE + 0.01, ty, tz];
    // inlet head: nozzle -> wander -> tube entry ; outlet head: tube exit -> wander -> nozzle
    const P = side < 0 ? [noz, mid, mid2, face] : [face, mid, mid2, noz];
    return { c: new THREE.CatmullRomCurve3(P.map((p) => new THREE.Vector3(...p))), u: rand(), v: 0.07 + rand() * 0.06, side };
  };
  for (let i = 0; i < 2 * NHP; i++) headPaths.push(newHeadPath(i < NHP ? -1 : 1));
  const HV = new THREE.Vector3();

  stage.onUpdate((t, dt) => {
    const HD = hRib.data;
    for (let i = 0; i < headPaths.length; i++) {
      let Hp = headPaths[i];
      Hp.u += Hp.v * dt;
      if (Hp.u > 1) { Hp = headPaths[i] = newHeadPath(Hp.side); Hp.u = 0; }
      const fa = Math.floor(99 * smoothstep(0, 0.12, Hp.u) * (1 - smoothstep(0.88, 1, Hp.u)));
      const q = Hp.side < 0 ? 0.97 : 0.47;
      for (let k = 0; k < KH; k++) {
        Hp.c.getPoint(clamp(Hp.u - k * HH * Hp.v, 0, 1), HV);
        const o = (i * KH + k) * 4;
        HD[o] = HV.x; HD[o + 1] = HV.y; HD[o + 2] = HV.z; HD[o + 3] = fa + q * 0.999;
      }
    }
    hRib.commit();

    const A = tRib.data;
    for (let i = 0; i < NT; i++) {
      TS[i] += speedAt(TS[i]) * dt;
      if (TS[i] > LTOT) TS[i] -= LTOT;
      const ti = Math.floor(i / perTube);
      const fa = Math.floor(99 * smoothstep(0, 0.25, TS[i]) * (1 - smoothstep(LTOT - 0.25, LTOT, TS[i])));
      let s = TS[i];
      for (let k = 0; k < KT; k++) {
        tubePath(ti, s, P3);
        const o = (i * KT + k) * 4;
        A[o] = P3[0]; A[o + 1] = P3[1]; A[o + 2] = P3[2]; A[o + 3] = fa + tubeT(s) * 0.999;
        s = Math.max(0, s - speedAt(s) * HT);
      }
    }
    tRib.commit();

    const B = sRib.data;
    for (let i = 0; i < NS; i++) {
      step2D(SP[i * 4], SP[i * 4 + 1], dt);
      let x = xy[0], y = xy[1];
      const out = x < XS + 0.05 || x > XE - 0.02 || y < -field.R + 0.02 || (y > field.R && x < IN_X[0]);
      if (out) { spawnS(i, false); x = SP[i * 4]; y = SP[i * 4 + 1]; }
      SP[i * 4] = x; SP[i * 4 + 1] = y;
      const zf = SP[i * 4 + 2], ph = SP[i * 4 + 3];
      const fa = Math.floor(99 * smoothstep(-field.R + 0.02, -field.R + 0.25, y) * smoothstep(field.R + 0.01, field.R - 0.2, y));
      let bx = x, by = y;
      for (let k = 0; k < KS; k++) {
        const o = (i * KS + k) * 4;
        place(bx, by, zf, ph, B, o);
        B[o + 3] = fa + shellT(bx) * 0.999;
        step2D(bx, by, -HS); bx = xy[0]; by = xy[1];         // integrate backwards for the trail
      }
    }
    sRib.commit();
  });

  return stage;
}
