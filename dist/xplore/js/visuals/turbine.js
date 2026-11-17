/*
 * XV-01 — Turbine section of a civil two-spool turbofan, quarter cut-away.
 * 1-stage HPT + transition duct + 4-stage LPT on concentric HP / LP shafts.
 * Blade camber is generated from the same velocity-triangle model that advects the
 * particles, so the flow is turned by the rows it passes through.
 * Particle colour = static gas temperature (work extracted stage by stage).
 */
import {
  THREE, Stage, mergeParts, circleSegments, lines, centerline, hatchPolygon,
  gradientSRGB, rng, smoothstep, lerp, clamp, glowPoints, trailRibbons,
} from './core.js';

/* ------------------------------------------------------------ flow path */

const XS = -2.95, XE = 3.05;          // section inlet (station 4) / exit (station 5)
const DUCT0 = -1.95, DUCT1 = -1.05;   // HPT -> LPT transition duct

function hubR(x) {
  if (x < DUCT0) return 1.22;
  if (x < DUCT1) return lerp(1.22, 1.42, smoothstep(DUCT0, DUCT1, x));
  return lerp(1.42, 1.5, (x - DUCT1) / (XE - DUCT1));
}
function tipR(x) {
  if (x < DUCT0) return 1.58;
  if (x < DUCT1) return lerp(1.58, 1.92, smoothstep(DUCT0, DUCT1, x));
  return 1.92 + 0.6 * Math.pow((x - DUCT1) / (XE - DUCT1), 0.92);
}
const rmAt = (x) => 0.5 * (hubR(x) + tipR(x));

/* Spools (rad/s, sim units): HP ≈ 2.75 × LP, like a real two-spool engine */
const W_HP = 1.1, W_LP = 0.4;

/* Rows: swirl = tangential velocity at mean radius, ramped across each row */
const ROWS = [
  { kind: 'stator', x0: -2.86, c: 0.38, n: 18, sIn: 0.0, sOut: 2.6, tmax: 0.2, cooled: true },
  { kind: 'rotor', x0: -2.36, c: 0.36, n: 28, sIn: 2.6, sOut: -0.2, tmax: 0.24, w: W_HP, cooled: true },
];
{
  let x = -1.02;
  const st = [[0.34, 18, 22], [0.36, 18, 24], [0.38, 20, 24], [0.4, 20, 26]];
  for (let k = 0; k < 4; k++) {
    const [c, ns, nr] = st[k];
    ROWS.push({ kind: 'stator', x0: x, c, n: ns, sIn: -0.2, sOut: 1.6, tmax: 0.11 });
    ROWS.push({ kind: 'rotor', x0: x + c + 0.12, c: c + 0.02, n: nr, sIn: 1.6, sOut: k === 3 ? 0.0 : -0.2, tmax: 0.12, w: W_LP, shroud: true });
    x += 2 * c + 0.3;
  }
}

function swirl(x) {
  let s = 0;
  for (const r of ROWS) s += (r.sOut - r.sIn) * smoothstep(r.x0, r.x0 + r.c, x);
  return s;
}
const area = (x) => tipR(x) ** 2 - hubR(x) ** 2;
const A_REF = area(-2.5);
// axial velocity: continuity, softened (density falls as the gas expands)
const vxAt = (x) => 0.9 * Math.pow(A_REF / area(x), 0.3);
const vthAt = (x, r) => (swirl(x) * rmAt(x)) / r;

/* Total temperature falls across each rotor; static T = T0 − V²/2cp */
function staticT(x, v2) {
  let t0 = 1.0;
  for (const r of ROWS) if (r.kind === 'rotor') t0 -= (r.w === W_HP ? 0.25 : 0.14) * smoothstep(r.x0, r.x0 + r.c, x);
  return t0 - 0.012 * v2;
}

