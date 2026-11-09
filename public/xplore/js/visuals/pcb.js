/*
 * XV-03 — An RTX 5090 board with its cooler off, laid out after a real one: the Gigabyte GeForce
 * RTX 5090 Gaming OC, measured from TechPowerUp's PCB photograph (scaled by its PCIe x16 fingers),
 * at 1 unit = 16.7 mm. A 232 × 141 mm board. The GB202 die (24 × 31 mm, 750 mm²) on its package
 * just right of centre, hugged by sixteen 12 × 14 mm GDDR7 chips, five down each side, four above
 * and two below, for a 512-bit bus; around them the power: twenty-two GPU phases in two tall columns of
 * power stages and chokes, the silver polymer capacitors outside them, seven memory phases along the
 * top edge and at the far end; the 16-pin 12V-2x6 connector on the top edge; three DisplayPorts and an
 * HDMI at the front end; the PCIe 5.0 x16 fingers along the bottom.
 * Parts sit where they are on the real board; the copper is generated, routed the way such boards are
 * (on the real card most of it runs on inner layers): each 32-bit memory channel a bundle fanning out
 * of the package with length-matching serpentines, the PCIe lanes as differential pairs down to the
 * fingers through their AC-coupling capacitors, the display lanes threading out beneath the power stage.
 * The glow is a proxy of the near-field |E| travelling with each signal: memory bursts (read and write)
 * hottest, PCIe and display cooler; the power stages fire in rotation and the die shimmers with work.
 */
import {
  THREE, Stage, mergeParts, circleSegments, lines, rng, GLSL_GRADIENT, FX, glowPoints, gradientSRGB,
} from './core.js';

const S = 0.06;                 // world units per mm
const BT = 1.6 * S;             // board thickness
const TY = 0.004;               // copper height above the board
const BX = 232, BY0 = 11, BY1 = 141;      // board, finger tips at y = 0
const CX = 112, CY = 70;
const W = (x) => (x - CX) * S, Zc = (y) => -(y - CY) * S, H = (h) => h * S;

/* GB202 package and the sixteen GDDR7 chips (mm, measured) */
const SUB = { x0: 87.2, x1: 124.2, y0: 50.1, y1: 99.1, h: 1.6 };   // package substrate, top at 1.6 mm
const DIE = { x0: 93.7, x1: 117.7, y0: 59.1, y1: 90.1, h: 2.35 };  // 24 × 31 mm, portrait
const MEM_W = 14, MEM_D = 12, MEM_H = 1.1;                          // 266-ball FBGA, 12 × 14 × 1.1 mm
const COLY = [47.8, 61.3, 74.9, 88.4, 102.0];
const MEMS = [
  ...COLY.map((y) => ({ x: 63, y, rot: 0, side: 'left' })),
  ...COLY.map((y) => ({ x: 148, y, rot: 0, side: 'right' })),
  ...[85.6, 99.0, 112.4, 125.8].map((x) => ({ x, y: 114.3, rot: 1, side: 'top' })),
  ...[85, 124].map((x) => ({ x, y: 38, rot: 0, side: 'bottom' })),
];
const memBox = (m) => (m.rot ? [m.x - MEM_D / 2, m.y - MEM_W / 2, m.x + MEM_D / 2, m.y + MEM_W / 2] : [m.x - MEM_W / 2, m.y - MEM_D / 2, m.x + MEM_W / 2, m.y + MEM_D / 2]);
const TAB = [44.5, 129.5];
const pinX = (n) => (n <= 11 ? 45.0 + (n - 1) : 57.9 + (n - 12));   // PCIe x16 finger centres, key between 11 and 12
const FT = 5.8;                                                       // finger tops

/* --------------------------------------------------------------- 2D helpers */

function offsetPolyline(pts, off) {
  const out = [];
  for (let i = 0; i < pts.length; i++) {
    const p = pts[i];
    let n1 = null, n2 = null;
    if (i > 0) { const dx = p[0] - pts[i - 1][0], dz = p[1] - pts[i - 1][1], l = Math.hypot(dx, dz) || 1; n1 = [-dz / l, dx / l]; }
    if (i < pts.length - 1) { const dx = pts[i + 1][0] - p[0], dz = pts[i + 1][1] - p[1], l = Math.hypot(dx, dz) || 1; n2 = [-dz / l, dx / l]; }
    n1 = n1 || n2; n2 = n2 || n1;
    let mx = n1[0] + n2[0], mz = n1[1] + n2[1];
    let ml = Math.hypot(mx, mz);
    if (ml < 1e-6) { mx = n1[0]; mz = n1[1]; ml = 1; }
    mx /= ml; mz /= ml;
    const k = Math.max(-3 * Math.abs(off), Math.min(3 * Math.abs(off), off / Math.max(0.2, mx * n1[0] + mz * n1[1])));
    out.push([p[0] + mx * k, p[1] + mz * k]);
  }
  return out;
}
const lerp2 = (a, b, t) => [a[0] + (b[0] - a[0]) * t, a[1] + (b[1] - a[1]) * t];
const len2 = (pts) => { let L = 0; for (let i = 1; i < pts.length; i++) L += Math.hypot(pts[i][0] - pts[i - 1][0], pts[i][1] - pts[i - 1][1]); return L; };

