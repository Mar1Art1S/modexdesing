/*
 * XV-02 — The Rolls-Royce Merlin, the V12 of the Spitfire, Hurricane, Lancaster and Mustang.
 * 27 litres in two banks of six at 60°, 5.4 in bore by 6.0 in stroke, built here at 1 unit ≈ 0.19 m.
 * The crankshaft is an inline-six's, each pin carrying a fork rod and a blade rod (the blade runs
 * inside the fork), so the two banks sit exactly opposite each other; the twelve cylinders fire
 * evenly every 60° of crank. One overhead camshaft per bank, driven by an inclined shaft from the
 * rear, works the four valves of each cylinder through rocker arms; two plugs per cylinder.
 * At the front the 0.42:1 reduction gear lifts the propeller shaft above the crank; at the back the
 * two-stage supercharger feeds the induction manifold in the V; the exhaust leaves through the six
 * ejector stubs on each side, which on the aeroplane added thrust.
 * Exact slider-crank kinematics in each bank; charge particles in each bore coloured by gas
 * temperature through the 4-stroke cycle, with flame-front propagation from the plugs.
 */
import {
  THREE, Stage, mergeParts, circleSegments, lines, centerline, glowPoints, latheX, hatchPolygon,
  gradientSRGB, rng, smoothstep, clamp, lerp, LineSegments2, LineSegmentsGeometry, FX,
} from './core.js';

const RC = 0.4;           // crank throw (76 mm)
const LROD = 1.9;         // con-rod centre distance
const PITCH = 0.9;        // bore spacing
const NCYL = 6;           // per bank
const BORE_R = 0.36, PISTON_R = 0.343;
const PIN_TOP = 0.36;     // piston crown above wrist pin
const SKIRT = 0.3;        // skirt below wrist pin
const DECK_Y = RC + LROD + PIN_TOP + 0.08;
const LINER_Y0 = LROD - RC - SKIRT + 0.06;
const DEG = Math.PI / 180;
const BETA = 30 * DEG;    // each bank leans 30° from vertical: a 60° V
const PHASE = [0, 120, 240, 240, 120, 0].map((d) => d * DEG); // throw angle for cylinders 1..6
const FIRE = [0, 480, 240, 600, 120, 360];                     // inline-six ignition (deg, 720 cycle)
const BANKS = [
  { s: 1, name: 'A', fire: FIRE.map((f) => (f + 30) % 720) },   // fires 30° after the throw passes vertical
  { s: -1, name: 'B', fire: FIRE.map((f) => (f + 330) % 720) }, // and the opposite bank 300° later: even 60° firing
];
const ORDER = BANKS.flatMap((b, bi) => b.fire.map((f, i) => ({ f, label: `${i + 1}${b.name}`, k: bi * NCYL + i }))).sort((p, q) => p.f - q.f);
const REV_PER_S = 0.4;

/* SOHC 4-valve head: valves tilted ±TILT, worked by rockers off a central camshaft */
const TILT = 12 * DEG;
const VALVE_DX = 0.12, SEAT_Z = 0.13, STEM = 0.55, CAP_H = 0.06, CAM_R0 = 0.07, LIFT = 0.075;
const CAM_Y = DECK_Y + 0.64;
const LOBE_DX = { int: 0.04, exh: 0.2 };
const PIVOT = { y: CAM_Y + 0.13, z: 0.19 };
const VALVES = { exh: { c: 265, dur: 250 }, int: { c: 455, dur: 250 } };  // centre / duration, deg after ignition
function valveLift(a, v) {
  const d = ((((a - v.c) % 720) + 1080) % 720) - 360;
  return Math.abs(d) < v.dur / 2 ? LIFT * Math.cos((Math.PI * d) / v.dur) ** 2 : 0;
}

function gearShape(nt, ro, rr) {
  const s = new THREE.Shape();
  for (let k = 0; k < nt; k++) {
    const a0 = (k / nt) * Math.PI * 2, da = (Math.PI * 2) / nt;
    const pts = [[rr, a0], [ro, a0 + da * 0.25], [ro, a0 + da * 0.5], [rr, a0 + da * 0.75]];
    pts.forEach(([r, a], j) => (k === 0 && j === 0 ? s.moveTo(r * Math.cos(a), r * Math.sin(a)) : s.lineTo(r * Math.cos(a), r * Math.sin(a))));
  }
  return s;
}
const cylX = (i) => (i - (NCYL - 1) / 2) * PITCH;
const X_FRONT = cylX(0) - PITCH / 2 - 0.25, X_REAR = cylX(NCYL - 1) + PITCH / 2 + 0.25;
// bank-local (y along the bore, z across it) -> world
const toWorld = (s, y, z) => [y * Math.cos(s * BETA) - z * Math.sin(s * BETA), y * Math.sin(s * BETA) + z * Math.cos(s * BETA)];
const toLocal = (s, y, z) => [y * Math.cos(s * BETA) + z * Math.sin(s * BETA), -y * Math.sin(s * BETA) + z * Math.cos(s * BETA)];

/* ---------------------------------------------------------- part builders */

function cylX_(r, len, seg = 44) {
  const g = new THREE.CylinderGeometry(r, r, len, seg, 1);
  g.rotateZ(-Math.PI / 2);
  return g;
}

function webShape() {
  const s = new THREE.Shape();
  const a = 0.26, R = 0.62;
  const P = new THREE.Vector2(0, RC);
  const t0 = 18 * DEG, t1 = 162 * DEG;
  const cw0 = 204 * DEG, cw1 = 336 * DEG;
  s.moveTo(P.x + a * Math.cos(t0), P.y + a * Math.sin(t0));
  s.absarc(P.x, P.y, a, t0, t1, false);
  s.lineTo(R * Math.cos(cw0), R * Math.sin(cw0));
  s.absarc(0, 0, R, cw0, cw1, false);
  s.lineTo(P.x + a * Math.cos(t0), P.y + a * Math.sin(t0));
  return s;
}

function extrudeX(shape, depth, bevel = 0.012, curveSegments = 28) {
  const g = new THREE.ExtrudeGeometry(shape, {
    depth: depth - bevel * 2, bevelEnabled: bevel > 0, bevelThickness: bevel, bevelSize: bevel,
    bevelSegments: 1, curveSegments,
  });
  g.translate(0, 0, -(depth - bevel * 2) / 2);
  g.rotateY(Math.PI / 2); // extrusion axis -> world X
  return g;
}