/* Flow-field lookup tables (particles sample these instead of the analytic model) */
const LUT_N = 4096, LX0 = XS - 0.6, LX1 = XE + 0.2;
const L_HUB = new Float32Array(LUT_N), L_TIP = new Float32Array(LUT_N), L_SWRM = new Float32Array(LUT_N);
const L_VX = new Float32Array(LUT_N), L_T0 = new Float32Array(LUT_N);
for (let i = 0; i < LUT_N; i++) {
  const x = lerp(LX0, LX1, i / (LUT_N - 1));
  L_HUB[i] = hubR(x); L_TIP[i] = tipR(x); L_SWRM[i] = swirl(x) * rmAt(x); L_VX[i] = vxAt(x);
  L_T0[i] = staticT(x, 0);
}
let _li = 0, _lf = 0;
const lutAt = (x) => {
  let f = ((x - LX0) / (LX1 - LX0)) * (LUT_N - 1);
  f = f < 0 ? 0 : f > LUT_N - 1.001 ? LUT_N - 1.001 : f;
  _li = f | 0; _lf = f - _li;
};
const L = (a) => a[_li] + (a[_li + 1] - a[_li]) * _lf;

/* ------------------------------------------------------------ blades */

function bladeGeometry(row, nSpan = 6, nChord = 14) {
  const rotor = row.kind === 'rotor';
  const clr = rotor ? (row.shroud ? 0.058 : 0.022) : 0.0;
  const M = nChord * 2 - 2;
  const pos = [];
  const sections = [];
  const rAt = (x, eta) => hubR(x) + eta * (tipR(x) - clr - hubR(x));
  for (let j = 0; j < nSpan; j++) {
    const eta = j / (nSpan - 1);
    // integrate the camber line in unrolled (x, w = r·θ) coordinates
    const FINE = 100;
    const cx = [], cw = [], cm = [];
    let w = 0;
    for (let k = 0; k <= FINE; k++) {
      const x = row.x0 + (k / FINE) * row.c;
      const r = rAt(x, eta);
      const m = (vthAt(x, r) - (rotor ? row.w * r : 0)) / vxAt(x);
      if (k > 0) w += 0.5 * (m + cm[k - 1]) * (row.c / FINE);
      cx.push(x); cw.push(w); cm.push(m);
    }
    const wMid = cw[FINE / 2];
    const sample = (u) => {
      const f = u * FINE, i = Math.min(FINE - 1, Math.floor(f)), k = f - i;
      return [lerp(cx[i], cx[i + 1], k), lerp(cw[i], cw[i + 1], k) - wMid, lerp(cm[i], cm[i + 1], k)];
    };
    const upper = [], lower = [];
    for (let k = 0; k < nChord; k++) {
      const u = 0.5 - 0.5 * Math.cos((Math.PI * k) / (nChord - 1));
      const [x, wc, m] = sample(u);
      const yt = 5 * row.tmax * row.c *
        (0.2969 * Math.sqrt(u) - 0.126 * u - 0.3516 * u * u + 0.2843 * u ** 3 - 0.1036 * u ** 4);
      const nl = Math.hypot(1, m);
      upper.push([x - (m / nl) * yt, wc + yt / nl]);
      lower.push([x + (m / nl) * yt, wc - yt / nl]);
    }
    const loop = [...upper, ...lower.slice(1, -1).reverse()];
    const sec = loop.map(([x, w2]) => {
      const r = rAt(x, eta);
      const th = w2 / r;
      return new THREE.Vector3(x, r * Math.cos(th), r * Math.sin(th));
    });
    sections.push({ sec, loop });
  }
  for (let j = 0; j < nSpan - 1; j++) {
    const A = sections[j].sec, B = sections[j + 1].sec;
    for (let i = 0; i < M; i++) {
      const i2 = (i + 1) % M;
      pos.push(...A[i].toArray(), ...A[i2].toArray(), ...B[i2].toArray());
      pos.push(...A[i].toArray(), ...B[i2].toArray(), ...B[i].toArray());
    }
  }
  for (const j of [0, nSpan - 1]) {
    const { sec, loop } = sections[j];
    const tris = THREE.ShapeUtils.triangulateShape(loop.map(([x, w2]) => new THREE.Vector2(x, w2)), []);
    for (const t of tris) pos.push(...sec[t[0]].toArray(), ...sec[t[1]].toArray(), ...sec[t[2]].toArray());
  }
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));

  // HPT film-cooling: rows of short dashes near the leading edge (showerhead) and on the pressure side
  const holes = [];
  if (row.cooled) {
    for (const i of [0, 1, 2, M - 2, M - 5]) {
      for (let j = 0; j < nSpan - 1; j++) {
        const A = sections[j].sec[i], B = sections[j + 1].sec[i];
        for (let q = 0; q < 3; q++) {
          const a = A.clone().lerp(B, (q + 0.3) / 3), b = A.clone().lerp(B, (q + 0.55) / 3);
          holes.push(a.x, a.y, a.z, b.x, b.y, b.z);
        }
      }
    }
  }
  return { geometry: g, holes };
}

