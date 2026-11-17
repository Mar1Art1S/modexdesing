/*
 * XV-05 — The Golden Gate Bridge, under live traffic, in the fog.
 * Seen as on the postcards from the Marin bluffs (Battery Spencer): the north tower close and left of
 * centre, the roadway rising from the bottom left to the south tower at the top right, the city across
 * the water behind the near tower.
 *
 * Built to the real bridge at 1 unit = 128 m (heights ×1.05, widths true):
 * main span 1280 m, side spans 343 m, towers 227 m above the water, roadway 67 m above it,
 * cables 27 m apart sagging 143 m, suspenders every 15 m, a 7.6 m Warren stiffening truss.
 * Towers: two slender legs on the cable lines that step in at each of the four portal struts, a stepped
 * crown and the cable saddles on top, fluted faces, X-bracing between the legs below the deck, concrete
 * piers (the south one in its fender ring). Ends: Art Deco pylons and anchorages, the steel arch over
 * Fort Point, the approach viaducts; in San Francisco the roadway reaches the bluff and runs on at grade
 * through the toll plaza and curves east to the Marina, traffic following it.
 * The shores are height fields shaped to the strait (Lime Point and the Marin headlands; Fort Point, the
 * Presidio, Crissy Field, the city's hills from Pacific Heights to Telegraph Hill, Twin Peaks, Alcatraz),
 * drawn as survey contours with a bolder coastline, an index contour every fifth line and dashed
 * shallows; their surface hides what lies behind the hills. The city is blocks over the hills, downtown's
 * towers (Salesforce Tower, the Transamerica Pyramid), Coit Tower and Sutro Tower.
 * Colour: main-cable tension (highest at the saddles), suspender tension under passing traffic,
 * and bending in the truss's bottom chords as the deck deflects.
 */
import {
  THREE, Stage, mergeParts, lines, gradientLinear, rng, smoothstep, lerp, clamp,
  extrudeAlongX, prismBetween, LineSegments2, LineSegmentsGeometry, glowPoints, FX, paintMaterial,
} from './core.js';

const M = 1 / 128, EV = 1.05;                // metres -> units; a touch of vertical exaggeration, widths true
const XT = 640 * M;                         // towers (5.0)
const XA = 983 * M;                         // cable anchorages (7.68)
const LD = 12.5;                            // deck half length (runs past the frame)
const DW = 13.7 * M;                        // half width: cable and truss planes, 27.4 m apart (0.107)
const TD = 7.6 * M * EV;                    // stiffening truss depth (0.062)
const HT = 160 * M * EV;                    // tower top above the roadway (1.31)
const YS = 153 * M * EV;                    // cable at the saddles (1.26)
const YC = 3 * M * EV;                      // cable low point at midspan, just above the railing
const YA = 0.13;                            // cable over the pylons at the ends of the side spans
const SAG_SIDE = 0.08;                      // side-span sag
const WY = -67 * M * EV;                    // water (-0.55)
const PITCH = 15.2 * M;                     // suspender / truss panel (0.119)
const ZL = DW + 0.02;                       // tower leg centres: the cables land on the legs, the roadway passes between
const SOUTH_ANCHOR = -8.9;                  // San Francisco cable anchorage, beyond the Fort Point arch
const YB = 0.07;                            // cable entry there
const XS = -9.75;                           // San Francisco abutment: from here the road runs on at grade
const SUPPORTS = [XS, -8.64, -XA, -XT, XT, XA, 9.1, 10.4, 11.6, LD];

export const BRIDGE_VIEW = {
  // from the bluff west of the north end, a little above the roadway, looking down the bridge toward the city
  // aimed below the horizon so the drawing's mass, from the tower tops to the deck, sits centred like the other machines
  camera: { fov: 36, position: [8.9, 1.05, -1.25], target: [-3, -1.6, 0.75] },
  refAspect: 1.45,
  fitFov: 1,                                  // on narrow screens widen the lens: backing off would put the camera inside the hill
  drift: (t) => ({ yaw: Math.sin(t * 0.035) * 0.05, pitch: Math.sin(t * 0.027) * 0.012 }),
  speed: 1,
};

/** height of the main cable at x (both cables follow the same profile) */
function cableY(x) {
  if (x < -XA) return lerp(YA, YB, (-XA - x) / (-XA - SOUTH_ANCHOR - 0.12));   // over the arch to the anchorage
  const ax = Math.abs(x);
  if (ax <= XT) return YC + (YS - YC) * (x / XT) ** 2;
  const u = clamp((ax - XT) / (XA - XT), 0, 1);
  return lerp(YS, YA, u) - SAG_SIDE * 4 * u * (1 - u);
}
const cableSlope = (x) => (cableY(x + 0.01) - cableY(x - 0.01)) / 0.02;