function crankGeometry() {
  const parts = [];
  const web = extrudeX(webShape(), 0.09);
  const m = new THREE.Matrix4();
  for (let i = 0; i < NCYL; i++) {
    const x = cylX(i);
    const rot = new THREE.Matrix4().makeRotationX(-PHASE[i]);
    parts.push(cylX_(0.18, 0.3).applyMatrix4(m.makeTranslation(x, RC, 0)).applyMatrix4(rot));   // crank pin, wide for two rods
    for (const s of [-1, 1]) parts.push(web.clone().applyMatrix4(m.makeTranslation(x + s * 0.195, 0, 0)).applyMatrix4(rot));
  }
  for (let j = 0; j <= NCYL; j++) {                              // seven main journals
    const x = (j - NCYL / 2) * PITCH;
    parts.push(cylX_(0.22, PITCH - 0.48).applyMatrix4(m.makeTranslation(x, 0, 0)));
  }
  const xf = -(NCYL / 2) * PITCH - (PITCH - 0.48) / 2;
  parts.push(cylX_(0.15, 0.5).applyMatrix4(m.makeTranslation(xf - 0.25, 0, 0)));                // nose
  parts.push(extrudeX(gearShape(18, 0.31, 0.285), 0.16, 0.006, 4).applyMatrix4(m.makeTranslation(X_FRONT - 0.15, 0, 0)));   // reduction pinion
  parts.push(cylX_(0.12, 0.45).applyMatrix4(m.makeTranslation(-xf + 0.22, 0, 0)));              // tail, to the supercharger drive
  parts.push(extrudeX(gearShape(24, 0.22, 0.2), 0.06, 0.004, 4).applyMatrix4(m.makeTranslation(-xf + 0.4, 0, 0)));
  return mergeParts(parts);
}

// one camshaft per bank: four lobes per cylinder (two intake, two exhaust), all pushing up on rocker pads
function camshaftGeometry(bank) {
  const parts = [];
  const m = new THREE.Matrix4();
  const x0 = X_FRONT + 0.1, x1 = X_REAR - 0.05;
  parts.push(cylX_(0.045, x1 - x0, 24).applyMatrix4(m.makeTranslation((x0 + x1) / 2, 0, 0)));
  const phiV = 0;                                         // cam centre -> rocker pad: straight up the bank
  for (let i = 0; i < NCYL; i++) {
    for (const side of ['int', 'exh']) {
      const thMax = ((bank.fire[i] + VALVES[side].c) * Math.PI) / 180;
      const aNose = phiV - thMax / 2 + Math.PI / 2;       // extrudeX maps shape angle α to world φ = α − π/2
      const sh = new THREE.Shape();
      for (let k = 0; k <= 96; k++) {
        const a = (k / 96) * Math.PI * 2;
        const d = ((((a - aNose) * 180) / Math.PI) % 360 + 540) % 360 - 180;   // cam degrees from nose
        const r = CAM_R0 + valveLift(VALVES[side].c + 2 * d, VALVES[side]);
        k ? sh.lineTo(r * Math.cos(a), r * Math.sin(a)) : sh.moveTo(r * Math.cos(a), r * Math.sin(a));
      }
      for (const dx of [-LOBE_DX[side], LOBE_DX[side]]) parts.push(extrudeX(sh, 0.06, 0.004, 4).applyMatrix4(m.makeTranslation(cylX(i) + dx, 0, 0)));
    }
    parts.push(cylX_(0.065, 0.07, 28).applyMatrix4(m.makeTranslation(cylX(i) + PITCH / 2, 0, 0)));   // bearing journal
  }
  parts.push(extrudeX(gearShape(28, 0.2, 0.185), 0.05, 0.004, 4).applyMatrix4(m.makeTranslation(x1 - 0.06, 0, 0)));   // bevel drive at the rear
  return mergeParts(parts);
}

function valveGeometry() {
  const v = [[0, 0], [0.068, 0], [0.068, 0.012], [0.046, 0.028], [0.022, 0.07], [0.016, 0.1], [0.016, STEM], [0, STEM]];
  const b = [[0, STEM - 0.005], [0.04, STEM - 0.005], [0.04, STEM + CAP_H], [0, STEM + CAP_H]];
  return mergeParts([
    new THREE.LatheGeometry(v.map(([r, y]) => new THREE.Vector2(r, y)), 28),
    new THREE.LatheGeometry(b.map(([r, y]) => new THREE.Vector2(r, y)), 28),
  ]);
}

function springSegments(r = 0.04, h = 0.26, turns = 6, n = 96) {
  const out = [];
  for (let k = 0; k < n; k++) {
    const a0 = (k / n) * turns * Math.PI * 2, a1 = ((k + 1) / n) * turns * Math.PI * 2;
    out.push(r * Math.cos(a0), (k / n) * h, r * Math.sin(a0), r * Math.cos(a1), ((k + 1) / n) * h, r * Math.sin(a1));
  }
  return out;
}

/* ghost of the whole engine: crankcase, the two cylinder blocks and their cam covers, one section */
function engineProfile() {
  const W = 0.55, Y0 = 1.05, YT = DECK_Y + 1.2;
  const P = (s, y, z) => { const [wy, wz] = toWorld(s, y, z); return [wz, wy]; };
  const yValley = (W * Math.cos(BETA)) / Math.sin(BETA);   // inner bank wall meets the V centre
  const half = [
    [0, -1.1], [0.8, -1.1], [1.1, -0.35], [1.1, 0.55], P(1, Y0, W), P(1, DECK_Y - 0.05, W), P(1, DECK_Y + 0.05, W + 0.04),
    P(1, YT - 0.2, W + 0.04), P(1, YT, W - 0.15), P(1, YT + 0.08, 0), P(1, YT, -W + 0.15), P(1, YT - 0.2, -W - 0.04),
    P(1, DECK_Y + 0.05, -W - 0.04), P(1, yValley + 0.3, -W), [0, P(1, yValley, -W)[1]],
  ];
  const pts = [...half, ...half.slice(1, -1).reverse().map(([z, y]) => [-z, y])];
  return new THREE.Shape(pts.map(([z, y]) => new THREE.Vector2(z, y)));
}

/* Connecting rods: big end, tapered I-beam shank and small end, blended by concave fillets. */
const ROD = { RB: 0.28, RS: 0.14, wb: 0.085, ws: 0.055, RF1: 0.19, RF2: 0.12, HB: 0.19, HS: 0.08, T: 0.1 };

function arcPts(cx, cy, r, a0, a1, n = 16) {
  const out = [];
  for (let k = 0; k <= n; k++) { const a = a0 + ((a1 - a0) * k) / n; out.push([cx + r * Math.cos(a), cy + r * Math.sin(a)]); }
  return out;
}
const shortArc = (a0, a1) => { let d = a1 - a0; while (d > Math.PI) d -= 2 * Math.PI; while (d < -Math.PI) d += 2 * Math.PI; return a0 + d; };