function bladeRow(row) {
  const { geometry, holes } = bladeGeometry(row);
  const parts = [];
  const hs = [];
  const m = new THREE.Matrix4(), v = new THREE.Vector3();
  for (let k = 0; k < row.n; k++) {
    m.makeRotationX((k / row.n) * Math.PI * 2);
    parts.push(geometry.clone().applyMatrix4(m));
    for (let i = 0; i < holes.length; i += 3) { v.set(holes[i], holes[i + 1], holes[i + 2]).applyMatrix4(m); hs.push(v.x, v.y, v.z); }
  }
  return { geometry: mergeParts(parts), holes: hs };
}

/* ------------------------------------------------------------ lathe utils */

// Lathe around world +X. Profile [[x, r], ...]; θ measured with y = r cosθ, z = r sinθ.
function latheX(profile, segments, th0 = 0, th1 = Math.PI * 2) {
  const pts = profile.map(([x, r]) => new THREE.Vector2(Math.max(r, 0), x));
  const g = new THREE.LatheGeometry(pts, segments, th0 - Math.PI / 2, th1 - th0);
  g.rotateZ(-Math.PI / 2);
  return g;
}

function capAt(poly, th) {
  const g = new THREE.ShapeGeometry(new THREE.Shape(poly.map(([x, r]) => new THREE.Vector2(x, r))));
  const p = g.attributes.position;
  const c = Math.cos(th), s = Math.sin(th);
  for (let i = 0; i < p.count; i++) {
    const x = p.getX(i), r = p.getY(i);
    p.setXYZ(i, x, r * c, r * s);
  }
  return g;
}

/* ------------------------------------------------------------ mount */

export const TURBINE_VIEW = {
  camera: { fov: 22, position: [-5.4, 4.6, 14.6], target: [0.2, -0.1, 0] },
  refAspect: 1.9,
  drift: (t) => ({ yaw: Math.sin(t * 0.035) * 0.06, pitch: Math.sin(t * 0.025) * 0.025 }),
  speed: 2.5,
};