// square-wave serpentine between a and b adding about `extra` mm, amplitude A, period P
function serpentine(a, b, extra, A, P) {
  const L = Math.hypot(b[0] - a[0], b[1] - a[1]);
  const u = [(b[0] - a[0]) / L, (b[1] - a[1]) / L], n = [-u[1], u[0]];
  const m = Math.min(Math.floor((L - 0.8) / P), Math.round(extra / (4 * A)));
  if (m < 1) return [];
  const s0 = (L - m * P) / 2, out = [];
  const at = (s, o) => [a[0] + u[0] * s + n[0] * o, a[1] + u[1] * s + n[1] * o];
  for (let k = 0; k < m; k++) {
    const s = s0 + k * P;
    out.push(at(s, 0), at(s, A), at(s + P / 2, A), at(s + P / 2, -A), at(s + P, -A), at(s + P, 0));
  }
  return out;
}

/* --------------------------------------------------------------- signal shader */

const signalMaterial = () => new THREE.ShaderMaterial({
  uniforms: { uTime: { value: 0 }, uFx: FX },
  vertexShader: /* glsl */ `
    attribute float aS; attribute float aSide; attribute vec4 aP1; attribute vec4 aP2; attribute vec3 aAmp;
    varying float vS; varying float vSide; varying vec4 vP1; varying vec4 vP2; varying vec3 vAmp;
    void main() {
      vS = aS; vSide = aSide; vP1 = aP1; vP2 = aP2; vAmp = aAmp;
      gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
    }`,
  fragmentShader: /* glsl */ `
    ${GLSL_GRADIENT}
    uniform float uTime; uniform float uFx;
    varying float vS; varying float vSide; varying vec4 vP1; varying vec4 vP2; varying vec3 vAmp;
    float hash(float n) { return fract(sin(n * 12.9898 + 78.233) * 43758.5453); }
    void main() {
      float speed = vP1.x, period = vP1.y, phase = vP1.z, seed = vP1.w;
      float L = vP2.x, dir = vP2.y, bitLen = vP2.z, burst = vP2.w;
      float tt = uTime * speed + phase;
      float cyc = floor(tt / period);
      float h = tt - cyc * period;
      // bidirectional links turn around between bursts (write / read)
      if (dir > 1.5) dir = hash(cyc * 3.7 + floor(seed * 0.01)) > 0.5 ? 1.0 : -1.0;
      float sd = dir > 0.0 ? vS : L - vS;
      float d = h - sd;                                  // distance behind the wavefront
      if (d < -0.02 || d > burst) discard;
      float bi = floor(d / bitLen);
      float fr = fract(d / bitLen);
      float b0 = hash(bi + seed * 17.13 + cyc * 5.1) > 0.45 ? 1.0 : 0.12;
      float b1 = hash(bi - 1.0 + seed * 17.13 + cyc * 5.1) > 0.45 ? 1.0 : 0.12;
      float level = mix(b1, b0, smoothstep(0.0, 0.28, fr));
      float front = exp(-max(d, 0.0) / (min(burst, 3.0) * 0.35));
      float tail = 1.0 - smoothstep(burst * 0.7, burst, d);
      float spike = exp(-d * d / 0.0012);
      float E = max(level * (0.12 + 0.88 * front) * tail, spike);            // |E| proxy -> colour
      float I = max(level * (0.55 + 0.45 * front) * tail, spike) * vAmp.x;   // brightness
      float sd2 = vSide * vSide;
      float core = exp(-sd2 * 30.0);                     // conductor
      float halo = exp(-sd2 * 4.0) * 0.6 * E;            // fringing field, grows with |E|
      float a = I * (core * 3.0 + halo * 2.2) * uFx;
      gl_FragColor = vec4(xvGradient(mix(vAmp.y, vAmp.z, E)) * a, 1.0);   // each link class has its own part of the scale
    }`,
  transparent: true, depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
});

// link classes: speed (units/s), bit length, burst, gap (units), direction (1 out of the GPU, -1 in, 2 both), brightness, colour range, half width (mm)
const CLS = {
  mem: { speed: 2.4, bitLen: 0.04, burst: 2.2, gap: 0.25, dir: 2, amp: 1.7, hue: [0.45, 1.0], hw: 0.36 },
  pcie: { speed: 2.2, bitLen: 0.032, burst: 2.6, gap: 0.3, dir: 2, amp: 2.2, hue: [0.25, 0.82], hw: 0.34 },
  disp: { speed: 2.4, bitLen: 0.04, burst: 5.0, gap: 0.1, dir: 1, amp: 2.3, hue: [0.12, 0.66], hw: 0.4 },
  pwr: { speed: 0.9, bitLen: 0.5, burst: 0.55, gap: 0.0, dir: -1, amp: 0.9, hue: [0.05, 0.4], hw: 1.1 },
  v12: { speed: 0.7, bitLen: 0.6, burst: 1.2, gap: 0.6, dir: 1, amp: 0.7, hue: [0.0, 0.3], hw: 1.4 },
};

/* --------------------------------------------------------------- mount */

export const PCB_VIEW = {
  camera: { fov: 26, position: [3.9, 13.2, 15.4], target: [0.2, 0.2, 0.2] },
  refAspect: 1.8,
  drift: (t) => ({ yaw: Math.sin(t * 0.04) * 0.16, pitch: Math.sin(t * 0.03) * 0.04 }),
  speed: 1,
};