function rodProfiles() {
  const { RB, RS, wb, ws, RF1, RF2 } = ROD;
  const slope = (ws - wb) / LROD;
  const xl = (y) => wb + slope * y;
  const nl = Math.hypot(1, slope), nx = 1 / nl, ny = -slope / nl;
  const fillet = (cy0, R, rf, lo, hi) => {
    const C = (y) => [xl(y) + nx * rf, y + ny * rf];
    const f = (y) => { const c = C(y); return Math.hypot(c[0], c[1] - cy0) - (R + rf); };
    for (let k = 0; k < 60; k++) { const m = (lo + hi) / 2; if (f(lo) * f(m) <= 0) hi = m; else lo = m; }
    const c = C((lo + hi) / 2);
    const k = R / (R + rf);
    return { c, onCircle: [c[0] * k, cy0 + (c[1] - cy0) * k], onLine: [c[0] - nx * rf, c[1] - ny * rf] };
  };
  const F1 = fillet(0, RB, RF1, 0, 0.8), F2 = fillet(LROD, RS, RF2, LROD - 0.7, LROD);
  const ang = (p, c) => Math.atan2(p[1] - c[1], p[0] - c[0]);
  const right = [
    ...arcPts(0, 0, RB, -Math.PI / 2, ang(F1.onCircle, [0, 0]), 24),
    ...arcPts(F1.c[0], F1.c[1], RF1, ang(F1.onCircle, F1.c), shortArc(ang(F1.onCircle, F1.c), ang(F1.onLine, F1.c)), 14).slice(1),
    ...arcPts(F2.c[0], F2.c[1], RF2, ang(F2.onLine, F2.c), shortArc(ang(F2.onLine, F2.c), ang(F2.onCircle, F2.c)), 12),
    ...arcPts(0, LROD, RS, ang(F2.onCircle, [0, LROD]), Math.PI / 2, 16).slice(1),
  ];
  const outline = [...right, ...right.slice(1, -1).reverse().map(([x, y]) => [-x, y])];
  const y0 = F1.onLine[1] + 0.07, y1 = F2.onLine[1] - 0.05;
  const h0 = xl(y0) - 0.032, h1 = xl(y1) - 0.028;
  const pocket = [[h0, y0], [h1, y1], ...arcPts(0, y1, h1, 0, Math.PI, 12).slice(1, -1), [-h1, y1], [-h0, y0],
    ...arcPts(0, y0, h0, Math.PI, 2 * Math.PI, 12).slice(1, -1)];
  return { outline, pocket };
}

// blade rod: one plate; fork rod: two plates straddling it on the same crank pin
function rodGeometry(fork) {
  const { outline, pocket } = rodProfiles();
  const v2 = (pts) => pts.map(([x, y]) => new THREE.Vector2(x, y));
  const plate = (t) => {
    const rim = new THREE.Shape(v2(outline));
    rim.holes.push(new THREE.Path(v2(pocket)));
    const h1 = new THREE.Path(); h1.absarc(0, 0, ROD.HB, 0, Math.PI * 2, true);
    const h2 = new THREE.Path(); h2.absarc(0, LROD, ROD.HS, 0, Math.PI * 2, true);
    rim.holes.push(h1, h2);
    return mergeParts([extrudeX(rim, t, 0.005, 32), extrudeX(new THREE.Shape(v2(pocket)), t * 0.4, 0, 16)]);
  };
  if (!fork) return plate(ROD.T * 0.9);
  const m = new THREE.Matrix4();
  return mergeParts([-1, 1].map((s) => plate(0.05).applyMatrix4(m.makeTranslation(s * 0.085, 0, 0))));
}

/* Pistons: forged, flat-topped, three compression rings and an oil-control ring above the pin, a scraper
   ring at the foot of the skirt; a hollow, fully floating gudgeon pin in two bosses held by circlips.
   Profiles are (r, y), y up the bore from the pin axis. */
const PIS = { gd: 0.024, go: 0.026, gs: 0.022, rp: 0.075, rpi: 0.045, rb: 0.12, xb: 0.125 };
const RING_GROOVES = [[0.284, 0.3, 'c'], [0.246, 0.262, 'c'], [0.208, 0.224, 'c'], [0.16, 0.184, 'o'], [-0.23, -0.21, 's']];
function pistonOuter() {                       // crown centre, over the edge, down the ring belt and skirt
  const R = PISTON_R, out = [[0, PIN_TOP], [R - 0.012, PIN_TOP], [R, PIN_TOP - 0.012]];
  for (const [y0, y1, k] of RING_GROOVES) {
    const d = k === 'c' ? PIS.gd : k === 'o' ? PIS.go : PIS.gs;
    out.push([R, y1], [R - d, y1], [R - d, y0], [R, y0]);
  }
  out.push([R, -SKIRT + 0.01], [R - 0.008, -SKIRT]);
  return out;
}
// the inside: a thick crown with a fillet into the ring belt, a thinner skirt thickening again at its foot
function pistonInner() {
  const R = PISTON_R, inn = [[R - 0.05, -SKIRT], [R - 0.05, -0.2], [R - 0.025, -0.19], [R - 0.025, 0.1], [R - 0.06, 0.15], [R - 0.06, 0.25]];
  for (let k = 1; k <= 6; k++) { const a = (k / 6) * (Math.PI / 2); inn.push([R - 0.1 + 0.04 * Math.cos(a), 0.25 + 0.04 * Math.sin(a)]); }
  inn.push([0, 0.29]);
  return inn;
}
// the pin's bore where it meets the skirt, drawn on the surface: bore, pin end and circlip
function pinBoreLines(out, side, zMax = Infinity) {
  const R = PISTON_R + 0.001;
  for (const rad of [PIS.rp + 0.012, PIS.rp, PIS.rpi]) {
    const n = 28;
    for (let k = 0; k < n; k++) {
      const a0 = (k / n) * Math.PI * 2, a1 = ((k + 1) / n) * Math.PI * 2;
      const p = (a) => { const z = rad * Math.cos(a), y = rad * Math.sin(a); return [side * Math.sqrt(R * R - z * z), y, z]; };
      const q0 = p(a0), q1 = p(a1);
      if (q0[2] <= zMax && q1[2] <= zMax) out.push(...q0, ...q1);
    }
  }
}

function pistonGeometry() {
  const prof = [[0, -SKIRT], ...pistonOuter().reverse()];
  return new THREE.LatheGeometry(prof.map(([r, y]) => new THREE.Vector2(r, y)), 56);
}