export function mountTurbine(el, opts = {}) {
  const stage = opts.stage || new Stage(el, {
    ...TURBINE_VIEW,
    ...opts,
    hud: !opts.hud ? false : {
      id: 'XV-01 / TURBOMACHINERY',
      title: 'TURBOFAN TURBINE SECTION · 1 HPT + 4 LPT',
      rows: [['N2 HP', 'n2'], ['N1 LP', 'n1'], ['TET', 'tet'], ['PR T-T', 'pr']],
      colorbar: { label: 'GAS TEMPERATURE · K', ticks: ['780', '1 250', '1 720'] },
      time: '×1 / 1 600',
    },
  });
  const { scene } = stage;
  const Y = new THREE.Vector3(0, 1, 0), Z = new THREE.Vector3(0, 0, 1);

  /* rotor drum + concentric shafts ------------------------------------ */
  const BORE = 0.78;
  const drum = [[XS - 0.04, BORE], [XS - 0.04, hubR(XS)]];
  for (let i = 0; i <= 60; i++) { const x = lerp(XS, XE, i / 60); drum.push([x, hubR(x)]); }
  drum.push([XE + 0.04, hubR(XE)], [XE + 0.04, BORE], [XS - 0.04, BORE]);
  scene.add(stage.wire(latheX(drum, 128), { crease: 20 }));

  // HP shaft (tube) out the front, LP shaft through the middle, with couplings
  const hp = [[-4.05, 0.46], [-4.05, 0.64], [-3.62, 0.64], [-3.62, 0.72], [-3.5, 0.72], [-3.5, 0.64], [XS, 0.64], [XS, 0.46], [-4.05, 0.46]];
  scene.add(stage.wire(latheX(hp, 96), { crease: 20 }));
  const lp = [[-4.7, 0], [-4.7, 0.34], [-4.35, 0.34], [-4.35, 0.42], [-4.25, 0.42], [-4.25, 0.34], [4.1, 0.34],
    [4.1, 0.5], [4.24, 0.5], [4.24, 0.34], [4.75, 0.34], [4.75, 0]];
  scene.add(stage.wire(latheX(lp, 80), { crease: 20 }));

  const det = [];
  for (const r of ROWS) {
    for (const x of [r.x0 - 0.05, r.x0 + r.c + 0.05]) circleSegments(det, new THREE.Vector3(x, 0, 0), Y, Z, hubR(x) + 0.002, 128);
  }
  for (const [xf, rr, nb] of [[XS - 0.042, 1.0, 24], [XE + 0.042, 1.14, 28], [4.099, 0.42, 10]]) {
    for (let k = 0; k < nb; k++) {
      const a = (k / nb) * Math.PI * 2;
      circleSegments(det, new THREE.Vector3(xf, Math.cos(a) * rr, Math.sin(a) * rr), Y, Z, 0.028, 12);
    }
  }
  scene.add(lines(stage, det, stage.mat.dim));

  /* blade rows (HP / LP spools) --------------------------------------- */
  const hpSpool = new THREE.Group(), lpSpool = new THREE.Group();
  scene.add(hpSpool, lpSpool);
  const shrouds = [];
  for (const row of ROWS) {
    const { geometry, holes } = bladeRow(row);
    const w = stage.wire(geometry, { crease: 38 });
    if (holes.length) w.add(lines(stage, holes, stage.mat.dim));
    if (row.kind === 'stator') scene.add(w);
    else (row.w === W_HP ? hpSpool : lpSpool).add(w);
    if (row.shroud) {
      // interlocking tip shroud with two knife-edge seal fins
      const xa = row.x0 - 0.03, xb = row.x0 + row.c + 0.03, T = (x) => tipR(x);
      const prof = [];
      for (let i = 0; i <= 8; i++) { const x = lerp(xa, xb, i / 8); prof.push([x, T(x) - 0.058]); }
      const top = [];
      const fin = (xc) => { const x0 = xc - 0.03, x1 = xc + 0.03; top.push([x1, T(x1) - 0.022], [xc, T(xc) - 0.004], [x0, T(x0) - 0.022]); };
      top.push([xb, T(xb) - 0.022]);
      fin(lerp(xa, xb, 0.72)); fin(lerp(xa, xb, 0.3));
      top.push([xa, T(xa) - 0.022]);
      shrouds.push([...prof, ...top, prof[0]]);
    }
  }

  /* casing, quarter cut facing the camera ------------------------------ */
  const camDir = Math.atan2(stage.basePos.z - stage.target.z, stage.basePos.y - stage.target.y);
  const CUT = 1.12;
  const th0 = camDir + CUT, th1 = camDir + Math.PI * 2 - CUT;
  const CX0 = XS - 0.04, CX1 = XE + 0.04, wall = 0.12;
  const outerR = (x) => tipR(clamp(x, XS, XE)) + wall;
  const inner = [];
  for (let i = 0; i <= 60; i++) { const x = lerp(CX0, CX1, i / 60); inner.push([x, tipR(clamp(x, XS, XE))]); }
  // flanges: [x0, x1, height], sorted right -> left
  const F = [[CX1 - 0.12, CX1, 0.34], [-1.22, -1.08, 0.3], [CX0, CX0 + 0.12, 0.36]];
  const outer = [];
  const ribs = ROWS.filter((r) => r.kind === 'rotor').map((r) => r.x0 + r.c * 0.5);
  const run = (xa, xb) => {
    for (let i = 0; i <= 24; i++) {
      const x = lerp(xa, xb, i / 24), xn = lerp(xa, xb, (i + 1) / 24);
      if (!ribs.some((xr) => Math.abs(x - xr) < 0.036)) outer.push([x, outerR(x)]);
      if (i < 24) for (const xr of ribs) {
        if (xr + 0.035 <= x && xr + 0.035 > xn) {
          const h = 0.07;
          outer.push([xr + 0.035, outerR(xr + 0.035)], [xr + 0.035, outerR(xr + 0.035) + h], [xr - 0.035, outerR(xr - 0.035) + h], [xr - 0.035, outerR(xr - 0.035)]);
        }
      }
    }
  };
  outer.push([CX1, outerR(CX1) + F[0][2]], [F[0][0], outerR(F[0][0]) + F[0][2]]);
  run(F[0][0], F[1][1]);
  outer.push([F[1][1], outerR(F[1][1]) + F[1][2]], [F[1][0], outerR(F[1][0]) + F[1][2]]);
  run(F[1][0], F[2][1]);
  outer.push([F[2][1], outerR(F[2][1]) + F[2][2]], [CX0, outerR(CX0) + F[2][2]]);
  const poly = [...inner, ...outer];
  scene.add(stage.wire(mergeParts([latheX([...poly, poly[0]], 120, th0, th1), capAt(poly, th0), capAt(poly, th1)]), { crease: 24 }));

  // shrouds are axisymmetric, so they can stay static and be cut with the casing
  scene.add(stage.wire(mergeParts(shrouds.map((sp) => latheX(sp, 110, th0, th1))), { crease: 20 }));

  const hatch = [];
  for (const th of [th0, th1]) {
    const c = Math.cos(th), s = Math.sin(th);
    for (const [x0, r0, x1, r1] of hatchPolygon(poly, 0.042)) hatch.push(x0, r0 * c, r0 * s, x1, r1 * c, r1 * s);
  }
  scene.add(lines(stage, hatch, stage.mat.hatch));
  const bolts = [];
  for (const [xf, rr, nb] of [[CX0 - 0.002, outerR(XS) + 0.2, 40], [CX1 + 0.002, outerR(XE) + 0.18, 56], [-1.22 - 0.002, outerR(-1.22) + 0.16, 44]]) {
    for (let k = 0; k < nb; k++) {
      const a = th0 + ((k + 0.5) / nb) * (th1 - th0);
      circleSegments(bolts, new THREE.Vector3(xf, Math.cos(a) * rr, Math.sin(a) * rr), Y, Z, 0.03, 12);
    }
  }
  scene.add(lines(stage, bolts, stage.mat.dim));

  // engine centreline (drawn over everything, like a drawing)
  scene.add(lines(stage, centerline([], new THREE.Vector3(-5.3, 0, 0), new THREE.Vector3(5.4, 0, 0)),
    stage.lineMaterial({ width: 1, opacity: 0.28, depthTest: false })));

  /* particles ---------------------------------------------------------- */
  const N = opts.particles || 3200;
  const K = 20, H = 0.024;
  const rand = rng(7);
  const P = new Float32Array(N * 3); // x, eta, theta
  // the gas arrives straight from the combustor: particles start a little upstream of the first vanes,
  // where there's no swirl yet, and only turn once the vanes turn them
  const X_IN = XS - 0.36;
  const spawn = (i, anywhere) => {
    P[i * 3] = anywhere ? lerp(X_IN, XE, rand()) : X_IN - rand() * 0.04;
    P[i * 3 + 1] = 0.04 + 0.92 * rand();
    P[i * 3 + 2] = rand() * Math.PI * 2;
  };
  for (let i = 0; i < N; i++) spawn(i, true);

  const ribbons = trailRibbons(stage, N, K, { width: 1.5 });   // no x-ray pass: through the flange it showed the swirl inside as if it came in curved
  scene.add(ribbons.mesh);
  const TD = ribbons.data;
  const heads = glowPoints(N, { core: 0.5 });
  heads.renderOrder = 3;
  scene.add(heads);
  const hpA = heads.geometry.attributes.position.array;
  const hc = heads.geometry.attributes.color.array;
  const hs = heads.geometry.attributes.size.array;
  const ha = heads.geometry.attributes.alpha.array;

  const T_MIN = 0.16, T_MAX = 0.99;
  const col = [0, 0, 0];
  const fade = (x) => smoothstep(X_IN, XS - 0.06, x) * (1 - smoothstep(XE - 0.35, XE, x));

  stage.onUpdate((t, dt) => {
    hpSpool.rotation.x = W_HP * t;
    lpSpool.rotation.x = W_LP * t;
    heads.material.uniforms.uScale.value = stage.pointScale;

    const sub = 4, h = dt / sub;
    for (let i = 0; i < N; i++) {
      let x = P[i * 3];
      const eta = P[i * 3 + 1];
      let th = P[i * 3 + 2];
      for (let s = 0; s < sub; s++) {
        lutAt(x);
        const hb = L(L_HUB), r = hb + eta * (L(L_TIP) - hb);
        th += (L(L_SWRM) / (r * r)) * h;
        x += L(L_VX) * h;
      }
      if (x > XE) { spawn(i, false); x = P[i * 3]; th = P[i * 3 + 2]; }
      P[i * 3] = x; P[i * 3 + 2] = th;

      const fi = fade(x);
      const aCode = Math.floor(fi * 99);
      let xk = x, tk = th, q0 = 0;
      for (let k = 0; k < K; k++) {
        lutAt(xk);
        const hb = L(L_HUB), r = hb + eta * (L(L_TIP) - hb);
        const vx = L(L_VX), vt = L(L_SWRM) / r;
        const q = (L(L_T0) - 0.012 * (vx * vx + vt * vt) - T_MIN) / (T_MAX - T_MIN);
        if (k === 0) q0 = q;
        const o = (i * K + k) * 4;
        TD[o] = xk;
        TD[o + 1] = r * Math.cos(tk);
        TD[o + 2] = r * Math.sin(tk);
        TD[o + 3] = aCode + clamp(q, 0, 1) * 0.999;
        const xn = xk - vx * H;
        if (xn >= X_IN) { xk = xn; tk -= (vt / r) * H; }
      }
      lutAt(x);
      const hb0 = L(L_HUB), r0 = hb0 + eta * (L(L_TIP) - hb0);
      hpA[i * 3] = x; hpA[i * 3 + 1] = r0 * Math.cos(th); hpA[i * 3 + 2] = r0 * Math.sin(th);
      gradientSRGB(q0, col);
      hc[i * 3] = col[0]; hc[i * 3 + 1] = col[1]; hc[i * 3 + 2] = col[2];
      hs[i] = 0.045;
      ha[i] = 0.65 * fi;
    }
    ribbons.commit();
    for (const k of ['position', 'color', 'size', 'alpha']) heads.geometry.attributes[k].needsUpdate = true;

    if (stage.hud) {
      const j = Math.sin(t * 0.65) * 0.5 + Math.sin(t * 1.55) * 0.3;
      const fmt = (v) => v.toFixed(0).replace(/\B(?=(\d{3})+$)/g, ' ');
      stage.hud.set('n2', `${fmt(14520 + j * 8)} RPM`);
      stage.hud.set('n1', `${fmt(5280 + j * 3)} RPM`);
      stage.hud.set('tet', `${(1712 + j * 2.2).toFixed(1)} K`);
      stage.hud.set('pr', (6.84 + j * 0.006).toFixed(3));
    }
  });

  return stage;
}