export function mountPCB(el, opts = {}) {
  const stage = opts.stage || new Stage(el, {
    ...PCB_VIEW,
    ...opts,
    hud: !opts.hud ? false : {
      id: 'XV-03 / ELECTRONICS',
      title: 'RTX 5090 BOARD · GB202 · 512-BIT GDDR7 · PCIe 5.0 x16',
      rows: [['MEMORY', 'ddr'], ['HOST', 'pcie'], ['CORE', 'vrm'], ['T SIM', 'tsim']],
      colorbar: { label: 'NEAR-FIELD |E| · kV/m', ticks: ['0', '40', '80'] },
      time: '×1 / 3·10⁸',
    },
  });
  const sm = signalMaterial();
  stage.onUpdate((t) => {
    sm.uniforms.uTime.value = t;
    if (stage.hud) {
      stage.hud.set('ddr', '16 × GDDR7 · 512-BIT');
      stage.hud.set('pcie', 'PCIe 5.0 x16');
      stage.hud.set('vrm', '22 + 7 PHASES');
      stage.hud.set('tsim', `${(t * 3.333).toFixed(3)} NS`);
    }
  });
  build(stage, sm);
  return stage;
}

function build(stage, sm) {
  const { scene } = stage;
  const Xv = new THREE.Vector3(1, 0, 0), Zv = new THREE.Vector3(0, 0, 1);
  const rand = rng(31);

  /* occupancy grid (0.5 mm): what the parts and routes already use ------------------------------ */
  const GR = 0.5, GW = Math.ceil(BX / GR) + 1, GH = Math.ceil(BY1 / GR) + 1;
  const occ = new Uint8Array(GW * GH);
  const mark = (x0, y0, x1, y1, pad = 0.4) => {
    for (let i = Math.max(0, Math.floor((x0 - pad) / GR)); i <= Math.min(GW - 1, Math.ceil((x1 + pad) / GR)); i++)
      for (let j = Math.max(0, Math.floor((y0 - pad) / GR)); j <= Math.min(GH - 1, Math.ceil((y1 + pad) / GR)); j++) occ[j * GW + i] = 1;
  };
  const free = (x0, y0, x1, y1, pad = 0.3) => {
    if (x0 - pad < 1.5 || x1 + pad > BX - 1.5 || y0 - pad < BY0 + 1.2 || y1 + pad > BY1 - 1.2) return false;
    for (let i = Math.floor((x0 - pad) / GR); i <= Math.ceil((x1 + pad) / GR); i++)
      for (let j = Math.floor((y0 - pad) / GR); j <= Math.ceil((y1 + pad) / GR); j++) if (occ[j * GW + i]) return false;
    return true;
  };
  const markPath = (pts, hw) => { for (let i = 1; i < pts.length; i++) { const a = pts[i - 1], b = pts[i]; mark(Math.min(a[0], b[0]), Math.min(a[1], b[1]), Math.max(a[0], b[0]), Math.max(a[1], b[1]), hw + 0.35); } };

  /* parts: boxes (merged into one wire), cylinders, and their printed detail -------------------- */
  const boxes = [], small = [], cyls = [], detail = [], soft = [], silk = [], faint = [], vias = [], holes = [];
  const box = (x0, y0, x1, y1, h0, h1, pad = 0.4, tiny = false) => {
    const g = new THREE.BoxGeometry((x1 - x0) * S, (h1 - h0) * S, (y1 - y0) * S);
    g.translate(W((x0 + x1) / 2), H((h0 + h1) / 2), Zc((y0 + y1) / 2));
    (tiny ? small : boxes).push(g);
    if (pad !== null) mark(x0, y0, x1, y1, pad);
  };
  const rectOn = (out, x0, y0, x1, y1, h) => {
    const P = [[x0, y0], [x1, y0], [x1, y1], [x0, y1]];
    for (let i = 0; i < 4; i++) { const a = P[i], b = P[(i + 1) % 4]; out.push(W(a[0]), H(h) + 0.0015, Zc(a[1]), W(b[0]), H(h) + 0.0015, Zc(b[1])); }
  };
  const circleOn = (out, x, y, h, r, n = 16) => circleSegments(out, new THREE.Vector3(W(x), H(h) + 0.0015, Zc(y)), Xv, Zv, r * S, n);
  const lineOn = (out, x0, y0, x1, y1, h) => out.push(W(x0), H(h) + 0.0015, Zc(y0), W(x1), H(h) + 0.0015, Zc(y1));
  const cylinder = (x, y, r, h, n = 24) => {
    const g = new THREE.CylinderGeometry(r * S, r * S, h * S, n, 1);
    g.translate(W(x), H(h / 2), Zc(y));
    cyls.push(g);
    mark(x - r, y - r, x + r, y + r, 0.4);
    circleOn(detail, x, y, h, r * 0.75, 20);                       // the can's rolled rim
  };
  const qfn = (x, y, w, d, h = 0.9) => {                            // QFN: body, pin-1 dot, perimeter pads
    box(x - w / 2, y - d / 2, x + w / 2, y + d / 2, 0, h, 0.5);
    circleOn(detail, x - w / 2 + 0.7, y + d / 2 - 0.7, h, 0.25, 8);
    const n = Math.max(3, Math.round(w / 0.8));
    for (let e = 0; e < n; e++) {
      const o = -w / 2 + (e + 0.5) * (w / n);
      lineOn(detail, x + o, y - d / 2, x + o, y - d / 2 - 0.35, 0.02); lineOn(detail, x + o, y + d / 2, x + o, y + d / 2 + 0.35, 0.02);
    }
  };

  /* board outline: main body, the x16 tab with its key, rounded far corners ----------------------- */
  const outline = [[0, BY0], [TAB[0], BY0], [TAB[0], 1], [TAB[0] + 1, 0], [55.5, 0], [55.5, 6.6], [56.45, 7.6], [57.4, 6.6], [57.4, 0], [TAB[1] - 1, 0], [TAB[1], 1], [TAB[1], BY0],
    [BX - 3, BY0], [BX - 0.9, BY0 + 0.9], [BX, BY0 + 3], [BX, BY1 - 3], [BX - 0.9, BY1 - 0.9], [BX - 3, BY1], [0, BY1]];
  const shape = new THREE.Shape(outline.map(([x, y]) => new THREE.Vector2(W(x), -Zc(y))));
  const boardG = new THREE.ExtrudeGeometry(shape, { depth: BT, bevelEnabled: false });
  boardG.rotateX(-Math.PI / 2);
  boardG.translate(0, -BT, 0);
  scene.add(stage.wire(boardG, { crease: 30, silhouette: false }));

  /* mounting holes where the real board has them: the cooler's four at the package corners, the rest round the edge */
  for (const [x, y] of [[17.4, 133.4], [41, 136.4], [99, 133], [153, 135.5], [189.3, 133], [227, 133], [3.5, 103], [73.6, 113.8], [136.7, 113.2],
    [73.6, 37.2], [136.4, 37.2], [146.7, 20.5], [198, 26.5], [227.1, 102.8]]) {
    const r = 1.6;
    circleOn(holes, x, y, 0, r, 28); circleOn(holes, x, y, 0, r + 1.5, 28);
    for (let k = 0; k < 8; k++) { const a = (k / 8) * Math.PI * 2; circleOn(vias, x + Math.cos(a) * (r + 2.4), y + Math.sin(a) * (r + 2.4), 0, 0.25, 8); }
    mark(x - r - 2.8, y - r - 2.8, x + r + 2.8, y + r + 2.8, 0);
  }

  /* signals ------------------------------------------------------------------------------------ */
  const copper = [], copperIn = [];
  const pos = [], aS = [], aSide = [], aP1 = [], aP2 = [], aAmp = [], idx = [];
  const groups = new Map();
  // path: [[x, y, h], ...] in mm; drawn as copper and as a glowing ribbon
  const signal = (path, clsName, group, k, o2 = {}) => {
    const cls = CLS[clsName];
    if (!groups.has(group)) groups.set(group, { phase: rand() * 10, seed: rand() * 1000 });
    const G = groups.get(group);
    const pts = [];
    for (const p of path) if (!pts.length || Math.hypot(p[0] - pts[pts.length - 1][0], p[1] - pts[pts.length - 1][1], p[2] - pts[pts.length - 1][2]) > 1e-4) pts.push(p);
    if (pts.length < 2) return;
    const hw = o2.hw ?? cls.hw;
    for (let i = 1; i < pts.length; i++) (o2.inner ? copperIn : copper).push(W(pts[i - 1][0]), H(pts[i - 1][2]) + TY, Zc(pts[i - 1][1]), W(pts[i][0]), H(pts[i][2]) + TY, Zc(pts[i][1]));
    if (!o2.inner) markPath(pts.filter((p) => p[2] < 0.1), hw);
    const p2 = pts.map((p) => [p[0], p[1]]);
    const up = offsetPolyline(p2, hw), dn = offsetPolyline(p2, -hw);
    let L = 0;
    for (let i = 1; i < pts.length; i++) L += Math.hypot(pts[i][0] - pts[i - 1][0], pts[i][1] - pts[i - 1][1], pts[i][2] - pts[i - 1][2]);
    L *= S;
    const period = Math.max(L, 1.0) + cls.burst + cls.gap;
    const base = pos.length / 3;
    const amp = cls.amp * (o2.inner ? 0.6 : 1);
    let s = 0;
    for (let i = 0; i < pts.length; i++) {
      if (i > 0) s += Math.hypot(pts[i][0] - pts[i - 1][0], pts[i][1] - pts[i - 1][1], pts[i][2] - pts[i - 1][2]) * S;
      for (const [p, side] of [[up[i], 1], [dn[i], -1]]) {
        pos.push(W(p[0]), H(pts[i][2]) + TY + 0.001, Zc(p[1]));
        aS.push(s); aSide.push(side); aAmp.push(amp, cls.hue[0], cls.hue[1]);
        aP1.push(cls.speed, period, (o2.phase !== undefined ? o2.phase * period : G.phase * cls.speed), G.seed + k * 1.37);
        aP2.push(L, o2.dir ?? cls.dir, cls.bitLen, cls.burst);
      }
      if (i > 0) { const b = base + (i - 1) * 2; idx.push(b, b + 1, b + 2, b + 1, b + 3, b + 2); }
    }
  };

  /* the GB202: package substrate, bare die, capacitors on the substrate corners ------------------ */
  box(SUB.x0, SUB.y0, SUB.x1, SUB.y1, 0.4, SUB.h, 0.8);
  box(DIE.x0, DIE.y0, DIE.x1, DIE.y1, SUB.h, DIE.h, null);
  { // silicon sheen: fine 45° lines across the die, x − y = c clipped to its rectangle
    const { x0, x1, y0, y1 } = DIE;
    for (let c = x0 - y1 + 1.2; c < x1 - y0; c += 1.9) {
      const a = [Math.max(x0, y0 + c), Math.max(x0, y0 + c) - c], b = [Math.min(x1, y1 + c), Math.min(x1, y1 + c) - c];
      if (b[0] - a[0] > 0.5) lineOn(faint, a[0], a[1], b[0], b[1], DIE.h);
    }
  }
  rectOn(detail, DIE.x0 + 1.0, DIE.y0 + 1.0, DIE.x1 - 1.0, DIE.y1 - 1.0, DIE.h);
  for (const [cx0, cy0, sx, sy] of [[SUB.x0, SUB.y0, 1, 1], [SUB.x1, SUB.y0, -1, 1], [SUB.x0, SUB.y1, 1, -1], [SUB.x1, SUB.y1, -1, -1]]) {
    for (let i = 0; i < 3; i++) for (let j = 0; j < 3; j++) {
      if (i + j > 2) continue;
      const x = cx0 + sx * (1.6 + i * 1.8), y = cy0 + sy * (1.6 + j * 1.5);
      box(x - 0.5, y - 0.25, x + 0.5, y + 0.25, SUB.h, SUB.h + 0.5, null, true);
    }
  }
  rectOn(silk, SUB.x0 - 1.2, SUB.y0 - 1.2, SUB.x1 + 1.2, SUB.y1 + 1.2, 0);

  /* GDDR7: sixteen FBGA packages with their marking and pin-1 dot ---------------------------------- */
  for (const m of MEMS) {
    const [x0, y0, x1, y1] = memBox(m);
    box(x0, y0, x1, y1, 0, MEM_H, 0.6);
    circleOn(detail, x0 + 1.3, y1 - 1.3, MEM_H, 0.4, 12);
    const horiz = x1 - x0 >= y1 - y0;
    for (const [f, w] of [[0.4, 1], [0.53, 0.7], [0.66, 0.85]]) {
      if (horiz) lineOn(faint, x0 + 2.4, y0 + (y1 - y0) * f, x0 + 2.4 + (x1 - x0 - 4.8) * w, y0 + (y1 - y0) * f, MEM_H);
      else lineOn(faint, x0 + (x1 - x0) * f, y0 + 2.4, x0 + (x1 - x0) * f, y0 + 2.4 + (y1 - y0 - 4.8) * w, MEM_H);
    }
    rectOn(silk, x0 - 0.8, y0 - 0.8, x1 + 0.8, y1 + 0.8, 0);
  }

  /* memory channels: from the die, across the substrate, fanning out to each chip ------------------ */
  const HS = SUB.h;
  const bundle = (n, d0, d1, s0, s1, c0, c1, out, into, group, stub2 = 3.6) => {
    const paths = [];
    for (let i = 0; i < n; i++) {
      const t = (i + 0.5) / n;
      const d = lerp2(d0, d1, t), s = lerp2(s0, s1, t), c = lerp2(c0, c1, t);
      const r = [s[0] + out[0] * 0.8, s[1] + out[1] * 0.8];
      const e1 = [s[0] + out[0] * 2.0, s[1] + out[1] * 2.0], e2 = [c[0] - into[0] * stub2, c[1] - into[1] * stub2];
      paths.push({ d, s, r, e1, e2, c, end: [c[0] + into[0] * 1.5, c[1] + into[1] * 1.5] });
    }
    const Ls = paths.map((p) => len2([p.r, p.e1, p.e2, p.c]));
    const Lmax = Math.max(...Ls), pitch = Math.hypot(c1[0] - c0[0], c1[1] - c0[1]) / n;
    paths.forEach((p, i) => {
      const meander = serpentine(p.e2, p.c, Lmax - Ls[i], Math.min(0.3, pitch * 0.36), 0.9);
      signal([[...p.d, HS], [...p.s, HS], [...p.r, 0], [...p.e1, 0], [...p.e2, 0], ...meander.map((q) => [...q, 0]), [...p.c, 0], [...p.end, 0]], 'mem', group, i);
    });
  };
  const M = 16;
  for (const side of ['left', 'right']) {                           // five down each side
    const sx = side === 'left' ? -1 : 1, dx = side === 'left' ? DIE.x0 : DIE.x1, subx = side === 'left' ? SUB.x0 : SUB.x1;
    MEMS.filter((m) => m.side === side).forEach((m, k) => {
      const [x0, y0, x1] = memBox(m), cx = side === 'left' ? x1 : x0;
      const dy0 = DIE.y0 + 6.2 * k + 0.3, sy0 = 51 + 9.5 * k;
      bundle(M, [dx, dy0], [dx, dy0 + 5.6], [subx, sy0], [subx, sy0 + 8.5], [cx, y0 + 1], [cx, y0 + MEM_D - 1], [sx, 0], [sx, 0], `mem-${side}${k}`);
    });
  }
  MEMS.filter((m) => m.side === 'top').forEach((m, k) => {          // four above
    const [x0, y0] = memBox(m);
    const dx0 = DIE.x0 + 6 * k + 0.3, sx0 = 88.4 + 8.6 * k;
    bundle(M, [dx0, DIE.y1], [dx0 + 5.4, DIE.y1], [sx0, SUB.y1], [sx0 + 8, SUB.y1], [x0 + 1, y0], [x0 + MEM_D - 1, y0], [0, 1], [0, 1], `mem-top${k}`, 2.4);
  });
  const botDie = [[93.9, 96.3], [112.7, 117.5]], botSub = [[88.2, 93.3], [113.8, 123.2]];
  MEMS.filter((m) => m.side === 'bottom').forEach((m, k) => {       // two beneath, either side of the PCIe lanes
    const [x0, , , y1] = memBox(m);
    bundle(M, [botDie[k][0], DIE.y0], [botDie[k][1], DIE.y0], [botSub[k][0], SUB.y0], [botSub[k][1], SUB.y0], [x0 + 1, y1], [x0 + MEM_W - 1, y1], [0, -1], [0, -1], `mem-bot${k}`, 2.4);
  });

  /* PCIe 5.0 x16: sixteen differential pairs from the die down to the fingers, AC-coupled near the edge */
  const lanePins = [];
  for (let k = 0; k < 16; k++) { const p = 14 + 4 * k + (k >= 4 ? 1 : 0); lanePins.push(p, p + 1); }
  const NP = lanePins.length;
  const xg = (j) => 98.6 + ((j + 0.5) / NP) * 14.2, xd = (j) => 99.4 + ((j + 0.5) / NP) * 12.6;
  let split = 0; for (let j = 0; j < NP; j++) if (pinX(lanePins[j]) <= xg(j)) split = j;
  const ch = 0.7;
  for (let j = 0; j < NP; j++) {
    const xf = pinX(lanePins[j]), x = xg(j), yh = 13.2 + 0.25 * Math.abs(j - split);
    const sgn = Math.sign(xf - x) || 1;
    const turn = Math.abs(xf - x) > 2 * ch + 0.1
      ? [[x, yh + ch, 0], [x + sgn * ch, yh, 0], [xf - sgn * ch, yh, 0], [xf, yh - ch, 0]]
      : [[x, yh + ch, 0], [xf, yh - ch, 0]];
    signal([[xd(j), DIE.y0, HS], [x, SUB.y0, HS], [x, SUB.y0 - 0.8, 0], ...turn, [xf, FT, 0], [xf, 1.0, 0]], 'pcie', `pcie-${j >> 1}`, j);
    box(xf - 0.15, 8.6, xf + 0.15, 9.4, 0, 0.3, null, true);               // AC-coupling capacitor on every lane
  }
  const fingers = [];
  for (let n = 1; n <= 82; n++) {                                     // gold fingers, presence-detect pins shorter
    const x = pinX(n), short = [17, 31, 48, 81].includes(n);
    const P = [[x - 0.35, short ? 1.4 : 0.6], [x + 0.35, short ? 1.4 : 0.6], [x + 0.35, FT], [x - 0.35, FT]];
    for (let i = 0; i < 4; i++) { const a = P[i], b = P[(i + 1) % 4]; fingers.push(W(a[0]), TY, Zc(a[1]), W(b[0]), TY, Zc(b[1])); }
    if (!lanePins.includes(n) && n > 11) { circleOn(vias, x, 7.2, 0, 0.3, 10); lineOn(copper, x, FT, x, 6.9, 0); }
  }
  mark(TAB[0], 0, TAB[1], BY0, 0);
  const pour = [[45, FT], [55.4, FT], [57, 9.5], [57, 17], [45, 17]];       // +12 V / +3.3 V slot power, pins 1–11
  for (let i = 0; i < pour.length; i++) lineOn(faint, ...pour[i], ...pour[(i + 1) % pour.length], 0);
  mark(44.5, FT, 57.5, 17, 0.2);

  /* power: 22 GPU phases (power stage + choke) in two columns, polymer capacitors outside them,
     7 memory phases along the top edge and at the far end, the 16-pin connector ------------------- */
  const PH = [];
  for (let k = 0; k < 11; k++) {
    const y = 29 + 9.1 * k;
    PH.push({ ds: [51, y], ch: [38.75, y] }, { ds: [161, y], ch: [171.75, y] });
  }
  for (const p of PH) {
    qfn(p.ds[0], p.ds[1], 5, 6, 1.0);
    box(p.ch[0] - 5.75, p.ch[1] - 4.25, p.ch[0] + 5.75, p.ch[1] + 4.25, 0, 7.0, 0.3);
    rectOn(detail, p.ch[0] - 4.6, p.ch[1] - 3.1, p.ch[0] + 4.6, p.ch[1] + 3.1, 7.0);
    lineOn(detail, p.ch[0] - 1.8, p.ch[1], p.ch[0] + 1.8, p.ch[1], 7.0);
  }
  for (let k = 0; k < 13; k++) { cylinder(21, 24 + 8 * k, 3.15, 5.7); cylinder(191, 24 + 8 * k, 3.15, 5.7); }
  const MPH = [[60, 134], [70, 134], [80, 134], [114, 134], [124, 134], [203, 106], [203, 115]];
  MPH.forEach(([x, y], k) => {
    box(x - 3.5, y - 3, x + 3.5, y + 3, 0, 5.0, 0.3);
    rectOn(detail, x - 2.6, y - 2.1, x + 2.6, y + 2.1, 5.0);
    if (k < 5) qfn(x, y - 6.2, 3.5, 3.0, 0.9); else qfn(x - 7, y, 3.0, 3.5, 0.9);
  });
  box(198.7, 128, 220.8, BY1 + 0.5, 0, 12.5, 0.6);                    // 12V-2x6
  for (let r = 0; r < 2; r++) for (let k = 0; k < 6; k++) rectOn(detail, 200.2 + k * 3.0, 129.2 + r * 3.6, 202.4 + k * 3.0, 131.8 + r * 3.6, 12.5);
  for (let k = 0; k < 4; k++) rectOn(detail, 202 + k * 4.4, 137.6, 203.4 + k * 4.4, 138.8, 12.5);
  for (let k = 0; k < 3; k++) { const x = 176 + k * 5; box(x - 1.6, 126, x + 1.6, 132.3, 0, 0.6, 0.4); rectOn(detail, x - 1.6, 126.8, x + 1.6, 131.5, 0.6); }   // current-sense shunts
  box(186.5, 137.5, 190.5, 140, 0, 1.8, 0.3);                          // BIOS switch
  for (const [x, y, w] of [[206, 72, 6], [217, 58, 5], [206, 88, 4], [218, 80, 4], [64, 125, 4]]) qfn(x, y, w, w);
  for (const x of [205, 220]) {                                       // fan headers
    box(x - 5, 16, x + 5, 21.5, 0, 6.0, 0.6);
    for (let k = 0; k < 4; k++) rectOn(detail, x - 3.8 + k * 2.54, 17.8, x - 2.6 + k * 2.54, 19.6, 6.0);
  }
  box(222, 36, 229.5, 41, 0, 6.0, 0.6);                               // RGB header
  // display: three DisplayPorts and an HDMI hang over the board's front edge
  const CONN = [{ y: 87.5, w: 16.5, kind: 'dp' }, { y: 66.9, w: 16.5, kind: 'dp' }, { y: 44.8, w: 16.5, kind: 'dp' }, { y: 23.7, w: 15, kind: 'hdmi' }];
  for (const c of CONN) {
    const y0 = c.y - c.w / 2, y1 = c.y + c.w / 2, hh = c.kind === 'hdmi' ? 6.2 : 7.0;
    box(-4.7, y0, 12.6, y1, 0, hh, 0.8);
    lineOn(detail, -4.2, c.y, 12, c.y, hh);
    for (const f of [0.25, 0.75]) lineOn(detail, -2, y0 + c.w * f, 11, y0 + c.w * f, hh);
    if (c.kind === 'dp') rectOn(detail, 1, c.y - 2.2, 5, c.y + 2.2, hh); else for (let k = 0; k < 3; k++) circleOn(detail, 2 + k * 4, c.y, hh, 0.9, 12);
    for (let k = 0; k < 10; k++) { const y = y0 + 1.5 + k * (c.w - 3) / 9; box(12.6, y - 0.15, 13.7, y + 0.15, 0, 0.15, null); }
  }
  // display lanes: out of the package's lower-left edge, down beside the PCIe lanes, left in a band under the
  // power columns, then up between the capacitors and the chokes into each output (top lane to the top port)
  const ND = 16;
  for (let j = 0; j < ND; j++) {
    const t = (j + 0.5) / ND, xd2 = 96.6 + t * 2.3, xs = 93.8 + t * 4.5;
    const yt = 24.4 - j * 0.18, xv = 30.2 - j * 0.38, c = CONN[Math.floor(j / 4)], yc = c.y + 2.4 - ((j % 4) + 0.5) * 1.2;
    signal([[xd2, DIE.y0, HS], [xs, SUB.y0, HS], [xs, SUB.y0 - 0.8, 0], [xs, yt + 0.7, 0], [xs - 0.7, yt, 0], [xv + 0.7, yt, 0], [xv, yt + 0.7, 0],
      [xv, yc - 0.7, 0], [xv - 0.7, yc, 0], [16.5, yc, 0], [10, yc, 0]], 'disp', `disp-${Math.floor(j / 4)}`, j);
  }

  /* 12 V: down the right capacitor column and along the top to the left one -------------------------- */
  signal([[209, 128, 0], [196.5, 124, 0], [196.5, 22, 0]], 'v12', 'v12a', 0, { hw: 1.4 });
  signal([[198, 126, 0], [150, 126, 0], [140, 124.5, 0], [33, 124.5, 0]], 'v12', 'v12b', 1, { hw: 1.1 });

  /* fill: decoupling capacitors and resistors in rows near the silicon, stitching vias elsewhere ----- */
  const near = (x, y) => {
    let d = 1e9;
    for (const m of MEMS) { const [x0, y0, x1, y1] = memBox(m); d = Math.min(d, Math.hypot(Math.max(x0 - x, 0, x - x1), Math.max(y0 - y, 0, y - y1))); }
    d = Math.min(d, Math.hypot(Math.max(SUB.x0 - x, 0, x - SUB.x1), Math.max(SUB.y0 - y, 0, y - SUB.y1)));
    if ((x > 28 && x < 60) || (x > 152 && x < 200)) d = Math.min(d, 3);
    return d;
  };
  for (let y = BY0 + 2.2; y < BY1 - 2; y += 1.25) {
    for (let x = 2.5; x < BX - 2; x += 1.6) {
      const d = near(x, y);
      const p = d < 4 ? 0.85 : d < 10 ? 0.55 : 0.25;
      if (rand() > p) continue;
      const big = rand() < 0.18, rot = rand() < 0.25;
      const lw = big ? 1.6 : 1.0, ld = big ? 0.8 : 0.5;
      const [w, dd] = rot ? [ld, lw] : [lw, ld];
      if (!free(x - w / 2, y - dd / 2, x + w / 2, y + dd / 2, 0.2)) continue;
      const res = rand() < 0.3, h = res ? 0.35 : (big ? 0.8 : 0.5);
      box(x - w / 2, y - dd / 2, x + w / 2, y + dd / 2, 0, h, 0.15, true);
      if (rot) { lineOn(soft, x - w / 2, y - dd / 2 + 0.22 * lw, x + w / 2, y - dd / 2 + 0.22 * lw, h); lineOn(soft, x - w / 2, y + dd / 2 - 0.22 * lw, x + w / 2, y + dd / 2 - 0.22 * lw, h); }
      else { lineOn(soft, x - w / 2 + 0.22 * lw, y - dd / 2, x - w / 2 + 0.22 * lw, y + dd / 2, h); lineOn(soft, x + w / 2 - 0.22 * lw, y - dd / 2, x + w / 2 - 0.22 * lw, y + dd / 2, h); }
    }
  }
  for (let y = BY0 + 1.6; y < BY1 - 1; y += 1.8) for (let x = 1.8; x < BX - 1; x += 1.8) {
    const edge = x < 3 || x > BX - 3 || y < BY0 + 2.4 || y > BY1 - 2.4;
    if ((edge || rand() < 0.07) && free(x - 0.3, y - 0.3, x + 0.3, y + 0.3, 0.05)) { circleOn(vias, x, y, 0, 0.3, 8); mark(x - 0.4, y - 0.4, x + 0.4, y + 0.4, 0); }
  }

  /* draw ---------------------------------------------------------------------------------------- */
  scene.add(stage.wire(mergeParts(boxes), { crease: 30, silhouette: false }));
  // passives, small capacitors and vias drawn light and thin, so the silicon and the power parts carry the drawing
  const softMat = stage.lineMaterial({ width: 0.7, opacity: 0.3 });
  scene.add(stage.wire(mergeParts(small), { crease: 30, silhouette: false, material: softMat }));
  scene.add(lines(stage, soft, stage.lineMaterial({ width: 0.6, opacity: 0.18 })));
  scene.add(stage.wire(mergeParts(cyls), { crease: 30 }));
  scene.add(lines(stage, detail, stage.mat.dim), lines(stage, faint, stage.mat.faint));
  scene.add(lines(stage, silk, stage.lineMaterial({ width: 0.8, opacity: 0.2 })));
  scene.add(lines(stage, copper, stage.lineMaterial({ width: 0.9, opacity: 0.16 })));   // dim copper: the signals carry the colour
  scene.add(lines(stage, copperIn, stage.lineMaterial({ width: 0.9, opacity: 0.08 })));
  scene.add(lines(stage, fingers, stage.lineMaterial({ width: 1.0, opacity: 0.8 })));
  scene.add(lines(stage, vias, stage.lineMaterial({ width: 0.6, opacity: 0.2 })), lines(stage, holes, stage.mat.dim));

  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
  g.setAttribute('aS', new THREE.Float32BufferAttribute(aS, 1));
  g.setAttribute('aSide', new THREE.Float32BufferAttribute(aSide, 1));
  g.setAttribute('aP1', new THREE.Float32BufferAttribute(aP1, 4));
  g.setAttribute('aP2', new THREE.Float32BufferAttribute(aP2, 4));
  g.setAttribute('aAmp', new THREE.Float32BufferAttribute(aAmp, 3));
  g.setIndex(idx);
  const mesh = new THREE.Mesh(g, sm);
  mesh.renderOrder = 2;
  mesh.frustumCulled = false;
  scene.add(mesh);

  /* light: the die at work, and the GPU's power stages firing in rotation --------------------------- */
  const NA = 160, NPS = PH.length;
  const act = glowPoints(NA + NPS, { core: 0.5 });
  act.renderOrder = 3;
  scene.add(act);
  const ap = act.geometry.attributes.position.array, ac = act.geometry.attributes.color.array;
  const as = act.geometry.attributes.size.array, aa = act.geometry.attributes.alpha.array;
  const A = Array.from({ length: NA }, () => ({ x: DIE.x0 + 1.5 + rand() * (DIE.x1 - DIE.x0 - 3), y: DIE.y0 + 1.5 + rand() * (DIE.y1 - DIE.y0 - 3), ph: rand() * 6.28, w: 0.6 + rand() * 2.2 }));
  A.forEach((q, i) => { ap[i * 3] = W(q.x); ap[i * 3 + 1] = H(DIE.h) + 0.01; ap[i * 3 + 2] = Zc(q.y); });
  // firing order goes round the GPU: up the left column, down the right
  const ring = [...PH.filter((_, k) => k % 2 === 0), ...PH.filter((_, k) => k % 2 === 1).reverse()];
  ring.forEach((p, k) => { const i = NA + k; ap[i * 3] = W(p.ds[0]); ap[i * 3 + 1] = H(1.0) + 0.01; ap[i * 3 + 2] = Zc(p.ds[1]); });
  const col = [0, 0, 0];
  stage.onUpdate((t) => {
    act.material.uniforms.uScale.value = stage.pointScale;
    for (let i = 0; i < NA; i++) {
      const q = A[i], v = 0.5 + 0.5 * Math.sin(t * q.w + q.ph) * Math.sin(t * 0.37 * q.w + q.ph * 2);
      gradientSRGB(0.55 + 0.45 * v, col);
      ac[i * 3] = col[0]; ac[i * 3 + 1] = col[1]; ac[i * 3 + 2] = col[2];
      as[i] = 0.08 + 0.07 * v; aa[i] = 0.12 + 0.5 * v * v;
    }
    const sweep = t * 1.6;
    for (let k = 0; k < NPS; k++) {
      const i = NA + k, f = (((sweep - k / NPS) % 1) + 1) % 1, v = Math.exp(-f * 9);
      gradientSRGB(0.25 + 0.45 * v, col);
      ac[i * 3] = col[0]; ac[i * 3 + 1] = col[1]; ac[i * 3 + 2] = col[2];
      as[i] = 0.12 + 0.12 * v; aa[i] = 0.08 + 0.85 * v;
    }
    for (const k of ['color', 'size', 'alpha']) act.geometry.attributes[k].needsUpdate = true;
  });
  act.geometry.attributes.position.needsUpdate = true;
}