// a piston with the quarter toward the camera cut away (x < 0, z > 0 in bank coordinates): the ring belt,
// crown and skirt in section, the rings in their grooves, the near pin boss and its rib cut through, the
// far boss whole, the hollow pin cut along its length. Returns the geometry, the hatching of the cut faces
// and the detail lines (circlips, oil drain holes, the far pin bore)
function cutPistonGeometry() {
  const R = PISTON_R, { rp, rpi, rb, xb } = PIS;
  const outer = pistonOuter(), inner = pistonInner(), prof = [...outer, ...inner];
  const PH = 1.5 * Math.PI;                                       // lathe φ: x = r sin φ, z = r cos φ; keep 0..3π/2
  const lathe = (pr, seg = 44) => new THREE.LatheGeometry([...pr, pr[0]].map(([r, y]) => new THREE.Vector2(r, y)), seg, 0, PH);
  const v2 = (pts) => pts.map(([a, b]) => new THREE.Vector2(a, b));
  const capX0 = (poly) => {                                       // plane x = 0, the z > 0 side: (r, y) -> (0, y, r)
    const g = new THREE.ShapeGeometry(new THREE.Shape(v2(poly))), p = g.attributes.position;
    for (let k = 0; k < p.count; k++) p.setXYZ(k, 0, p.getY(k), p.getX(k));
    return g;
  };
  const capZ0 = (poly) => {                                       // plane z = 0, the x < 0 side: (u, y) -> (-u, y, 0)
    const g = new THREE.ShapeGeometry(new THREE.Shape(v2(poly))), p = g.attributes.position;
    for (let k = 0; k < p.count; k++) p.setXYZ(k, -p.getX(k), p.getY(k), 0);
    return g;
  };
  const hatch = [], det = [];
  const hX0 = (poly, sp, ang) => { for (const [r0, y0, r1, y1] of hatchPolygon(poly, sp, ang)) hatch.push(-0.002, y0, r0, -0.002, y1, r1); };
  const hZ0 = (poly, sp, ang) => { for (const [u0, y0, u1, y1] of hatchPolygon(poly, sp, ang)) hatch.push(-u0, y0, 0.002, -u1, y1, 0.002); };
  const parts = [lathe(prof, 56), capX0(prof)];
  hX0(prof, 0.022, Math.PI / 4);

  // through the pin axis the near boss and its rib join crown and skirt: one section above the pin, one below
  const iTop = outer.findIndex(([, y]) => y < rp);                // first outer point below the pin's top
  const above = [...outer.slice(0, iTop).filter(([, y]) => y >= rp), [R, rp], [xb, rp], [xb, 0.29], [0, 0.29]];
  const below = [[xb, -rp], [R, -rp], ...outer.filter(([, y]) => y <= -rp), [R - 0.05, -SKIRT], [R - 0.05, -0.2], [R - 0.025, -0.19], [R - 0.025, -rb], [xb, -rb]];
  for (const poly of [above, below]) { parts.push(capZ0(poly)); hZ0(poly, 0.022, Math.PI / 4); }

  // the rings, sitting in their grooves out to the bore, hatched the other way
  for (const [y0, y1, k] of RING_GROOVES) {
    const d = k === 'c' ? PIS.gd : k === 'o' ? PIS.go : PIS.gs, a = R - d + 0.004, b = BORE_R - 0.002, e = 0.0006;
    const ring = k === 'o'                                         // the oil ring: two lands with the slot between
      ? [[a, y0 + e], [b, y0 + e], [b, y0 + 0.008], [b - 0.007, y0 + 0.008], [b - 0.007, y1 - 0.008], [b, y1 - 0.008], [b, y1 - e], [a, y1 - e]]
      : [[a, y0 + e], [b, y0 + e], [b, y1 - e], [a, y1 - e]];
    parts.push(lathe(ring, 64), capX0(ring), capZ0(ring));
    hX0(ring, 0.006, -Math.PI / 4); hZ0(ring, 0.006, -Math.PI / 4);
    if (k === 'o') {                                               // drain holes through the groove's root
      for (let j = 0; j < 14; j++) {
        const ph = ((j + 0.5) / 14) * Math.PI * 2;
        if (ph > PH - 0.05) continue;
        const rr = R - d + 0.001, c = new THREE.Vector3(rr * Math.sin(ph), (y0 + y1) / 2, rr * Math.cos(ph));
        circleSegments(det, c, new THREE.Vector3(Math.cos(ph), 0, -Math.sin(ph)), new THREE.Vector3(0, 1, 0), 0.006, 8);
      }
    }
  }

  // the far boss (x > 0) and the rib from it up to the crown, whole
  parts.push(latheX([[xb, rp], [xb, rb], [R - 0.02, rb], [R - 0.02, rp], [xb, rp]], 32));
  parts.push(new THREE.BoxGeometry(R - 0.05 - xb, 0.29 - 0.1, 0.03).translate((R - 0.05 + xb) / 2, 0.195, 0));

  // the pin: whole for x > 0, the half below z = 0 for x < 0, cut along its length
  const Lp = R - 0.016;
  parts.push(latheX([[0, rpi], [0, rp], [Lp, rp], [Lp, rpi], [0, rpi]], 28));
  parts.push(latheX([[-Lp, rpi], [-Lp, rp], [0, rp], [0, rpi], [-Lp, rpi]], 16, Math.PI, 2 * Math.PI));
  for (const sgn of [1, -1]) {
    const strip = [[0, sgn * rpi], [Lp, sgn * rpi], [Lp, sgn * rp], [0, sgn * rp]];
    parts.push(capZ0(strip)); hZ0(strip, 0.012, -Math.PI / 4);
  }
  const pinEnd = [];                                              // where the x = 0 plane cuts the pin's far half
  for (let k = 0; k <= 12; k++) { const a = -Math.PI / 2 + (k / 12) * Math.PI; pinEnd.push([rp * Math.cos(a), rp * Math.sin(a)]); }
  for (let k = 12; k >= 0; k--) { const a = -Math.PI / 2 + (k / 12) * Math.PI; pinEnd.push([rpi * Math.cos(a), rpi * Math.sin(a)]); }
  parts.push(capX0(pinEnd)); hX0(pinEnd, 0.012, -Math.PI / 4);
  // circlips at both ends of the pin, the near one cut in half
  for (const side of [1, -1]) {
    for (const rad of [rp + 0.004, rp + 0.012]) {
      const n = 24;
      for (let k = 0; k < n; k++) {
        const a0 = (k / n) * Math.PI * 2, a1 = ((k + 1) / n) * Math.PI * 2;
        if (side < 0 && (Math.sin(a0) > 0.001 || Math.sin(a1) > 0.001)) continue;
        det.push(side * (Lp + 0.005), rad * Math.cos(a0), rad * Math.sin(a0), side * (Lp + 0.005), rad * Math.cos(a1), rad * Math.sin(a1));
      }
    }
  }
  pinBoreLines(det, 1);
  return { geometry: mergeParts(parts), hatch, det };
}

/* ------------------------------------------------------------ thermo */

// Gas temperature (0..1) at cycle angle a (deg from ignition) for a parcel at plug distance d (0..1)
function gasT(a, d) {
  a = ((a % 720) + 720) % 720;
  const TC = 0.3;
  if (a < 180) {
    const ab = a - d * 20;                       // two plugs: the flame has half as far to go
    if (ab < 0) return TC + 0.04 * (a / 20);
    const burn = 1 - Math.exp(-ab / 7);
    return lerp(TC, 1.0, burn) - 0.22 * smoothstep(20, 180, a) * burn;
  }
  if (a < 360) return lerp(0.78, 0.52, (a - 180) / 180);
  if (a < 540) return lerp(0.03, 0.52, Math.exp(-(a - 360) / 22));
  return lerp(0.03, TC, Math.pow((a - 540) / 180, 2.2));
}

/* ------------------------------------------------------------ mount */