export function mountBridge(el, opts = {}) {
  const stage = opts.stage || new Stage(el, { ...BRIDGE_VIEW, ...opts, hud: false });
  const { scene } = stage;
  const rand = rng(1937);
  const box = (w, h, d, x, y, z) => { const g = new THREE.BoxGeometry(w, h, d); g.translate(x, y, z); return g; };

  /* traffic: six lanes, three each way ------------------------------------------------------ */
  const LANES = [-0.064, -0.039, -0.013, 0.013, 0.039, 0.064].map((z, i) => ({ z, dir: i < 3 ? 1 : -1 }));
  const carG = mergeParts([box(0.04, 0.008, 0.016, 0, 0.0105, 0), box(0.02, 0.007, 0.014, -0.002, 0.018, 0)]);
  const truckG = mergeParts([box(0.018, 0.017, 0.018, 0.032, 0.015, 0), box(0.06, 0.02, 0.019, -0.01, 0.017, 0)]);
  // in San Francisco the road leaves the bridge at grade, crosses the toll plaza and curves east to the Marina
  const road = new THREE.CatmullRomCurve3([
    [XS, 0], [-10.3, 0], [-10.72, 0.1], [-11.02, 0.42], [-11.18, 0.9], [-11.2, 2.2], [-11.08, 3.6],
    [-10.82, 5.0], [-10.6, 6.4], [-10.5, 8.0], [-10.48, 9.6],
  ].map(([x, z]) => new THREE.Vector3(x, 0, z)), false, 'centripetal');
  const NRP = 240, RP = road.getSpacedPoints(NRP), RL = road.getLength();
  const roadY = (a) => -0.47 * smoothstep(2.0, 6.2, a);                       // level across the plaza, then down to the Marina
  const roadW = (a) => 0.085 + 0.12 * smoothstep(0.05, 0.3, a) * smoothstep(0.95, 0.7, a);   // half width, wide at the plaza
  const roadAt = (a) => {                                     // a: distance from the abutment along the road
    const f = clamp(a / RL, 0, 1) * NRP, i = Math.min(NRP - 1, f | 0), k = f - i, p = RP[i], q = RP[i + 1];
    const l = Math.hypot(q.x - p.x, q.z - p.z) || 1, tx = (q.x - p.x) / l, tz = (q.z - p.z) / l;
    return { x: lerp(p.x, q.x, k), z: lerp(p.z, q.z, k), y: roadY(a), tx, tz, nx: tz, nz: -tx };   // n: the bridge's +z side
  };
  const nearRoad = (x, z) => {
    let best = 1e9, bi = 0;
    for (let i = 0; i <= NRP; i += 4) { const d = (RP[i].x - x) ** 2 + (RP[i].z - z) ** 2; if (d < best) { best = d; bi = i; } }
    for (let i = Math.max(0, bi - 4); i <= Math.min(NRP, bi + 4); i++) { const d = (RP[i].x - x) ** 2 + (RP[i].z - z) ** 2; if (d < best) { best = d; bi = i; } }
    return { d: Math.sqrt(best), a: (bi / NRP) * RL };
  };

  // s: distance along the route, equal to x on the bridge and running on past the abutment into the city
  const S0 = XS - (RL - 0.15), S1 = 13.5, LOOP = S1 - S0;
  const vehicles = [];
  LANES.forEach((ln, li) => {
    const n = 11;
    for (let k = 0; k < n; k++) {
      const truck = (li === 0 || li === 5) && k % 3 === 1;
      const w = stage.wire(truck ? truckG : carG, { crease: 30, silhouette: false });
      scene.add(w);
      vehicles.push({ w, lane: ln, P: truck ? 1.0 : 0.3, v: (truck ? 0.5 : 0.75) + rand() * 0.2,
        x0: (LOOP * (k + rand() * 0.6)) / n, s: 0, x: 0 });
    }
  });

  /* deck deflection: first mode in each span, exaggerated ---------------------------------- */
  const NG = 800, GX0 = XS, GX1 = LD;
  const W = new Float32Array(NG + 1);
  const spanOf = (x) => { for (let i = 0; i < SUPPORTS.length - 1; i++) if (x >= SUPPORTS[i] && x <= SUPPORTS[i + 1]) return i; return -1; };
  const wAt = (x) => {
    const f = clamp((x - GX0) / (GX1 - GX0), 0, 1) * NG, i = Math.min(NG - 1, f | 0), k = f - i;
    return W[i] + (W[i + 1] - W[i]) * k;
  };
  const spanLoad = new Float32Array(SUPPORTS.length);
  const updateDeflection = (t) => {
    spanLoad.fill(0);
    for (const v of vehicles) {
      const s = spanOf(v.x);
      if (s < 0) continue;
      const a = SUPPORTS[s], b = SUPPORTS[s + 1];
      spanLoad[s] += v.P * Math.sin((Math.PI * (v.x - a)) / (b - a));
    }
    for (let i = 0; i <= NG; i++) {
      const x = lerp(GX0, GX1, i / NG), s = spanOf(x);
      if (s < 0) { W[i] = 0; continue; }
      const a = SUPPORTS[s], b = SUPPORTS[s + 1], L = b - a;
      const shape = Math.sin((Math.PI * (x - a)) / L);
      const sway = Math.abs(x) < XT ? 0.006 * Math.sin(t * 0.55) : 0;     // the long span breathes a little
      W[i] = -(0.0009 * L * spanLoad[s] + sway) * shape;
    }
  };
  const load = (x) => { let s = 0; for (const v of vehicles) if (Math.abs(v.x) < LD) s += v.P * Math.exp(-((x - v.x) ** 2) / 0.3); return s; };

  /* roadway slab (occludes what's behind it) ------------------------------------------------ */
  const slab = [[-DW - 0.006, -0.007], [-DW - 0.006, 0.006], [DW + 0.006, 0.006], [DW + 0.006, -0.007]];
  const slabG = extrudeAlongX(new THREE.Shape(slab.map(([z, y]) => new THREE.Vector2(z, y))), LD - XS, { steps: 300 });
  slabG.translate((LD + XS) / 2, 0, 0);
  const deck = stage.wire(slabG, { crease: 20, silhouette: false });
  scene.add(deck);
  const sPos = slabG.attributes.position, sBase = Float32Array.from(sPos.array);
  const sLine = deck.creaseLines.geometry.attributes.instanceStart.data, sLineBase = Float32Array.from(sLine.array);

  /* stiffening truss and roadway details, all riding on the deflected deck ------------------- */
  const trussMain = [], trussDim = [];
  const N = Math.round((LD - XS) / PITCH);
  for (let i = 0; i < N; i++) {
    const x0 = XS + i * PITCH, x1 = x0 + PITCH;
    for (const z of [-DW, DW]) {
      trussMain.push(x0, -TD, z, x1, -TD, z);                                    // bottom chord
      trussMain.push(x0, 0, z, x0, -TD, z);                                      // vertical
      if (i % 2) trussMain.push(x0, 0, z, x1, -TD, z); else trussMain.push(x0, -TD, z, x1, 0, z);   // Warren diagonal
    }
    trussDim.push(x0, -TD, -DW, x0, -TD, DW);                                     // floor beam
    if (i % 2 === 0) trussDim.push(x0, -TD, -DW, x1 + PITCH, -TD, DW, x0, -TD, DW, x1 + PITCH, -TD, -DW);   // lateral bracing
    for (const z of [-0.052, -0.026, 0.026, 0.052]) if (i % 2 === 0) trussDim.push(x0, 0.0065, z, x0 + PITCH * 0.55, 0.0065, z);   // lane lines
    if (i % 4 === 0) for (const s of [-1, 1]) trussDim.push(x0, 0.006, s * (DW - 0.01), x0, 0.05, s * (DW - 0.01), x0, 0.05, s * (DW - 0.01), x0, 0.048, s * (DW - 0.03));   // street lights
  }
  for (const s of [-1, 1]) for (let x = XS; x < LD; x += 0.4) trussMain.push(x, 0.02, s * (DW - 0.004), x + 0.4, 0.02, s * (DW - 0.004));   // railings
  const tMainL = lines(stage, trussMain, stage.mat.line), tDimL = lines(stage, trussDim, stage.mat.dim);
  scene.add(tMainL, tDimL);
  const deformables = [tMainL, tDimL].map((l) => { const b = l.geometry.attributes.instanceStart.data; return { b, base: Float32Array.from(b.array) }; });

  /* towers --------------------------------------------------------------------------------- */
  // section boundaries: pier top, under-deck strut, then a setback at each of the four portal struts
  const solid = [], detail = [], faint = [], land = [];   // land: coastlines and index contours, drawn a little stronger
  const steel = [];                                     // the towers' steelwork, which can take a coat of paint
  // legs 16.5 m along the bridge by 10 m across at the base, tapering as they step in
  const LEVELS = [WY + 0.08, -TD - 0.05, 0.33 * HT, 0.585 * HT, 0.795 * HT, HT];
  const HX = [0.066, 0.061, 0.056, 0.051, 0.046, 0.042];          // leg half-depth along the bridge
  const HZ = [0.036, 0.034, 0.032, 0.03, 0.028, 0.026];          // leg half-width across it
  const STRUT_H = 0.045 * HT;
  const STRUTS = [-TD - 0.05 - STRUT_H / 2, 0.33 * HT, 0.585 * HT, 0.795 * HT, HT - STRUT_H * 0.9];
  for (const xt of [-XT, XT]) {
    for (const zs of [-1, 1]) {
      for (let i = 0; i < LEVELS.length - 1; i++) {
        const y0 = LEVELS[i], y1 = LEVELS[i + 1], hx = HX[i], hz = HZ[i];
        steel.push(prismBetween([xt, y0, zs * ZL], [xt, y1, zs * ZL], [hx, hz], [hx * 0.985, hz * 0.985]));
        for (const f of [-0.45, 0.45]) {                          // the vertical fluting on the leg faces
          detail.push(xt + f * hx, y0 + 0.01, zs * ZL + zs * hz, xt + f * hx * 0.985, y1 - 0.01, zs * ZL + zs * hz * 0.985);
          detail.push(xt + f * hx, y0 + 0.01, zs * ZL - zs * hz, xt + f * hx * 0.985, y1 - 0.01, zs * ZL - zs * hz * 0.985);
          detail.push(xt + hx, y0 + 0.01, zs * ZL + f * hz, xt + hx * 0.985, y1 - 0.01, zs * ZL + f * hz * 0.985);
          detail.push(xt - hx, y0 + 0.01, zs * ZL + f * hz, xt - hx * 0.985, y1 - 0.01, zs * ZL + f * hz * 0.985);
        }
      }
      steel.push(prismBetween([xt, HT, zs * ZL], [xt, HT + 0.022, zs * ZL], [HX[5] * 0.92, HZ[5] * 0.92], [HX[5] * 0.8, HZ[5] * 0.8]));   // the stepped crown
      steel.push(prismBetween([xt, HT + 0.022, zs * ZL], [xt, HT + 0.036, zs * ZL], [HX[5] * 0.62, HZ[5] * 0.7], [HX[5] * 0.5, HZ[5] * 0.6]));   // saddle housing
    }
    STRUTS.forEach((yc, k) => {
      const hx = HX[Math.min(k + 1, HX.length - 1)] * 0.76, h = k === STRUTS.length - 1 ? STRUT_H * 1.8 : STRUT_H;
      steel.push(box(2 * hx, h, 2 * ZL, xt, yc, 0));
      for (let j = -2; j <= 2; j++) for (const sx of [-1, 1]) {   // ribbed Art Deco facing on the struts
        const zz = j * (ZL - HZ[0]) / 2.5;
        detail.push(xt + sx * hx, yc - h / 2 + 0.006, zz, xt + sx * hx, yc + h / 2 - 0.006, zz);
      }
    });
    // X-bracing between the legs below the deck, on both faces of the tower
    const yb0 = WY + 0.1, yb1 = -TD - 0.05 - STRUT_H;
    for (const sx of [-1, 1]) {
      const x = xt + sx * HX[0] * 0.55, zi = ZL - HZ[0];
      steel.push(prismBetween([x, yb0, -zi], [x, yb1, zi], [0.011, 0.016], [0.011, 0.016]));
      steel.push(prismBetween([x, yb0, zi], [x, yb1, -zi], [0.011, 0.016], [0.011, 0.016]));
    }
    solid.push(box(0.2, 0.1, ZL * 2 + 0.14, xt, WY + 0.035, 0));                // pier
    solid.push(box(0.25, 0.025, ZL * 2 + 0.2, xt, WY - 0.005, 0));
    if (xt < 0) {                                                                // the south tower stands in its fender ring
      for (let i = 0; i < 72; i++) {
        const a0 = (i / 72) * Math.PI * 2, a1 = ((i + 1) / 72) * Math.PI * 2;
        for (const y of [WY + 0.02, WY + 0.05]) faint.push(xt + 0.3 * Math.cos(a0), y, 0.42 * Math.sin(a0), xt + 0.3 * Math.cos(a1), y, 0.42 * Math.sin(a1));
      }
    }
  }

  /* anchorages, the Fort Point arch ------------------------------------------------------- */
  for (const s of [-1, 1]) {
    const xa = s * XA, xb = s > 0 ? xa + 0.22 : SOUTH_ANCHOR;    // in San Francisco the cables run on over the arch
    solid.push(prismBetween([xb, WY - 0.02, 0], [xb, -TD - 0.012, 0], [0.2, 0.2], [0.17, 0.17]));      // anchorage block, under the roadway
    for (const zs of [-1, 1]) solid.push(box(0.16, 0.09 + TD, 0.034, xb - s * 0.04, (0.09 - TD) / 2, zs * (DW + 0.014)));   // cable housings beside it
    for (const px of s > 0 ? [xa + 0.02] : [xa - 0.02, -8.64]) for (const zs of [-1, 1]) {                   // Art Deco pylons
      solid.push(prismBetween([px, -TD, zs * ZL], [px, 0.3, zs * ZL], [0.034, 0.03], [0.026, 0.023]));
      solid.push(prismBetween([px, 0.3, zs * ZL], [px, 0.33, zs * ZL], [0.02, 0.018], [0.014, 0.012]));
    }
  }
  // the steel arch that carries the roadway over Fort Point, right where the south side span ends
  const AX0 = -8.62, AX1 = -7.84, AXC = (AX0 + AX1) / 2, AY0 = WY + 0.04, AYC = -TD - 0.025;
  const archY = (x) => AY0 + (AYC - AY0) * (1 - ((x - AXC) / ((AX1 - AX0) / 2)) ** 2);
  for (const z of [-DW + 0.01, DW - 0.01]) {
    for (let x = AX0; x < AX1 - 1e-6; x += 0.026) {
      const x1 = Math.min(AX1, x + 0.026);
      detail.push(x, archY(x), z, x1, archY(x1), z);
      faint.push(x, archY(x) - 0.035, z, x1, archY(x1) - 0.035, z);
    }
    for (let x = AX0 + PITCH / 2; x < AX1; x += PITCH / 2) faint.push(x, archY(x), z, x, -TD, z);
  }
  solid.push(prismBetween([AXC, WY - 0.02, 0.04], [AXC, WY + 0.11, 0.04], [0.17, 0.2], [0.155, 0.185]));   // the fort, at the water's edge

  /* the shores: height fields shaped to the real ends of the strait ------------------------- */
  // heights are above the water line; negative = depth. +x is north (Marin), -z is west (the ocean).
  const corridor = (x, z, h) => {                               // keep the ground below the roadway where the bridge crosses land
    const cut = x < -8.6 ? lerp(0.3, -WY - TD - 0.012, smoothstep(-8.7, XS, x)) : -TD - 0.03 - WY - 0.02 * Math.abs(x - Math.sign(x) * 8);
    const k = smoothstep(0.5, 0.18, Math.abs(z));
    return h > cut ? lerp(h, cut, k) : h;
  };
  const roadCut = (x, z, h) => {                                // cut and fill so the city road runs at grade
    if (x < -11.75 || x > -9.3 || z < -0.6 || z > 10.2) return h;
    const r = nearRoad(x, z), w = roadW(r.a);
    return lerp(h, roadY(r.a) - WY - 0.004, smoothstep(w + 0.22, w + 0.03, r.d));
  };
  const ripple = (x, z, a) => a * (Math.sin(x * 2.3 + z * 1.1) * 0.6 + Math.sin(x * 4.7 - z * 3.9) * 0.3 + Math.sin(x * 9.1 + z * 7.3) * 0.1);
  const g2 = (x, z, cx, cz, sx, sz) => Math.exp(-(((x - cx) / sx) ** 2) - ((z - cz) / sz) ** 2);
  const northH = (x, z) => {                                    // Marin: Lime Point, Battery Spencer, the headlands
    // a rounded point at Lime Point: west the coast bends north-west, east it curls into Horseshoe Bay
    const xc = 5.55 + (0.13 * z * z) / (1 + 0.25 * Math.abs(z)) + 0.1 * z + ripple(z, x, 0.04);
    const d = x - xc;
    if (d <= 0) return d * 0.5;                                  // the seabed shelves away offshore
    const west = smoothstep(0.6, -4.5, z);
    const top = 0.75 + 1.2 * west + 0.35 * smoothstep(9, 13, x) * west;      // Fort Baker's hills east, the headlands west
    const h = top * (1 - Math.exp(-d / lerp(1.3, 0.75, west))) + 0.07 * Math.max(0, d - 1.5)   // keeps rising inland, no plateaus
      + ripple(x, z, 0.06 * smoothstep(0, 0.6, d));
    return corridor(x, z, Math.max(0.005, h));
  };
  const southH = (x, z) => {                                    // San Francisco
    // the north shore: the Presidio bluffs west, Fort Point, Crissy Field and the Marina, Fort Mason, Aquatic Park;
    // then the waterfront turns south down the Embarcadero
    const xn = z < 0 ? -(7.9 + (0.11 * z * z) / (1 + 0.2 * -z) + 0.7 * Math.max(0, -4.0 - z) ** 2)   // Lands End: the coast turns south
      : -(7.9 + 0.03 * z) + 0.3 * Math.exp(-(((z - 7.8) / 0.45) ** 2)) - 0.2 * Math.exp(-(((z - 9.05) / 0.32) ** 2));
    const dn = xn + ripple(z, x, 0.03) - x, de = 12.3 + 0.35 * Math.max(0, -9.3 - x) - z;
    const d = Math.min(dn, de) - 0.15 * Math.log(1 + Math.exp(-Math.abs(dn - de) / 0.15)) + 0.104;   // rounded corner at North Beach
    if (d <= 0) return Math.max(d * 0.5, Math.min(0.26, 0.4 * g2(x, z, -6.55, 9.7, 0.32, 0.2) - 0.06));   // the bay, and Alcatraz
    // the Presidio: bluffs straight out of the water to the west, a steep rise behind Fort Point and Crissy Field
    const west = smoothstep(0.5, -0.6, z);
    const xp = lerp(-8.72, -9.7, smoothstep(0.4, 1.4, z));
    const pE = smoothstep(xp + 0.1, xp - 0.3, x), pW = 1 - Math.exp(-d / 0.28);
    const plateau = lerp(pE, pW, west) * (0.56 + 0.3 * smoothstep(-0.5, -3, z) - 0.55 * smoothstep(-3.2, -6, z)) * smoothstep(6.2, 3.4, z);   // lower toward Lands End
    const hills = 0.35 * g2(x, z, -12.3, -1.2, 1.3, 2.0) + 0.25 * g2(x, z, -12.8, -4.6, 0.9, 0.9)   // Sutro Heights
       + 0.3 * g2(x, z, -13.3, 3.6, 1.0, 1.5)      // the Presidio, Laurel Heights
      + 0.62 * g2(x, z, -11.9, 7.0, 0.85, 2.4)                                                      // Pacific Heights
      + 0.65 * g2(x, z, -9.95, 9.7, 0.5, 0.6) + 0.55 * g2(x, z, -10.9, 10.9, 0.55, 0.55)             // Russian Hill, Nob Hill
      + 0.42 * g2(x, z, -9.15, 11.25, 0.3, 0.32) + 0.13 * g2(x, z, -8.35, 7.8, 0.25, 0.35)            // Telegraph Hill, Fort Mason
      + 0.75 * g2(x, z, -15.4, 4.4, 1.7, 2.3) + 0.32 * g2(x, z, -15.1, 4.75, 0.45, 0.4)             // Twin Peaks: a massif, two summits
      + 0.3 * g2(x, z, -15.3, 5.45, 0.45, 0.4) + 0.5 * g2(x, z, -14.7, 2.5, 0.85, 0.75)               // and Mount Sutro
      + 0.06 * Math.max(0, -x - 11);
    const m = smoothstep(0, 0.7, d);
    const h = Math.max(0.005, 0.04 * (1 - Math.exp(-d / 0.25)) + plateau + m * hills
      + ripple(x, z, smoothstep(0, 0.5, d) * (0.05 * west + 0.07 * m * Math.min(1, hills))));   // the flats stay flat
    return x > XS - 0.05 ? corridor(x, z, h) : roadCut(x, z, h);
  };
  const terrain = [];                                            // faces, so hills hide what is behind them
  const shore = (hf, x0, x1, z0, z1, step, minor = faint, every = 0.06) => {
    const nx = Math.round((x1 - x0) / step), nz = Math.round((z1 - z0) / step), S = nz + 1;
    const H = new Float32Array((nx + 1) * S);
    for (let i = 0; i <= nx; i++) for (let j = 0; j <= nz; j++) H[i * S + j] = hf(x0 + i * step, z0 + j * step);
    const X = (i) => x0 + i * step, Z = (j) => z0 + j * step;
    // contours by marching squares: every ~6 m above water (index contour every fifth), shallows below it
    const levels = [];
    for (let L = every; L < 2.6; L += every) levels.push(L);
    const trace = (L, out, dash) => {
      let n = 0;
      for (let i = 0; i < nx; i++) for (let j = 0; j < nz; j++) {
        const a = H[i * S + j], b = H[(i + 1) * S + j], c = H[(i + 1) * S + j + 1], e = H[i * S + j + 1];
        const code = (a > L ? 1 : 0) | (b > L ? 2 : 0) | (c > L ? 4 : 0) | (e > L ? 8 : 0);
        if (code === 0 || code === 15) continue;
        const p = [];
        const edge = (h0, h1, xa, za, xb, zb) => { const t = (L - h0) / (h1 - h0); p.push([lerp(xa, xb, t), za + (zb - za) * t]); };
        if ((a > L) !== (b > L)) edge(a, b, X(i), Z(j), X(i + 1), Z(j));
        if ((b > L) !== (c > L)) edge(b, c, X(i + 1), Z(j), X(i + 1), Z(j + 1));
        if ((c > L) !== (e > L)) edge(c, e, X(i + 1), Z(j + 1), X(i), Z(j + 1));
        if ((e > L) !== (a > L)) edge(e, a, X(i), Z(j + 1), X(i), Z(j));
        const y = WY + Math.max(L, 0) + 0.002;
        for (let k = 0; k + 1 < p.length; k += 2) {
          if (dash && (n++ % 3) === 2) continue;
          out.push(p[k][0], y, p[k][1], p[k + 1][0], y, p[k + 1][1]);
        }
      }
    };
    trace(0, land, false);                                       // the coastline
    levels.forEach((L, k) => trace(L, (k + 1) % 5 === 0 ? land : minor, false));
    for (const L of [-0.035, -0.09]) trace(L, faint, true);      // shallows, dashed
    for (let i = 0; i < nx; i++) for (let j = 0; j < nz; j++) {   // ground surface, only where there is land
      const a = H[i * S + j], b = H[(i + 1) * S + j], c = H[(i + 1) * S + j + 1], e = H[i * S + j + 1];
      if (Math.max(a, b, c, e) <= 0) continue;
      const v = (ii, jj, h) => [X(ii), WY + Math.max(h, -0.03), Z(jj)];
      const A = v(i, j, a), B = v(i + 1, j, b), C = v(i + 1, j + 1, c), D = v(i, j + 1, e);
      terrain.push(...A, ...C, ...B, ...A, ...D, ...C);
    }
    return (x, z) => hf(x, z);
  };
  const hN = shore(northH, 5.0, 13.6, -6.2, 6.0, 0.07);
  const mid = [];                                               // the far shore's contours, a little stronger to carry the distance
  const hS = shore(southH, -16.6, -6.1, -6.2, 14.6, 0.075, mid, 0.09);   // seen from afar: half as many
  const ground = (x, z) => WY + Math.max(0, hS(x, z));

  // approach viaducts stand on the ground: Marin over Fort Baker, San Francisco between the arch and the abutment
  for (const xb of [8.7, 9.5, 10.3, 11.1]) for (const zs of [-1, 1]) {
    const g = WY + Math.max(0, hN(xb, zs * 0.13));
    if (g < -TD - 0.04) solid.push(prismBetween([xb, g - 0.02, zs * 0.13], [xb, -TD - 0.01, zs * 0.13], [0.026, 0.026], [0.022, 0.022]));
  }
  for (const xb of [-9.0, -9.35]) for (const zs of [-1, 1]) {
    const g = ground(xb, zs * 0.09);
    if (g < -TD - 0.04) solid.push(prismBetween([xb, g - 0.02, zs * 0.09], [xb, -TD - 0.01, zs * 0.09], [0.02, 0.02], [0.017, 0.017]));
  }
  { const g = ground(XS - 0.04, 0);                              // the abutment
    solid.push(box(0.08, -g - 0.008, 2 * (DW + 0.02), XS - 0.04, g / 2 - 0.004, 0)); }

  /* the city road: edges, lanes and the toll plaza ------------------------------------------ */
  const NRS = 200;
  for (let i = 0; i < NRS; i++) {
    const a0 = (i / NRS) * (RL - 0.1), a1 = ((i + 1) / NRS) * (RL - 0.1), p = roadAt(a0), q = roadAt(a1);
    const w0 = roadW(a0), w1 = roadW(a1), f0 = w0 / 0.085, f1 = w1 / 0.085;
    for (const s of [-1, 1]) detail.push(p.x + s * w0 * p.nx, p.y + 0.003, p.z + s * w0 * p.nz, q.x + s * w1 * q.nx, q.y + 0.003, q.z + s * w1 * q.nz);
    if (i % 2 === 0) for (const o of [0, -0.026, 0.026, -0.052, 0.052]) {
      faint.push(p.x + o * f0 * p.nx, p.y + 0.002, p.z + o * f0 * p.nz, q.x + o * f1 * q.nx, q.y + 0.002, q.z + o * f1 * q.nz);
    }
    const L0 = [p.x + w0 * p.nx, p.y + 0.001, p.z + w0 * p.nz], R0 = [p.x - w0 * p.nx, p.y + 0.001, p.z - w0 * p.nz];
    const L1 = [q.x + w1 * q.nx, q.y + 0.001, q.z + w1 * q.nz], R1 = [q.x - w1 * q.nx, q.y + 0.001, q.z - w1 * q.nz];
    terrain.push(...L0, ...R0, ...R1, ...L0, ...R1, ...L1);
  }
  { const a = 0.5, p = roadAt(a), w = roadW(a), f = w / 0.085;     // the toll plaza: canopy over a row of booths
    solid.push(box(0.09, 0.012, 2 * w + 0.03, p.x, 0.075, p.z));
    for (const o of [0, -0.026, 0.026, -0.052, 0.052, -0.078, 0.078]) solid.push(box(0.05, 0.036, 0.014, p.x, 0.018, p.z + o * f));
    for (const s of [-1, 1]) solid.push(box(0.03, 0.075, 0.03, p.x, 0.0375, p.z + s * (w + 0.005))); }

  /* the city: blocks over the hills, downtown's towers, a few landmarks -------------------- */
  const city = [], cr = rng(15);
  const bldg = (x, z, w, d, h) => {
    const hs = [hS(x - w / 2, z - d / 2), hS(x + w / 2, z - d / 2), hS(x - w / 2, z + d / 2), hS(x + w / 2, z + d / 2)];
    if (Math.min(...hs) < 0.012) return;                         // not in the water
    const g = WY + Math.min(...hs) - 0.004, top = WY + Math.max(...hs) + h;
    city.push(box(w, top - g, d, x, (top + g) / 2, z));
  };
  const DISTRICTS = [
    // x0, x1, z0, z1, density, base height, extra height, skew
    [-9.6, -8.2, 4.3, 7.3, 0.5, 0.02, 0.016, 1],                 // the Marina
    [-12.4, -9.6, 4.4, 9.2, 0.42, 0.022, 0.045, 2],              // Cow Hollow, Pacific Heights
    [-11.8, -8.3, 9.0, 11.7, 0.55, 0.026, 0.07, 2],              // Russian Hill, North Beach, Nob Hill
    [-13.6, -11.8, 9.0, 14.2, 0.5, 0.035, 0.14, 2.2],            // Van Ness, SoMa
    [-11.8, -9.3, 11.6, 14.2, 0.85, 0.05, 0.34, 1.7],            // downtown
    [-12.2, -10.6, -4.2, -1.4, 0.4, 0.02, 0.02, 1],              // Sea Cliff, above Baker Beach
    [-16.4, -12.2, -5.6, 2.4, 0.34, 0.02, 0.025, 1.5],           // the Richmond, rising toward Mount Sutro
    [-16.4, -13.2, 2.4, 9.0, 0.32, 0.02, 0.03, 1.5],             // the Haight, Cole Valley, Noe, up the flanks of Twin Peaks
  ];
  for (const [x0, x1, z0, z1, dens, h0, h1, p] of DISTRICTS) {
    for (let x = x0; x < x1; x += 0.14) for (let z = z0; z < z1; z += 0.14) {
      if (cr() > dens) continue;
      const bx = x + cr() * 0.05, bz = z + cr() * 0.05, w = 0.045 + cr() * 0.045, d = 0.045 + cr() * 0.045;
      if (nearRoad(bx, bz).d < 0.16 || (bx > -12.6 && bz < 4.2 && bx < -9.4 && bz > -1.4)) continue;   // the road; the Presidio stays wooded
      const fd = 0.35 + 0.65 * g2(bx, bz, -10.7, 12.8, 0.8, 0.9);   // tallest in the Financial District
      bldg(bx, bz, w, d, h0 + h1 * fd * cr() ** p);
    }
  }
  { const x = -10.1, z = 12.45, g = ground(x, z) - 0.005;            // the Transamerica Pyramid
    city.push(prismBetween([x, g, z], [x, g + 0.54, z], [0.04, 0.04], [0.003, 0.003])); }
  { const x = -11.75, z = 13.1, g = ground(x, z) - 0.005;            // Salesforce Tower, its rounded crown
    city.push(prismBetween([x, g, z], [x, g + 0.62, z], [0.045, 0.045], [0.036, 0.036]));
    city.push(prismBetween([x, g + 0.62, z], [x, g + 0.7, z], [0.036, 0.036], [0.016, 0.016])); }
  { const x = -9.15, z = 11.25, g = ground(x, z) - 0.005;            // Coit Tower on Telegraph Hill
    const c = new THREE.CylinderGeometry(0.014, 0.016, 0.1, 8); c.translate(x, g + 0.05, z); city.push(c); }
  { const x = -6.55, z = 9.7, g = WY + 0.26;                          // Alcatraz: the cellhouse and the lighthouse
    city.push(box(0.22, 0.04, 0.07, x - 0.02, g + 0.02, z), box(0.016, 0.09, 0.016, x + 0.1, g + 0.045, z - 0.03)); }
  scene.add(stage.wire(mergeParts(city), { crease: 30, silhouette: false, material: stage.mat.dim }));
  { const x = -15.0, z = 2.9, g = ground(x, z);                      // Sutro Tower on its hill: three legs, a waist, three masts
    const P = (r, a, y) => [x + r * Math.cos(a), g + y, z + r * Math.sin(a)];
    for (let k = 0; k < 3; k++) {
      const a = (k / 3) * Math.PI * 2 + 0.4, b = ((k + 1) / 3) * Math.PI * 2 + 0.4;
      land.push(...P(0.09, a, 0), ...P(0.03, a, 0.4), ...P(0.03, a, 0.4), ...P(0.07, a, 0.52), ...P(0.07, a, 0.52), ...P(0.07, a, 0.7));
      land.push(...P(0.03, a, 0.4), ...P(0.03, b, 0.4), ...P(0.07, a, 0.52), ...P(0.07, b, 0.52));
    }
  }
  scene.add(stage.wire(mergeParts(solid), { crease: 30, silhouette: false }));
  // optional paint on the steel (globalThis.XV_PAINT.bridge = { mode: 'full' | 'light' | 'hatch', strength }): the hot
  // end of the colour scale, near enough the bridge's own International Orange
  const PAINT = globalThis.XV_PAINT && globalThis.XV_PAINT.bridge;
  const towers = stage.wire(mergeParts(steel), { crease: 30, silhouette: false });
  if (PAINT && PAINT.mode && PAINT.mode !== 'none') towers.mesh.material = paintMaterial(stage, PAINT);
  scene.add(towers);
  scene.add(lines(stage, detail, stage.mat.dim));
  const tg = new THREE.BufferGeometry();
  tg.setAttribute('position', new THREE.Float32BufferAttribute(terrain, 3));
  scene.add(new THREE.Mesh(tg, stage.mat.face));

  /* open water ---------------------------------------------------------------------------- */
  for (let r = 0; r < 13; r++) for (let x = -14; x < 14; x += 0.5 + (r % 3) * 0.18) {
    const z = -4.5 + r * 1.25, x0 = x + r * 0.17, x1 = x0 + 0.24;
    if (Math.max(hN(x0, z), hS(x0, z), hN(x1, z), hS(x1, z)) < -0.12) faint.push(x0, WY, z, x1, WY, z);   // only out on open water
  }
  // the ground right under the viewpoint dissolves, so the drawing ends softly instead of filling tall frames
  const [CX, CY, CZ] = BRIDGE_VIEW.camera.position;
  const vignette = (segs, like, opacity) => {
    const col = new Float32Array(segs.length);
    for (let i = 0; i < segs.length; i += 3) {
      const f = smoothstep(2.2, 3.6, Math.hypot(segs[i] - CX, segs[i + 1] - CY, segs[i + 2] - CZ));
      col[i] = col[i + 1] = col[i + 2] = f;
    }
    const g = new LineSegmentsGeometry().setPositions(new Float32Array(segs)).setColors(col);
    return new LineSegments2(g, stage.lineMaterial({ width: like.linewidth, opacity, vertexColors: true }));
  };
  scene.add(vignette(faint, stage.mat.faint, 0.16), vignette(land, stage.mat.dim, 0.32), vignette(mid, stage.mat.faint, 0.24));

  /* main cables and suspenders (dynamic: they ride the deck) -------------------------------- */
  const CX0 = SOUTH_ANCHOR + 0.12, CX1 = XA, CS = 0.04, NCS = Math.round((CX1 - CX0) / CS);
  const cabArr = new Float32Array(2 * NCS * 6), cabCol = new Float32Array(2 * NCS * 6);
  const cabG = new LineSegmentsGeometry().setPositions(cabArr);
  const cabL = new LineSegments2(cabG, stage.lineMaterial({ width: 2.0 }));
  cabL.frustumCulled = false;
  const cabGlowG = new LineSegmentsGeometry().setPositions(new Float32Array(cabArr.length)).setColors(cabCol);
  const cabGlow = new LineSegments2(cabGlowG, stage.lineMaterial({ width: 3.2, additive: true, vertexColors: true }));
  cabGlow.frustumCulled = false; cabGlow.renderOrder = 2;

  const hangers = [];
  for (let x = -XA + 0.15; x <= XA - 0.15; x += PITCH) {
    if (Math.abs(Math.abs(x) - XT) < 0.1) continue;                               // no suspenders at the towers
    if (cableY(x) < 0.03) continue;
    hangers.push(x);
  }
  const NH = hangers.length * 2;
  const hArr = new Float32Array(NH * 6), hCol = new Float32Array(NH * 6);
  const hG = new LineSegmentsGeometry().setPositions(hArr);
  const hL = new LineSegments2(hG, stage.lineMaterial({ width: 0.75, opacity: 0.62 }));
  hL.frustumCulled = false;
  const hGlowG = new LineSegmentsGeometry().setPositions(new Float32Array(hArr.length)).setColors(hCol);
  const hGlow = new LineSegments2(hGlowG, stage.lineMaterial({ width: 1.8, additive: true, vertexColors: true }));
  hGlow.frustumCulled = false; hGlow.renderOrder = 2;
  scene.add(cabL, cabGlow, hL, hGlow);

  // bending glow along the truss's bottom chords
  const NSB = 360;
  const bArr = new Float32Array(NSB * 2 * 6), bCol = new Float32Array(NSB * 2 * 6);
  const bG = new LineSegmentsGeometry().setPositions(bArr).setColors(bCol);
  const bL = new LineSegments2(bG, stage.lineMaterial({ width: 2.0, additive: true, vertexColors: true }));
  bL.frustumCulled = false; bL.renderOrder = 2;
  scene.add(bL);

  /* fog: a soft bank drifting in low over the water, under the deck ------------------------- */
  const NF = 240;
  const fog = glowPoints(NF, { core: 0 });
  const fogP = fog.geometry.attributes.position.array, fogC = fog.geometry.attributes.color.array;
  const fogS = fog.geometry.attributes.size.array, fogA = fog.geometry.attributes.alpha.array;
  const fogSeed = [];
  for (let i = 0; i < NF; i++) {
    const low = rand() < 0.85;
    fogSeed.push({ x: -13 + rand() * 26, y: low ? WY + 0.04 + rand() * 0.3 : -0.12 + rand() * 0.7, z: -4.2 + rand() * 5.4,
      v: 0.1 + rand() * 0.12, ph: rand() * 6.28, s: 1.0 + rand() * 1.5, a: 0.014 + rand() * 0.022 });
    fogC[i * 3] = 0.8; fogC[i * 3 + 1] = 0.82; fogC[i * 3 + 2] = 0.86;
  }
  scene.add(fog);

  /* animate ----------------------------------------------------------------------------- */
  const H0 = Math.sqrt(1 + cableSlope(XT - 0.01) ** 2) - 1;                     // normalises cable tension
  stage.onUpdate((t, dt) => {
    for (const v of vehicles) {
      v.x0 += v.v * dt;
      if (v.x0 > LOOP) v.x0 -= LOOP;
      v.s = v.lane.dir > 0 ? S0 + v.x0 : S1 - v.x0;
      v.x = v.s >= XS ? v.s : 1e3;                                                 // only cars on the bridge load it
    }
    updateDeflection(t);

    const a = sPos.array;
    for (let i = 0; i < a.length; i += 3) a[i + 1] = sBase[i + 1] + wAt(a[i]);
    sPos.needsUpdate = true;
    const la = sLine.array;
    for (let i = 0; i < la.length; i += 3) la[i + 1] = sLineBase[i + 1] + wAt(la[i]);
    sLine.needsUpdate = true;
    for (const { b, base } of deformables) {
      const arr = b.array;
      for (let i = 0; i < arr.length; i += 3) arr[i + 1] = base[i + 1] + wAt(arr[i]);
      b.needsUpdate = true;
    }

    for (const v of vehicles) {
      v.w.visible = v.s < LD;
      if (v.s >= XS) {
        const slope = (wAt(v.s + 0.05) - wAt(v.s - 0.05)) / 0.1;
        v.w.position.set(v.s, wAt(v.s) + 0.007, v.lane.z);
        v.w.rotation.set(0, v.lane.dir > 0 ? 0 : Math.PI, v.lane.dir * slope);
      } else {                                                                     // on the road in the city
        const a = XS - v.s, r = roadAt(a), f = roadW(a) / 0.085, d = v.lane.dir;
        v.w.position.set(r.x + v.lane.z * f * r.nx, r.y + 0.004, r.z + v.lane.z * f * r.nz);
        v.w.rotation.set(0, Math.atan2(d * r.tz, -d * r.tx), -d * (roadY(a + 0.05) - roadY(a - 0.05)) / 0.1);
      }
    }

    // main cables: the deck's deflection pulls them down a little; tension grows toward the saddles
    const live = (x) => (Math.abs(x) <= XT ? 0.7 : 0.4) * wAt(x);
    for (let c = 0; c < 2; c++) {
      const z = c ? DW : -DW;
      for (let i = 0; i < NCS; i++) {
        const x0 = CX0 + i * CS, x1 = x0 + CS, o = (c * NCS + i) * 6;
        cabArr[o] = x0; cabArr[o + 1] = cableY(x0) + live(x0); cabArr[o + 2] = z;
        cabArr[o + 3] = x1; cabArr[o + 4] = cableY(x1) + live(x1); cabArr[o + 5] = z;
        for (let e = 0; e < 2; e++) {
          const x = e ? x1 : x0;
          const T = clamp(0.12 + 0.62 * (Math.sqrt(1 + cableSlope(x) ** 2) - 1) / H0 + 0.08 * load(x), 0, 1);
          gradientLinear(T, cabCol, o + e * 3, (0.06 + 0.5 * smoothstep(0.2, 1, T)) * FX.value);
        }
      }
    }
    cabG.attributes.instanceStart.data.needsUpdate = true;
    cabGlowG.attributes.instanceStart.data.array.set(cabArr);
    cabGlowG.attributes.instanceStart.data.needsUpdate = true;
    cabGlowG.attributes.instanceColorStart.data.needsUpdate = true;

    // suspenders: tension rises as traffic passes beneath
    for (let k = 0; k < hangers.length; k++) {
      const x = hangers[k], yd = wAt(x) + 0.007, yc = cableY(x) + live(x);
      const T = clamp(0.1 + 0.38 * load(x) + 0.03 * Math.sin(t * 1.3 + k), 0, 1);
      const f = (0.015 + 0.98 * smoothstep(0.3, 1.0, T)) * FX.value;
      for (let c = 0; c < 2; c++) {
        const z = c ? DW : -DW, o = (k * 2 + c) * 6;
        hArr[o] = x; hArr[o + 1] = yd; hArr[o + 2] = z; hArr[o + 3] = x; hArr[o + 4] = yc; hArr[o + 5] = z;
        gradientLinear(T, hCol, o, f); gradientLinear(T, hCol, o + 3, f * 0.4);
      }
    }
    hG.attributes.instanceStart.data.needsUpdate = true;
    hGlowG.attributes.instanceStart.data.array.set(hArr);
    hGlowG.attributes.instanceStart.data.needsUpdate = true;
    hGlowG.attributes.instanceColorStart.data.needsUpdate = true;

    const h = 0.2;
    for (let e = 0; e < 2; e++) {
      const z = e ? DW : -DW;
      for (let i = 0; i < NSB; i++) {
        const x0 = lerp(XS, LD, i / NSB), x1 = lerp(XS, LD, (i + 1) / NSB), o = (e * NSB + i) * 6;
        bArr[o] = x0; bArr[o + 1] = wAt(x0) - TD; bArr[o + 2] = z;
        bArr[o + 3] = x1; bArr[o + 4] = wAt(x1) - TD; bArr[o + 5] = z;
        for (let e2 = 0; e2 < 2; e2++) {
          const xx = e2 ? x1 : x0;
          const curv = Math.abs(wAt(xx + h) - 2 * wAt(xx) + wAt(xx - h)) / (h * h);
          const q = clamp(curv * 40, 0, 1);
          gradientLinear(q, bCol, o + e2 * 3, (0.03 + 0.9 * q) * FX.value * 0.8);
        }
      }
    }
    bG.attributes.instanceStart.data.needsUpdate = true;
    bG.attributes.instanceColorStart.data.needsUpdate = true;

    // fog drifts in from the ocean side and slowly breathes
    fog.material.uniforms.uScale.value = stage.pointScale;
    for (let i = 0; i < NF; i++) {
      const F = fogSeed[i];
      let x = F.x + F.v * t;
      x = ((x + 13) % 26 + 26) % 26 - 13;
      fogP[i * 3] = x; fogP[i * 3 + 1] = F.y + 0.04 * Math.sin(t * 0.2 + F.ph); fogP[i * 3 + 2] = F.z;
      fogS[i] = F.s * (0.9 + 0.1 * Math.sin(t * 0.3 + F.ph));
      fogA[i] = F.a * smoothstep(13, 10, Math.abs(x)) * (0.8 + 0.2 * Math.sin(t * 0.25 + F.ph * 2));
    }
    for (const k of ['position', 'size', 'alpha']) fog.geometry.attributes[k].needsUpdate = true;
  });

  return stage;
}