export const ENGINE_VIEW = {
  camera: { fov: 24, position: [-13, 6.5, 9.5], target: [0.9, 1.1, 0] },
  refAspect: 1.9,
  drift: (t) => ({ yaw: Math.sin(t * 0.02) * 0.08, pitch: Math.sin(t * 0.015) * 0.03 }),
  speed: 3,
};

export function mountEngine(el, opts = {}) {
  const stage = opts.stage || new Stage(el, {
    ...ENGINE_VIEW,
    ...opts,
    hud: !opts.hud ? false : {
      id: 'XV-02 / POWERTRAIN',
      title: 'ROLLS-ROYCE MERLIN · 60° V12 · 27 L · SOHC 48V',
      rows: [['CRANK θ', 'th'], ['FIRING', 'fo'], ['ENGINE', 'rpm'], ['P MAX', 'pmax']],
      colorbar: { label: 'CHARGE TEMPERATURE · K', ticks: ['300', '1 400', '2 500'] },
      time: '×1 / 86',
    },
  });
  const { scene } = stage;
  const Y = new THREE.Vector3(0, 1, 0), Z = new THREE.Vector3(0, 0, 1), Xv = new THREE.Vector3(1, 0, 0);

  /* crankshaft, reduction gear and propeller shaft -------------------------------------------- */
  const crank = stage.wire(crankGeometry(), { crease: 32 });
  scene.add(crank);
  const PROP_Y = 0.31 + 0.72;                                   // pinion + wheel pitch radii: 0.42:1
  // propeller shaft, turned: a boss on the gear, a collar stepping down to the shaft, a fillet up to the bored flange
  const xg = X_FRONT - 0.23, xf = X_FRONT - 1.5;
  const shaft = [[X_FRONT + 0.05, 0], [X_FRONT + 0.05, 0.14], [xg + 0.02, 0.14], [xg + 0.02, 0.27], [xg - 0.08, 0.27], [xg - 0.1, 0.21],
    [xg - 0.17, 0.21], [xg - 0.19, 0.16], [xf + 0.12, 0.16], [xf + 0.07, 0.19], [xf + 0.05, 0.24], [xf + 0.04, 0.36], [xf - 0.04, 0.36],
    [xf - 0.04, 0.1], [xf + 0.05, 0.1], [xf + 0.05, 0]];
  const prop = stage.wire(mergeParts([
    extrudeX(gearShape(42, 0.74, 0.71), 0.16, 0.006, 4).applyMatrix4(new THREE.Matrix4().makeTranslation(X_FRONT - 0.15, 0, 0)),
    latheX(shaft, 48),
  ]), { crease: 30 });
  prop.position.y = PROP_Y;
  scene.add(prop);
  const pdet = [];
  for (let k = 0; k < 8; k++) { const a = (k / 8) * Math.PI * 2; circleSegments(pdet, new THREE.Vector3(X_FRONT - 1.545, Math.cos(a) * 0.25, Math.sin(a) * 0.25), Y, Z, 0.03, 10); }
  prop.add(lines(stage, pdet, stage.mat.dim));

  /* the two banks ------------------------------------------------------------------------- */
  const rodG = { fork: rodGeometry(true), blade: rodGeometry(false) };
  const pisG = pistonGeometry();
  const pinLines = []; pinBoreLines(pinLines, 1); pinBoreLines(pinLines, -1);
  const valveG = valveGeometry();
  const springG = springSegments();
  const linerG = new THREE.CylinderGeometry(BORE_R, BORE_R, DECK_Y - LINER_Y0, 64, 1, true);
  linerG.translate(0, (DECK_Y + LINER_Y0) / 2, 0);
  // optional cut-aways (globalThis.XV_CUT.merlin = 'piston' | 'piston+cylinder' | 'one' | 'bank'): bank B's front
  // piston quartered, alone or with its block sectioned across the engine; bank A's front block sectioned; or
  // the whole of bank A sectioned along its bores. Cut faces are hatched
  const MCUT = (globalThis.XV_CUT && globalThis.XV_CUT.merlin) || 'none';
  const cutHatch = [];
  // across the engine through the front cylinder's bore: the rear half stays, the cut faces the camera
  const crossBlock = (x) => {
    const W2 = 0.55, R = BORE_R + 0.004, xr = x + PITCH / 2, y0 = LINER_Y0 - 0.12, D = DECK_Y - y0;
    const sh = new THREE.Shape();
    sh.moveTo(x, -W2); sh.lineTo(xr, -W2); sh.lineTo(xr, W2); sh.lineTo(x, W2); sh.lineTo(x, R);
    for (let k = 1; k < 24; k++) { const a = Math.PI / 2 - (k / 24) * Math.PI; sh.lineTo(x + R * Math.cos(a), R * Math.sin(a)); }
    sh.lineTo(x, -R); sh.lineTo(x, -W2);
    const g = new THREE.ExtrudeGeometry(sh, { depth: D, bevelEnabled: false, curveSegments: 24 });
    g.rotateX(Math.PI / 2); g.translate(0, DECK_Y, 0);
    for (const [z0, z1] of [[-W2, -R], [R, W2]]) {
      const poly = [[z0, y0], [z1, y0], [z1, DECK_Y], [z0, DECK_Y]];
      for (const [p0, q0, p1, q1] of hatchPolygon(poly, 0.05)) cutHatch.push(x - 0.002, q0, p0, x - 0.002, q1, p1);
    }
    return g;
  };
  const halfBlock = (B, x) => {
    // which side of the bore axis faces the camera, in bank coordinates: keep the far half
    const [, cz] = toLocal(B.s, ENGINE_VIEW.camera.position[1], ENGINE_VIEW.camera.position[2]);
    const sz = cz > 0 ? -1 : 1, W2 = 0.55, R = BORE_R + 0.004, xl = x - PITCH / 2, xr = x + PITCH / 2;
    const y0 = LINER_Y0 - 0.12, D = DECK_Y - y0;
    const sh = new THREE.Shape();
    sh.moveTo(xl, 0); sh.lineTo(xl, sz * W2); sh.lineTo(xr, sz * W2); sh.lineTo(xr, 0); sh.lineTo(x + R, 0);
    for (let k = 1; k < 24; k++) { const a = (k / 24) * Math.PI; sh.lineTo(x + R * Math.cos(a), sz * R * Math.sin(a)); }
    sh.lineTo(x - R, 0); sh.lineTo(xl, 0);
    const g = new THREE.ExtrudeGeometry(sh, { depth: D, bevelEnabled: false, curveSegments: 24 });
    g.rotateX(Math.PI / 2); g.translate(0, DECK_Y, 0);
    const e = -sz * 0.002;                                            // the cut faces, at the bore axis
    for (const [a0, a1] of [[xl, x - R], [x + R, xr]]) {
      const poly = [[a0, y0], [a1, y0], [a1, DECK_Y], [a0, DECK_Y]];
      for (const [p0, q0, p1, q1] of hatchPolygon(poly, 0.05)) cutHatch.push(p0, q0, e, p1, q1, e);
    }
    return g;
  };
  const banks = BANKS.map((B, bi) => {
    const g = new THREE.Group(); g.rotation.x = B.s * BETA; scene.add(g);
    const rods = [], pistons = [], valves = [];
    for (let i = 0; i < NCYL; i++) {
      const r = stage.wire(bi === 0 ? rodG.fork : rodG.blade, { crease: 32 });
      r.position.x = cylX(i); g.add(r); rods.push(r);
      const cutP = bi === 1 && i === 0 && /piston/.test(MCUT);       // bank B's front piston: seen side-on
      const cp = cutP ? cutPistonGeometry() : null;
      const p = stage.wire(cutP ? cp.geometry : pisG, { crease: 30 }); p.position.x = cylX(i); g.add(p); pistons.push(p);
      if (cutP) p.add(lines(stage, cp.hatch, stage.mat.hatch), lines(stage, cp.det, stage.mat.dim));
      else p.add(lines(stage, pinLines, stage.mat.dim));
      const l = stage.wire(linerG, { faces: false, material: stage.mat.dim, crease: 30 }); l.position.x = cylX(i); g.add(l);
      if (bi === 0 && MCUT === 'bank') g.add(stage.wire(halfBlock(B, cylX(i)), { crease: 30 }));
      if (i === 0 && ((bi === 0 && MCUT === 'one') || (bi === 1 && MCUT === 'piston+cylinder'))) g.add(stage.wire(crossBlock(cylX(i)), { crease: 30 }));
      for (const side of ['int', 'exh']) {
        const zs = side === 'exh' ? B.s : -B.s;                   // exhausts outboard, intakes in the V
        for (const dx of [-VALVE_DX, VALVE_DX]) {
          const vg = new THREE.Group();
          vg.position.set(cylX(i) + dx, DECK_Y, zs * SEAT_Z);
          vg.rotation.x = zs * TILT;
          const v = stage.wire(valveG, { crease: 30 });
          const sp = lines(stage, springG, stage.mat.dim); sp.position.y = 0.26;
          vg.add(v, sp); g.add(vg);
          valves.push({ i, side, dx, zs, v, sp });
        }
      }
    }
    const cam = stage.wire(camshaftGeometry(B), { crease: 30 }); cam.position.y = CAM_Y; g.add(cam);
    // rocker shafts, the inclined cam drive shaft at the rear, two plugs per cylinder
    const det = [];
    for (const zs of [-1, 1]) det.push(X_FRONT + 0.15, PIVOT.y, zs * PIVOT.z, X_REAR - 0.1, PIVOT.y, zs * PIVOT.z);
    for (let i = 0; i < NCYL; i++) {
      for (const zs of [-1, 1]) {
        const x = cylX(i) - 0.27, a = [x, DECK_Y - 0.02, zs * 0.3], b = [x, DECK_Y + 0.3, zs * 0.56];
        det.push(...a, ...b);
        circleSegments(det, new THREE.Vector3(...b), Xv, Z, 0.04, 6);
      }
    }
    g.add(lines(stage, det, stage.mat.dim));
    g.add(stage.wire(new THREE.CylinderGeometry(0.05, 0.05, CAM_Y - 0.5, 16).translate(X_REAR - 0.12, (CAM_Y + 0.5) / 2, 0), { crease: 30 }));
    // ejector exhaust stubs, raked back
    const stubs = [], stubPaths = [];
    for (let i = 0; i < NCYL; i++) {
      const x = cylX(i);
      const pts = [[x, DECK_Y + 0.08, B.s * 0.3], [x + 0.02, DECK_Y + 0.06, B.s * 0.62], [x + 0.18, DECK_Y - 0.02, B.s * 0.78], [x + 0.4, DECK_Y - 0.1, B.s * 0.86]];
      const c = new THREE.CatmullRomCurve3(pts.map((q) => new THREE.Vector3(...q)));
      stubs.push(new THREE.TubeGeometry(c, 20, 0.075, 12, false));
      const end = c.getPoint(1), tan = c.getTangent(1);
      const ext = [...c.getSpacedPoints(24), ...Array.from({ length: 12 }, (_, k) => end.clone().addScaledVector(tan, (k + 1) * 0.06))];
      stubPaths.push({ i, side: 'exh', samples: ext, r: 0.06 });
    }
    g.add(stage.wire(mergeParts(stubs), { crease: 30, silhouette: true }));
    // rocker arms: dynamic lines, pad -> pivot -> valve tip
    const NR = NCYL * 4;
    const rArr = new Float32Array(NR * 2 * 6);
    const rG = new LineSegmentsGeometry().setPositions(rArr);
    const rL = new LineSegments2(rG, stage.lineMaterial({ width: 2.0 }));
    rL.frustumCulled = false; g.add(rL);
    if (cutHatch.length) { g.add(lines(stage, cutHatch, stage.mat.hatch)); cutHatch.length = 0; }
    return { B, g, rods, pistons, valves, cam, rArr, rG, stubPaths };
  });

  // ghost engine outline (crankcase, blocks, cam covers), the reduction-gear case and supercharger
  scene.add(stage.wire(extrudeX(engineProfile(), X_REAR - X_FRONT, 0, 12).translate((X_FRONT + X_REAR) / 2, 0, 0), { faces: false, material: stage.mat.faint, crease: 24 }));
  const gearCase = new THREE.LatheGeometry([[0, 0], [0.55, 0], [0.95, 0.1], [1.0, 0.35], [0.9, 0.55], [0.4, 0.7], [0.3, 0.9], [0, 0.9]].map(([r, y]) => new THREE.Vector2(r, y)), 40);
  gearCase.rotateZ(Math.PI / 2); gearCase.translate(X_FRONT + 0.05, PROP_Y * 0.55, 0);
  const SC_X = X_REAR + 0.75, SC_Y = 1.0;
  const scCase = new THREE.LatheGeometry([[0, 0], [0.5, 0], [0.95, 0.12], [1.0, 0.35], [0.95, 0.55], [1.0, 0.75], [0.95, 0.95], [0.6, 1.1], [0.3, 1.25], [0, 1.25]].map(([r, y]) => new THREE.Vector2(r, y)), 48);
  scCase.rotateZ(-Math.PI / 2); scCase.translate(SC_X - 0.55, SC_Y, 0);
  const cooler = new THREE.BoxGeometry(0.9, 0.5, 1.2); cooler.translate(SC_X - 0.1, SC_Y + 1.35, 0);
  scene.add(stage.wire(mergeParts([gearCase, scCase, cooler]), { faces: false, material: stage.mat.faint, crease: 30 }));
  // supercharger impellers (two stages, geared up ~6:1), and its drive from the crank tail
  const imp = new THREE.Group(); imp.position.set(SC_X, SC_Y, 0); scene.add(imp);
  const vanes = [];
  for (const [x, r] of [[-0.25, 0.8], [0.3, 0.72]]) {
    vanes.push(cylX_(0.12, 0.12, 24).applyMatrix4(new THREE.Matrix4().makeTranslation(x, 0, 0)));
    for (let k = 0; k < 14; k++) { const v = new THREE.BoxGeometry(0.16, r - 0.12, 0.012); v.translate(x, 0.06 + (r - 0.12) / 2, 0); v.rotateX((k / 14) * Math.PI * 2); vanes.push(v); }
  }
  vanes.push(cylX_(0.05, 1.2, 16).applyMatrix4(new THREE.Matrix4().makeTranslation(-0.2, 0, 0)));
  imp.add(stage.wire(mergeParts(vanes), { crease: 30, silhouette: false }));
  const tailX = -(-(NCYL / 2) * PITCH - (PITCH - 0.48) / 2) + 0.4;   // the crank's tail gear drives up a layshaft to the impellers
  scene.add(stage.wire(mergeParts([
    new THREE.CylinderGeometry(0.05, 0.05, SC_Y - 0.25, 12).translate(tailX, (SC_Y + 0.25) / 2, 0),
    extrudeX(gearShape(16, 0.12, 0.105), 0.05, 0.004, 4).applyMatrix4(new THREE.Matrix4().makeTranslation(tailX, SC_Y, 0)),
  ]), { crease: 30 }));

  /* induction: supercharger -> intercooler -> manifold in the V -> runners to each intake port */
  const MAN_Y = 2.8;
  const runners = [];
  const tubes = [];
  tubes.push(cylX_(0.2, X_REAR - X_FRONT - 0.3, 32).applyMatrix4(new THREE.Matrix4().makeTranslation((X_FRONT + X_REAR) / 2 + 0.1, MAN_Y, 0)));
  const trunk = new THREE.CatmullRomCurve3([[SC_X - 0.1, SC_Y + 1.6, 0], [SC_X - 0.4, MAN_Y + 0.25, 0], [X_REAR - 0.1, MAN_Y, 0]].map((q) => new THREE.Vector3(...q)));
  tubes.push(new THREE.TubeGeometry(trunk, 24, 0.2, 16, false));
  for (const K of banks) {
    for (let i = 0; i < NCYL; i++) {
      const x = cylX(i), s = K.B.s;
      const port = toWorld(s, DECK_Y + 0.08, -s * 0.3), mid = toWorld(s, DECK_Y + 0.3, -s * 0.55);
      const P = [[x, MAN_Y + 0.1, 0], [x, (MAN_Y + mid[0]) / 2 + 0.15, mid[1] * 0.5], [x, mid[0], mid[1]], [x, port[0], port[1]]];
      const c = new THREE.CatmullRomCurve3(P.map((q) => new THREE.Vector3(...q)));
      tubes.push(new THREE.TubeGeometry(c, 24, 0.07, 12, false));
      runners.push({ bank: K, i, side: 'int', samples: c.getSpacedPoints(48), r: 0.07, world: true });
    }
    for (const sp of K.stubPaths) runners.push({ bank: K, ...sp, world: false });
  }
  scene.add(stage.wire(mergeParts(tubes), { faces: false, material: stage.mat.faint, crease: 30 }));

  const FP = 30;
  const flow = glowPoints(runners.length * FP, { core: 0.6 });
  flow.renderOrder = 3;
  scene.add(flow);
  const fr = rng(19);
  const FL = runners.flatMap(() => Array.from({ length: FP }, () => ({ u: fr(), ox: (fr() - 0.5) * 1.4, oy: (fr() - 0.5) * 1.4 })));
  const flp = flow.geometry.attributes.position.array, flc = flow.geometry.attributes.color.array;
  const fls = flow.geometry.attributes.size.array, fla = flow.geometry.attributes.alpha.array;
  const fcol = [0, 0, 0];

  const cl = [];
  centerline(cl, new THREE.Vector3(X_FRONT - 1.7, 0, 0), new THREE.Vector3(X_REAR + 1.6, 0, 0));
  scene.add(lines(stage, cl, stage.lineMaterial({ width: 1, opacity: 0.22, depthTest: false })));

  /* charge particles, ignition flashes and flame rings ------------------------------------- */
  const M = opts.particlesPerCylinder || 110;
  const rand = rng(11);
  const NCH = 2 * NCYL;
  const gas = glowPoints(NCH * M, { core: 0.6 });
  gas.renderOrder = 3;
  scene.add(gas);
  const G = [];
  for (let i = 0; i < NCH * M; i++) {
    const rho = Math.sqrt(rand()) * 0.93;
    G.push({ rho, phi: rand() * Math.PI * 2, u: rand(), w: 0.6 + rand() * 1.2, ph: rand() * 6.28, d: rho });
  }
  const gp = gas.geometry.attributes.position.array, gc = gas.geometry.attributes.color.array;
  const gs = gas.geometry.attributes.size.array, ga = gas.geometry.attributes.alpha.array;
  const flash = glowPoints(NCH * 2, { core: 1.2 });
  flash.renderOrder = 4;
  scene.add(flash);
  const fp = flash.geometry.attributes.position.array, fc = flash.geometry.attributes.color.array;
  const fs = flash.geometry.attributes.size.array, fa = flash.geometry.attributes.alpha.array;
  const ringUnit = circleSegments([], new THREE.Vector3(), Xv, Z, 1, 72);
  const rings = [];
  for (const K of banks) {
    for (let i = 0; i < NCYL; i++) {
      for (let k = 0; k < 2; k++) {
        const mat = stage.lineMaterial({ width: 1.6, additive: true });
        const l = new LineSegments2(new LineSegmentsGeometry().setPositions(ringUnit), mat);
        l.renderOrder = 4; l.position.x = cylX(i);
        K.g.add(l);
        rings.push({ l, mat, k });
      }
    }
  }

  const col = [0, 0, 0];
  const ringCol = new THREE.Color();
  let lastFire = -1;
  const tip = new THREE.Vector3();

  stage.onUpdate((t, dt) => {
    const th = t * REV_PER_S * Math.PI * 2;          // crank angle (rad)
    const thDeg = th / DEG;
    crank.rotation.x = th;
    prop.rotation.x = -th * (0.31 / 0.72);
    imp.rotation.x = th * 6;
    gas.material.uniforms.uScale.value = stage.pointScale;
    flash.material.uniforms.uScale.value = stage.pointScale;
    flow.material.uniforms.uScale.value = stage.pointScale;

    let firing = -1;
    banks.forEach((K, bi) => {
      const s = K.B.s;
      K.cam.rotation.x = th / 2;
      const cyc = (i) => ((((thDeg - K.B.fire[i]) % 720) + 720) % 720);
      for (let i = 0; i < NCYL; i++) {
        const al = th - PHASE[i];
        const [py, pz] = toLocal(s, RC * Math.cos(al), RC * Math.sin(al));
        const wy = py + Math.sqrt(LROD * LROD - pz * pz);
        K.pistons[i].position.y = wy;
        const r = K.rods[i];
        r.position.set(cylX(i), py, pz);
        r.rotation.x = Math.atan2(-pz, wy - py);

        const a = cyc(i), n = bi * NCYL + i;
        if (a < 60) firing = n;
        const crown = wy + PIN_TOP, hgt = DECK_Y - crown;
        const comp = clamp(0.12 / hgt, 0, 1);
        for (let k = 0; k < M; k++) {
          const g = G[n * M + k], o = (n * M + k) * 3;
          const sw = g.phi + t * g.w * 0.9, rr = g.rho * (BORE_R - 0.03);
          const u = clamp(g.u + 0.06 * Math.sin(t * 2.1 * g.w + g.ph), 0.02, 0.98);
          const [wy2, wz2] = toWorld(s, crown + 0.012 + u * (hgt - 0.024), rr * Math.sin(sw));
          gp[o] = cylX(i) + rr * Math.cos(sw); gp[o + 1] = wy2; gp[o + 2] = wz2;
          const T = gasT(a, g.d);
          gradientSRGB(T, col);
          gc[o] = col[0]; gc[o + 1] = col[1]; gc[o + 2] = col[2];
          gs[n * M + k] = 0.05 + 0.03 * T;
          ga[n * M + k] = (0.28 + 0.72 * T) * (0.45 + 0.55 * comp);
        }
        // spark just before TDC, then the fireball
        const aS = (a + 12) % 720, f0 = n * 2;
        const [sy, sz] = toWorld(s, DECK_Y - 0.03, 0), [my, mz] = toWorld(s, (crown + DECK_Y) / 2, 0);
        fp[f0 * 3] = cylX(i); fp[f0 * 3 + 1] = sy; fp[f0 * 3 + 2] = sz;
        fp[f0 * 3 + 3] = cylX(i); fp[f0 * 3 + 4] = my; fp[f0 * 3 + 5] = mz;
        fc[f0 * 3] = 0.75; fc[f0 * 3 + 1] = 0.85; fc[f0 * 3 + 2] = 1.0;
        fs[f0] = 0.15; fa[f0] = aS < 12 ? Math.sin((aS / 12) * Math.PI) : 0;
        const env = a < 110 ? (1 - Math.exp(-a / 2)) * Math.exp(-a / 22) : 0;
        gradientSRGB(1 - smoothstep(10, 70, a) * 0.6, col);
        fc[f0 * 3 + 3] = col[0]; fc[f0 * 3 + 4] = col[1]; fc[f0 * 3 + 5] = col[2];
        fs[f0 + 1] = 1.2 + a * 0.02; fa[f0 + 1] = env * 1.4;
        for (let k = 0; k < 2; k++) {
          const R = rings[(n) * 2 + k], ak = a - k * 7;
          if (ak >= 0 && ak < 55) {
            const p = ak / 55;
            R.l.visible = true;
            const rad = lerp(0.05, BORE_R * (k ? 1.2 : 1.5), 1 - Math.pow(1 - p, 2.2));
            R.l.scale.set(rad, 1, rad);
            R.l.position.y = lerp(DECK_Y - 0.035, (crown + DECK_Y) / 2, p * 0.6);
            gradientSRGB(1 - p, col);
            const fade = (1 - p) * (k ? 0.6 : 1) * FX.value;
            ringCol.setRGB(col[0] * fade, col[1] * fade, col[2] * fade, THREE.SRGBColorSpace);
            R.mat.color.copy(ringCol);
          } else R.l.visible = false;
        }
      }
      // valves and their rockers
      let q = 0;
      for (const v of K.valves) {
        const L = valveLift(cyc(v.i), VALVES[v.side]);
        v.v.position.y = -L;
        v.sp.scale.y = (0.26 - L) / 0.26;
        tip.set(0, Math.cos(TILT), v.zs * Math.sin(TILT)).multiplyScalar(STEM + CAP_H - L);
        const x = cylX(v.i), sgn = Math.sign(v.dx), lx = x + sgn * LOBE_DX[v.side];
        const pad = [lx, CAM_Y + CAM_R0 + L, v.zs * 0.06], piv = [(lx + x + v.dx) / 2, PIVOT.y, v.zs * PIVOT.z];
        const vt = [x + v.dx, DECK_Y + tip.y, v.zs * SEAT_Z + tip.z];
        const o = q * 12;
        K.rArr.set([...pad, ...piv, ...piv, ...vt], o);
        q++;
      }
      K.rG.attributes.instanceStart.data.needsUpdate = true;
    });
    // gas exchange: intake charge in the runners, exhaust out of the stubs, flow following valve lift
    for (let r = 0; r < runners.length; r++) {
      const R = runners[r], s = R.bank.B.s;
      const open = valveLift((((thDeg - R.bank.B.fire[R.i]) % 720) + 720) % 720, VALVES[R.side]) / LIFT;
      for (let k = 0; k < FP; k++) {
        const P = FL[r * FP + k], o = (r * FP + k) * 3;
        P.u = (P.u + dt * 0.55 * (R.side === 'int' ? open : 0.25 + open)) % 1;
        const f = P.u * (R.samples.length - 1), j = Math.min(R.samples.length - 2, f | 0), w = f - j;
        const A = R.samples[j], Bp = R.samples[j + 1];
        let x = A.x + (Bp.x - A.x) * w, y = A.y + (Bp.y - A.y) * w + P.oy * R.r * 0.8, z = A.z + (Bp.z - A.z) * w + P.ox * R.r * 0.8;
        if (!R.world) { const [wy, wz] = toWorld(s, y, z); y = wy; z = wz; }
        flp[o] = x; flp[o + 1] = y; flp[o + 2] = z;
        gradientSRGB(R.side === 'int' ? 0.06 + 0.1 * P.u : 0.85 - 0.45 * P.u, fcol);
        flc[o] = fcol[0]; flc[o + 1] = fcol[1]; flc[o + 2] = fcol[2];
        fls[r * FP + k] = R.side === 'int' ? 0.05 : 0.06;
        fla[r * FP + k] = (R.side === 'int' ? Math.sqrt(open) : Math.min(1, 0.3 + open)) * Math.sin(Math.PI * P.u) * 0.9;
      }
    }
    for (const k of ['position', 'color', 'size', 'alpha']) {
      gas.geometry.attributes[k].needsUpdate = true;
      flash.geometry.attributes[k].needsUpdate = true;
      flow.geometry.attributes[k].needsUpdate = true;
    }

    if (stage.hud) {
      stage.hud.set('th', `${String(Math.floor(thDeg % 360)).padStart(3, '0')}°`);
      if (firing >= 0) lastFire = firing;
      stage.hud.set('fo', ORDER.map((c) => (c.k === lastFire ? `<span class="xv-hi">${c.label}</span>` : c.label)).join('·'));
      stage.hud.set('rpm', '3 000 RPM');
      stage.hud.set('pmax', `${(98 + Math.sin(t * 0.6) * 1.4).toFixed(1)} BAR`);
    }
  });

  return stage;
}
