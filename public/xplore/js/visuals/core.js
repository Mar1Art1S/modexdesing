/*
 * XV core — shared renderer, palette and hidden-line wireframe toolkit.
 *
 * Every visual shares:
 *   - pure black background, black unlit faces (same colour as the background)
 *   - white edge lines (crease edges + per-frame silhouettes => true hidden-line look)
 *   - a single blue -> red gradient reserved for the physics (flow, heat, fields)
 *   - an optional HUD overlay (title, readouts, colour bar, time scale)
 *
 * Usage:
 *   import { mountTurbine } from './visuals/turbine.js';
 *   const stage = mountTurbine(document.querySelector('#hero'), { hud: true });
 *   stage.dispose(); // when unmounting
 */
import * as THREE from 'three';
import { LineSegments2 } from 'three/addons/lines/LineSegments2.js';
import { LineSegmentsGeometry } from 'three/addons/lines/LineSegmentsGeometry.js';
import { LineMaterial } from 'three/addons/lines/LineMaterial.js';
import { mergeGeometries } from 'three/addons/utils/BufferGeometryUtils.js';

export { THREE, LineSegments2, LineSegmentsGeometry, LineMaterial, mergeGeometries };

/* ------------------------------------------------------------------ palette */

// The colour scale every machine's physics uses. A page may set globalThis.XV_PALETTE (2+ hex stops)
// before the visuals load to try another scale; otherwise it is the xplore blue -> violet -> red.
export const STOP_HEX = (Array.isArray(globalThis.XV_PALETTE) && globalThis.XV_PALETTE.length > 1)
  ? globalThis.XV_PALETTE : ['#1a44ff', '#4a3cff', '#8f35e0', '#dc2f78', '#ff3a2c'];
const STOPS = STOP_HEX.map((h) => {
  const n = parseInt(h.slice(1), 16);
  return [((n >> 16) & 255) / 255, ((n >> 8) & 255) / 255, (n & 255) / 255];
});

// How values map onto the scale: clipped to [lo, hi], then curved by gamma (< 1 lifts the cold end,
// > 1 favours the hot end). A page may set globalThis.XV_PALETTE_MAP = { lo, hi, gamma } to try others.
const MAP = { lo: 0, hi: 1, gamma: 1, ...(globalThis.XV_PALETTE_MAP || {}) };
const mapT = (t) => {
  t = (t - MAP.lo) / Math.max(1e-4, MAP.hi - MAP.lo);
  t = t < 0 ? 0 : t > 1 ? 1 : t;
  return MAP.gamma === 1 ? t : Math.pow(t, MAP.gamma);
};

export const CSS_GRADIENT = `linear-gradient(90deg, ${STOP_HEX.join(', ')})`;

/** sRGB gradient sample, t in [0,1] -> writes r,g,b into out[o..o+2] */
export function gradientSRGB(t, out, o = 0) {
  t = mapT(t);
  const f = t * (STOPS.length - 1);
  const i = Math.min(STOPS.length - 2, Math.floor(f));
  const k = f - i;
  const a = STOPS[i], b = STOPS[i + 1];
  out[o] = a[0] + (b[0] - a[0]) * k;
  out[o + 1] = a[1] + (b[1] - a[1]) * k;
  out[o + 2] = a[2] + (b[2] - a[2]) * k;
  return out;
}

const _tmp3 = [0, 0, 0];
/** Linear-space gradient sample (for built-in three.js materials / vertex colours). */
export function gradientLinear(t, out, o = 0, scale = 1) {
  gradientSRGB(t, _tmp3);
  for (let j = 0; j < 3; j++) {
    const c = _tmp3[j];
    out[o + j] = scale * (c <= 0.04045 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4));
  }
  return out;
}

/** Same gradient for custom shaders (returns sRGB), for any number of stops. */
const glslStops = STOPS.map((c, i) => `  vec3 c${i} = vec3(${c.map((v) => v.toFixed(4)).join(',')});`).join('\n');
const glslMix = STOPS.slice(1).map((_, i) => (i < STOPS.length - 2
  ? `  if (f < ${(i + 1).toFixed(1)}) return mix(c${i}, c${i + 1}, f - ${i.toFixed(1)});`
  : `  return mix(c${i}, c${i + 1}, f - ${i.toFixed(1)});`)).join('\n');
export const GLSL_GRADIENT = /* glsl */ `
vec3 xvGradient(float t) {
  t = clamp((t - ${MAP.lo.toFixed(4)}) / ${Math.max(1e-4, MAP.hi - MAP.lo).toFixed(4)}, 0.0, 1.0);
  ${MAP.gamma === 1 ? '' : `t = pow(t, ${MAP.gamma.toFixed(4)});`}
${glslStops}
  float f = t * ${(STOPS.length - 1).toFixed(1)};
${glslMix}
}`;

// Line weight for every drawn edge (glows excepted): width multiplier and ink (1 = as designed;
// below 1 the lines turn grey, above 1 the dim and faint lines get darker). Set by a page via
// globalThis.XV_LINE = { width, ink } before the visuals load.
const LINE = { width: 1, ink: 1, ...(globalThis.XV_LINE || {}) };
// Section hatching on cut-away faces: its own colour, strength and width. Without globalThis.XV_HATCH
// it is drawn exactly like the other secondary lines.
const HATCH = globalThis.XV_HATCH ? { width: 1, opacity: 1, ...globalThis.XV_HATCH } : null;

/** Global intensity of the coloured physics layer (0..1) — used to fade effects during transitions. */
export const FX = { value: 1 };

/* ------------------------------------------------------------------ pencil */

/**
 * Optional hand-drawn look for every edge line. Set before any scene is mounted:
 *   enableSketch({ wobble: 0.8, overshoot: 3 })
 * wobble: px long strokes lean off true; overshoot: px they run past their corners.
 * Everything is keyed to each segment's own shape (its object-space direction and length), never
 * to time or position, so a stroke keeps its look while its part moves and nothing flickers.
 * Short segments (curves, fine detail) are left exactly as drawn.
 */
export const SKETCH = { on: false, wobble: 0.8, overshoot: 3 };
const SK_U = { uSkWobble: { value: 0 }, uSkOver: { value: 0 } };

export function enableSketch(o = {}) {
  Object.assign(SKETCH, o, { on: true });
  SK_U.uSkWobble.value = SKETCH.wobble;
  SK_U.uSkOver.value = SKETCH.overshoot;
}

const GLSL_SK_VERT = /* glsl */ `
uniform float uSkWobble; uniform float uSkOver;
varying float vSk;
float skH(vec3 p) { p = fract(p * 0.3183099 + 0.1); p *= 17.0; return fract(p.x * p.y * p.z * (p.x + p.y + p.z)); }
float skN(vec3 x) {
  vec3 i = floor(x), f = fract(x); f = f * f * (3.0 - 2.0 * f);
  return mix(mix(mix(skH(i), skH(i + vec3(1, 0, 0)), f.x), mix(skH(i + vec3(0, 1, 0)), skH(i + vec3(1, 1, 0)), f.x), f.y),
             mix(mix(skH(i + vec3(0, 0, 1)), skH(i + vec3(1, 0, 1)), f.x), mix(skH(i + vec3(0, 1, 1)), skH(i + vec3(1, 1, 1)), f.x), f.y), f.z) * 2.0 - 1.0;
}`;

const GLSL_SK_APPLY = /* glsl */ `
      {
        // pencil: smooth noise of the segment's own vector, so moving parts don't re-roll it every frame
        vec3 key = (instanceEnd - instanceStart) * 3.7;
        float n1 = skN(key), n2 = skN(key + 11.3), n3 = skN(key + 23.9), n4 = skN(key + 37.1);
        float k = 2.0 / (projectionMatrix[1][1] * resolution.y);        // view units per px at depth 1
        float ks = k * abs(start.z), ke = k * abs(end.z);
        vec3 d = end.xyz - start.xyz; float len = length(d);
        float lenPx = len / max(0.5 * (ks + ke), 1e-6);
        float longStroke = smoothstep(10.0, 40.0, lenPx);
        if (len > 1e-6 && longStroke > 0.0) {
          vec3 dir = d / len;
          vec2 nrm = normalize(vec2(-dir.y, dir.x) + 1e-6);
          start.xy += nrm * n1 * uSkWobble * ks * longStroke;
          end.xy += nrm * n2 * uSkWobble * ke * longStroke;
          float o = uSkOver * (0.6 + 0.4 * n3) * longStroke;
          start.xyz -= dir * o * ks; end.xyz += dir * o * ke;
        }
        vSk = 0.9 + 0.1 * n4;                                             // stroke pressure
      }`;

/** onBeforeCompile patch for LineMaterial shaders (also applied on top of the morph material). */
export function sketchLines(sh) {
  Object.assign(sh.uniforms, SK_U);
  sh.vertexShader = sh.vertexShader
    .replace('void main() {', `${GLSL_SK_VERT}\nvoid main() {`)
    .replace(/(vec4 end = modelViewMatrix \* vec4\( \w+, 1\.0 \);)/, `$1${GLSL_SK_APPLY}`);
  sh.fragmentShader = sh.fragmentShader
    .replace('void main() {', 'varying float vSk;\nvoid main() {')
    .replace('float alpha = opacity;', 'float alpha = opacity * vSk;');
}

/* ------------------------------------------------------------------ helpers */

export const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);
export const lerp = (a, b, t) => a + (b - a) * t;
export const smoothstep = (a, b, x) => {
  const t = clamp((x - a) / (b - a), 0, 1);
  return t * t * (3 - 2 * t);
};

/** Deterministic PRNG so every page load draws the same machine. */
export function rng(seed = 1) {
  let s = seed >>> 0;
  return () => {
    s = (s + 0x6d2b79f5) >>> 0;
    let t = s;
    t = Math.imul(t ^ (t >>> 15), t | 1);
    t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
    return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
  };
}

/** Circle polyline as line-segment pairs, in the plane spanned by u,v around c. */
export function circleSegments(out, c, u, v, r, n = 48) {
  for (let i = 0; i < n; i++) {
    const a0 = (i / n) * Math.PI * 2, a1 = ((i + 1) / n) * Math.PI * 2;
    const c0 = Math.cos(a0) * r, s0 = Math.sin(a0) * r, c1 = Math.cos(a1) * r, s1 = Math.sin(a1) * r;
    out.push(
      c.x + u.x * c0 + v.x * s0, c.y + u.y * c0 + v.y * s0, c.z + u.z * c0 + v.z * s0,
      c.x + u.x * c1 + v.x * s1, c.y + u.y * c1 + v.y * s1, c.z + u.z * c1 + v.z * s1,
    );
  }
  return out;
}

/** Polyline (array of Vector3) -> segment pairs */
export function polylineSegments(out, pts, closed = false) {
  const n = pts.length;
  for (let i = 0; i < n - (closed ? 0 : 1); i++) {
    const a = pts[i], b = pts[(i + 1) % n];
    out.push(a.x, a.y, a.z, b.x, b.y, b.z);
  }
  return out;
}

/** Strip everything but positions and de-index, so heterogeneous parts can be merged. */
export function positionsOnly(g) {
  const ng = g.index ? g.toNonIndexed() : g.clone();
  for (const k of Object.keys(ng.attributes)) if (k !== 'position') ng.deleteAttribute(k);
  return ng;
}

export function mergeParts(parts) {
  return mergeGeometries(parts.map(positionsOnly), false);
}

/* --------------------------------------------------------- edge extraction */

/**
 * Welds vertices, builds the edge/face adjacency and classifies edges:
 *  - crease edges (dihedral > creaseDeg, or boundary) -> static lines
 *  - smooth edges -> silhouette candidates, resolved per frame from the camera
 */
export function buildEdgeData(geometry, creaseDeg = 30) {
  const pos = geometry.getAttribute('position');
  const idx = geometry.index ? geometry.index.array : null;
  const nIdx = idx ? idx.length : pos.count;

  const weld = new Map();
  const verts = [];
  const remap = new Uint32Array(pos.count);
  const q = 2e4;
  for (let i = 0; i < pos.count; i++) {
    const x = pos.getX(i), y = pos.getY(i), z = pos.getZ(i);
    const key = `${Math.round(x * q)},${Math.round(y * q)},${Math.round(z * q)}`;
    let id = weld.get(key);
    if (id === undefined) {
      id = verts.length / 3;
      verts.push(x, y, z);
      weld.set(key, id);
    }
    remap[i] = id;
  }

  const faceN = [];
  const edges = new Map();
  const BIG = 2097152; // 2^21
  const addEdge = (a, b, f) => {
    const lo = a < b ? a : b, hi = a < b ? b : a;
    const key = lo * BIG + hi;
    const e = edges.get(key);
    if (!e) edges.set(key, [lo, hi, f, -1, 0]);
    else if (e[3] === -1) e[3] = f;
    else e[4] = 1; // non-manifold
  };

  for (let t = 0; t < nIdx; t += 3) {
    const a = remap[idx ? idx[t] : t], b = remap[idx ? idx[t + 1] : t + 1], c = remap[idx ? idx[t + 2] : t + 2];
    if (a === b || b === c || a === c) continue;
    const ax = verts[a * 3], ay = verts[a * 3 + 1], az = verts[a * 3 + 2];
    const ux = verts[b * 3] - ax, uy = verts[b * 3 + 1] - ay, uz = verts[b * 3 + 2] - az;
    const vx = verts[c * 3] - ax, vy = verts[c * 3 + 1] - ay, vz = verts[c * 3 + 2] - az;
    let nx = uy * vz - uz * vy, ny = uz * vx - ux * vz, nz = ux * vy - uy * vx;
    const len = Math.hypot(nx, ny, nz);
    if (len < 1e-12) continue;
    nx /= len; ny /= len; nz /= len;
    const f = faceN.length / 4;
    faceN.push(nx, ny, nz, nx * ax + ny * ay + nz * az);
    addEdge(a, b, f); addEdge(b, c, f); addEdge(c, a, f);
  }

  const cosT = Math.cos((creaseDeg * Math.PI) / 180);
  const crease = [];
  const cand = [];
  for (const e of edges.values()) {
    const [a, b, f1, f2, nm] = e;
    let isCrease = f2 === -1 || nm === 1;
    let dot = 1;
    if (!isCrease) {
      dot = faceN[f1 * 4] * faceN[f2 * 4] + faceN[f1 * 4 + 1] * faceN[f2 * 4 + 1] + faceN[f1 * 4 + 2] * faceN[f2 * 4 + 2];
      isCrease = dot < cosT;
    }
    if (isCrease) {
      crease.push(verts[a * 3], verts[a * 3 + 1], verts[a * 3 + 2], verts[b * 3], verts[b * 3 + 1], verts[b * 3 + 2]);
    } else if (dot < 0.999999) {
      cand.push(a, b, f1, f2);
    }
  }
  return {
    verts: new Float32Array(verts),
    faceN: new Float32Array(faceN),
    crease: new Float32Array(crease),
    cand: new Int32Array(cand),
  };
}

/* ------------------------------------------------------------------- Wire */

const _v = new THREE.Vector3();

/**
 * Hidden-line object: black unlit faces + white crease lines + live silhouettes.
 */
export class Wire extends THREE.Group {
  constructor(stage, geometry, { crease = 30, silhouette = true, faces = true, material = null } = {}) {
    super();
    this.stage = stage;
    const mat = material || stage.mat.line;
    const data = buildEdgeData(geometry, crease);
    this.data = data;

    if (faces) {
      this.mesh = new THREE.Mesh(geometry, stage.mat.face);
      this.add(this.mesh);
    }
    if (data.crease.length) {
      const g = new LineSegmentsGeometry().setPositions(data.crease);
      this.creaseLines = new LineSegments2(g, mat);
      this.add(this.creaseLines);
    }
    if (silhouette && data.cand.length) {
      const max = data.cand.length / 4;
      const g = new LineSegmentsGeometry().setPositions(new Float32Array(max * 6));
      g.attributes.instanceStart.data.setUsage(THREE.DynamicDrawUsage);
      g.instanceCount = 0;
      this.silLines = new LineSegments2(g, mat);
      this.silLines.frustumCulled = false;
      this.add(this.silLines);
      this._lastCam = new THREE.Vector3(1e9, 1e9, 1e9);
    }
    stage.wires.push(this);
  }

  updateSilhouette(camera, force = false) {
    if (!this.silLines) return;
    for (let o = this; o; o = o.parent) if (!o.visible) return;
    if (force) this._lastCam.set(1e9, 1e9, 1e9);
    _v.copy(camera.position);
    this.worldToLocal(_v);
    if (_v.distanceToSquared(this._lastCam) < 1e-12) return;
    this._lastCam.copy(_v);
    const { cand, faceN, verts } = this.data;
    const g = this.silLines.geometry;
    const buf = g.attributes.instanceStart.data;
    const arr = buf.array;
    const cx = _v.x, cy = _v.y, cz = _v.z;
    let n = 0;
    for (let i = 0; i < cand.length; i += 4) {
      const f1 = cand[i + 2] * 4, f2 = cand[i + 3] * 4;
      const s1 = faceN[f1] * cx + faceN[f1 + 1] * cy + faceN[f1 + 2] * cz - faceN[f1 + 3];
      const s2 = faceN[f2] * cx + faceN[f2 + 1] * cy + faceN[f2 + 2] * cz - faceN[f2 + 3];
      if ((s1 > 0) !== (s2 > 0)) {
        const a = cand[i] * 3, b = cand[i + 1] * 3, o = n * 6;
        arr[o] = verts[a]; arr[o + 1] = verts[a + 1]; arr[o + 2] = verts[a + 2];
        arr[o + 3] = verts[b]; arr[o + 4] = verts[b + 1]; arr[o + 5] = verts[b + 2];
        n++;
      }
    }
    buf.clearUpdateRanges();
    buf.addUpdateRange(0, Math.max(6, n * 6));
    buf.needsUpdate = true;
    g.instanceCount = n;
  }
}

/** Static line set (segment pairs) with a stage-managed material. */
export function lines(stage, segs, material) {
  const g = new LineSegmentsGeometry().setPositions(segs instanceof Float32Array ? segs : new Float32Array(segs));
  const l = new LineSegments2(g, material || stage.mat.line);
  return l;
}

/** Engineering centreline (long dash, gap, short dash, gap) from a to b. */
export function centerline(out, a, b, long = 0.32, short = 0.06, gap = 0.07) {
  const d = new THREE.Vector3().subVectors(b, a);
  const L = d.length();
  d.normalize();
  let s = 0, k = 0;
  while (s < L) {
    const len = k % 2 === 0 ? long : short;
    const e = Math.min(L, s + len);
    out.push(a.x + d.x * s, a.y + d.y * s, a.z + d.z * s, a.x + d.x * e, a.y + d.y * e, a.z + d.z * e);
    s = e + gap;
    k++;
  }
  return out;
}

/**
 * 2D section hatching: 45° lines clipped to a closed polygon [[x,y],...].
 * Returns [[x0,y0,x1,y1], ...].
 */
/**
 * A paint for solid faces in place of the black occluding fill: 'full' in colour, 'light' mixed into the
 * page (strength 0..1, still opaque so hidden lines stay hidden), or 'hatch', diagonal lines of the colour
 * in screen space, `period` px apart. The reel fades it with the other faces (userData.face).
 */
export function paintMaterial(stage, { mode = 'light', color = STOP_HEX[STOP_HEX.length - 1], strength = 0.35, period = 6, width = 1.3 } = {}) {
  const c = new THREE.Color(color);
  if (mode === 'light') c.multiplyScalar(strength);                // the face is drawn on black, which the page shows as paper
  const m = new THREE.MeshBasicMaterial({
    color: c, side: THREE.DoubleSide, polygonOffset: true, polygonOffsetFactor: 1, polygonOffsetUnits: 1,
  });
  m.userData.face = true;
  if (mode === 'hatch') {
    const pr = stage.renderer.getPixelRatio();
    m.onBeforeCompile = (sh) => {
      sh.fragmentShader = sh.fragmentShader.replace('#include <color_fragment>', `#include <color_fragment>
        diffuseColor.rgb *= step(mod(gl_FragCoord.x + gl_FragCoord.y, ${(period * pr).toFixed(2)}), ${(width * pr).toFixed(2)});`);
    };
    m.customProgramCacheKey = () => `paint-hatch-${period}-${width}-${pr}`;
  }
  return m;
}

export function hatchPolygon(poly, spacing = 0.05, angle = Math.PI / 4) {
  const ca = Math.cos(-angle), sa = Math.sin(-angle);
  const P = poly.map(([x, y]) => [x * ca - y * sa, x * sa + y * ca]);
  let ymin = Infinity, ymax = -Infinity;
  for (const p of P) { ymin = Math.min(ymin, p[1]); ymax = Math.max(ymax, p[1]); }
  const out = [];
  const cb = Math.cos(angle), sb = Math.sin(angle);
  for (let y = Math.ceil(ymin / spacing) * spacing; y < ymax; y += spacing) {
    const xs = [];
    for (let i = 0; i < P.length; i++) {
      const a = P[i], b = P[(i + 1) % P.length];
      if ((a[1] <= y && b[1] > y) || (b[1] <= y && a[1] > y)) {
        xs.push(a[0] + ((y - a[1]) / (b[1] - a[1])) * (b[0] - a[0]));
      }
    }
    xs.sort((m, n) => m - n);
    for (let i = 0; i + 1 < xs.length; i += 2) {
      const x0 = xs[i], x1 = xs[i + 1];
      out.push([x0 * cb - y * sb, x0 * sb + y * cb, x1 * cb - y * sb, x1 * sb + y * cb]);
    }
  }
  return out;
}

/* ------------------------------------------------------------------- HUD */

let hudStyleInjected = false;
function injectHudStyle() {
  if (hudStyleInjected) return;
  hudStyleInjected = true;
  const s = document.createElement('style');
  s.textContent = `
  .xv-hud{position:absolute;inset:0;pointer-events:none;color:#fff;
    font-family:var(--xv-mono,'At Hauss Mono',ui-monospace,SFMono-Regular,Menlo,monospace);
    font-size:10.5px;letter-spacing:.14em;text-transform:uppercase;font-weight:400;
    -webkit-font-smoothing:antialiased}
  .xv-hud .xv-c{position:absolute;width:14px;height:14px;border:0 solid rgba(255,255,255,.55)}
  .xv-hud .xv-c.tl{left:16px;top:16px;border-left-width:1px;border-top-width:1px}
  .xv-hud .xv-c.tr{right:16px;top:16px;border-right-width:1px;border-top-width:1px}
  .xv-hud .xv-c.bl{left:16px;bottom:16px;border-left-width:1px;border-bottom-width:1px}
  .xv-hud .xv-c.br{right:16px;bottom:16px;border-right-width:1px;border-bottom-width:1px}
  .xv-hud .xv-tl{position:absolute;left:40px;top:34px;line-height:1.7}
  .xv-hud .xv-id{opacity:.5}
  .xv-hud .xv-tr{position:absolute;right:40px;top:34px;text-align:right;line-height:1.85}
  .xv-hud .xv-row .k{opacity:.45;margin-right:14px}
  .xv-hud .xv-row .v{font-variant-numeric:tabular-nums}
  .xv-hud .xv-bl{position:absolute;left:40px;bottom:34px;width:196px}
  .xv-hud .xv-cb-label{opacity:.6;margin-bottom:8px}
  .xv-hud .xv-cb{height:2px;width:100%}
  .xv-hud .xv-cb-ticks{display:flex;justify-content:space-between;margin-top:7px;opacity:.45;font-variant-numeric:tabular-nums}
  .xv-hud .xv-br{position:absolute;right:40px;bottom:34px;text-align:right;line-height:1.7}
  .xv-hud .xv-br .k{opacity:.45}
  .xv-hud .xv-hi{color:#ff3a2c}
  @media (max-width:640px){
    .xv-hud{font-size:9px;letter-spacing:.1em}
    .xv-hud .xv-tr,.xv-hud .xv-br .k{display:none}
    .xv-hud .xv-tl{left:28px;top:26px}.xv-hud .xv-bl{left:28px;bottom:26px;width:150px}
    .xv-hud .xv-br{right:28px;bottom:26px}
    .xv-hud .xv-c.tl,.xv-hud .xv-c.bl{left:10px}.xv-hud .xv-c.tr,.xv-hud .xv-c.br{right:10px}
    .xv-hud .xv-c.tl,.xv-hud .xv-c.tr{top:10px}.xv-hud .xv-c.bl,.xv-hud .xv-c.br{bottom:10px}
  }`;
  document.head.appendChild(s);
}

export class Hud {
  constructor(el, { id = '', title = '', rows = [], colorbar = null, time = '' }) {
    injectHudStyle();
    const d = document.createElement('div');
    d.className = 'xv-hud';
    d.innerHTML = `
      <div class="xv-c tl"></div><div class="xv-c tr"></div><div class="xv-c bl"></div><div class="xv-c br"></div>
      <div class="xv-tl"><div class="xv-id">${id}</div><div>${title}</div></div>
      <div class="xv-tr">${rows.map(([k, key]) => `<div class="xv-row"><span class="k">${k}</span><span class="v" data-k="${key}">—</span></div>`).join('')}</div>
      ${colorbar ? `<div class="xv-bl"><div class="xv-cb-label">${colorbar.label}</div><div class="xv-cb" style="background:${CSS_GRADIENT}"></div>
        <div class="xv-cb-ticks">${colorbar.ticks.map((t) => `<span>${t}</span>`).join('')}</div></div>` : ''}
      <div class="xv-br"><div class="k">TIME SCALE</div><div data-k="__time">${time}</div></div>`;
    el.appendChild(d);
    this.el = d;
    this.fields = {};
    d.querySelectorAll('[data-k]').forEach((n) => (this.fields[n.dataset.k] = n));
    this._cache = {};
  }
  set(key, html) {
    if (this._cache[key] === html) return;
    this._cache[key] = html;
    const f = this.fields[key];
    if (f) f.innerHTML = html;
  }
}

/* ------------------------------------------------------------------ Stage */

export class Stage {
  /**
   * @param {HTMLElement} el container (gets a canvas + optional HUD)
   * @param {object} o
   *   camera: { fov, position:[x,y,z], target:[x,y,z] }
   *   refAspect: aspect ratio the framing was designed for (narrower => camera backs off)
   *   fitFov: 0..1, how much of that fit widens the lens instead (1 = the camera never moves)
   *   drift: (t) => ({ yaw, pitch }) idle camera motion
   *   hud: false | Hud options
   *   lineWidth: CSS px
   */
  constructor(el, o = {}) {
    this.el = el;
    if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
    el.style.background = el.style.background || '#000';

    const renderer = new THREE.WebGLRenderer({ antialias: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.setClearColor(0x000000, 1);
    renderer.domElement.style.cssText = 'display:block;width:100%;height:100%;';
    if (o.edgeFade !== false) {
      // feather the frame so geometry leaving the canvas dissolves instead of being cut
      const f = typeof o.edgeFade === 'number' ? o.edgeFade : 9;
      const m = `linear-gradient(to bottom, transparent 0, #000 ${f}%, #000 ${100 - f}%, transparent 100%),` +
        `linear-gradient(to right, transparent 0, #000 ${f * 0.6}%, #000 ${100 - f * 0.6}%, transparent 100%)`;
      const cs = renderer.domElement.style;
      cs.webkitMaskImage = m; cs.maskImage = m;
      cs.webkitMaskComposite = 'source-in'; cs.maskComposite = 'intersect';
    }
    el.appendChild(renderer.domElement);
    this.renderer = renderer;

    this.scene = new THREE.Scene();
    const c = o.camera || {};
    this.camera = new THREE.PerspectiveCamera(c.fov || 30, 1, 0.05, 200);
    this.fov = c.fov || 30;                // design field of view; the camera's own widens with fitFov
    this.fitFov = o.fitFov || 0;
    this.basePos = new THREE.Vector3(...(c.position || [0, 0, 10]));
    this.target = new THREE.Vector3(...(c.target || [0, 0, 0]));
    this.refAspect = o.refAspect || 1.8;
    this.drift = o.drift || (() => ({ yaw: 0, pitch: 0 }));
    this.parallax = o.parallax ?? 1;

    this.lineMaterials = [];
    const lw = o.lineWidth || 1.15;
    this.mat = {
      face: new THREE.MeshBasicMaterial({
        color: 0x000000, side: THREE.DoubleSide,
        polygonOffset: true, polygonOffsetFactor: 1, polygonOffsetUnits: 1,
      }),
      line: this.lineMaterial({ width: lw }),
      dim: this.lineMaterial({ width: lw * 0.9, opacity: 0.32 }),
      faint: this.lineMaterial({ width: lw * 0.85, opacity: 0.16 }),
      hatch: HATCH
        ? this.lineMaterial({ width: lw * 0.9 * HATCH.width, opacity: HATCH.opacity, color: new THREE.Color(HATCH.color), inked: false })
        : this.lineMaterial({ width: lw * 0.9, opacity: 0.32 }),
    };
    this.wires = [];
    this.updaters = [];

    this.hud = o.hud ? new Hud(el, o.hud) : null;

    // time
    this.clock = new THREE.Clock();
    this.time = 0;
    this.speed = o.speed ?? 1;
    this.reduced = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
    if (this.reduced) this.speed *= 0.25;

    // pointer parallax
    this.ptr = { x: 0, y: 0, sx: 0, sy: 0 };
    this._onPtr = (e) => {
      const r = el.getBoundingClientRect();
      this.ptr.x = clamp(((e.clientX - r.left) / r.width) * 2 - 1, -1.5, 1.5);
      this.ptr.y = clamp(((e.clientY - r.top) / r.height) * 2 - 1, -1.5, 1.5);
    };
    if (this.parallax) window.addEventListener('pointermove', this._onPtr, { passive: true });

    // visibility
    this.visible = true;
    this._io = new IntersectionObserver((ents) => {
      for (const e of ents) this.visible = e.isIntersecting;
    }, { rootMargin: '100px' });
    this._io.observe(el);

    this._ro = new ResizeObserver(() => this.resize());
    this._ro.observe(el);
    this.resize();

    this._loop = this._loop.bind(this);
    this._raf = requestAnimationFrame(this._loop);
  }

  lineMaterial({ color = 0xffffff, width = 1.15, opacity = 1, additive = false, vertexColors = false, depthTest = true, inked = true } = {}) {
    if (!additive && !inked) width *= LINE.width;
    else if (!additive) {
      width *= LINE.width;
      if (LINE.ink < 1) color = new THREE.Color(color).multiplyScalar(LINE.ink);
      else opacity = Math.min(1, opacity * LINE.ink);
    }
    const m = new LineMaterial({
      color, linewidth: width, vertexColors, worldUnits: false,
      transparent: opacity < 1 || additive, opacity, depthTest,
      depthWrite: !(opacity < 1 || additive) && depthTest,
    });
    if (additive) m.blending = THREE.AdditiveBlending;
    if (SKETCH.on) { m.onBeforeCompile = sketchLines; m.customProgramCacheKey = () => 'xv-sketch'; }
    if (this.w) m.resolution.set(this.w, this.h);
    this.lineMaterials.push(m);
    return m;
  }

  wire(geometry, opts) {
    return new Wire(this, geometry, opts);
  }

  onUpdate(fn) {
    this.updaters.push(fn);
  }

  resize() {
    const w = Math.max(1, this.el.clientWidth), h = Math.max(1, this.el.clientHeight);
    if (w === this.w && h === this.h) return;
    this.w = w; this.h = h;
    this.renderer.setSize(w, h, false);
    this.camera.aspect = w / h;
    this.camera.updateProjectionMatrix();
    for (const m of this.lineMaterials) m.resolution.set(w, h);
    this.aspect = w / h;
    // pixels per world unit at distance 1 (for size-attenuated point sprites)
    this.pointScale = (h * this.renderer.getPixelRatio()) / (2 * Math.tan((this.camera.fov * Math.PI) / 360));
  }

  _placeCamera() {
    const p = this.ptr;
    p.sx += (p.x - p.sx) * 0.035;
    p.sy += (p.y - p.sy) * 0.035;
    this.fitScale = Math.min(2.6, Math.pow(Math.max(1, this.refAspect / this.aspect), 0.92));
    const d = this.drift(this.time);
    const yaw = d.yaw + p.sx * 0.09 * this.parallax;
    const pitch = d.pitch - p.sy * 0.05 * this.parallax;
    const fs = this.fitScale || 1, ff = this.fitFov || 0;
    const fov = (360 / Math.PI) * Math.atan(Math.tan((this.fov * Math.PI) / 360) * Math.pow(fs, ff));
    if (Math.abs(fov - this.camera.fov) > 1e-4) {
      this.camera.fov = fov;
      this.camera.updateProjectionMatrix();
      this.pointScale = (this.h * this.renderer.getPixelRatio()) / (2 * Math.tan((fov * Math.PI) / 360));
    }
    const off = _v.copy(this.basePos).sub(this.target).multiplyScalar(Math.pow(fs, 1 - ff));
    off.applyAxisAngle(THREE.Object3D.DEFAULT_UP, yaw);
    const right = new THREE.Vector3().crossVectors(THREE.Object3D.DEFAULT_UP, off).normalize();
    off.applyAxisAngle(right, pitch);
    this.camera.position.copy(this.target).add(off);
    this.camera.lookAt(this.target);
  }

  _loop() {
    this._raf = requestAnimationFrame(this._loop);
    const dt = Math.min(this.clock.getDelta(), 1 / 20);
    if (!this.visible) return;
    this.step(dt);
  }

  /** Advance the simulation by dt (seconds, before speed scaling) and render one frame. */
  step(dt) {
    const sdt = dt * this.speed;
    this.time += sdt;
    for (const fn of this.updaters) fn(this.time, sdt);
    this._placeCamera();
    this.scene.updateMatrixWorld();
    for (const w of this.wires) w.updateSilhouette(this.camera);
    this.renderer.render(this.scene, this.camera);
  }

  dispose() {
    cancelAnimationFrame(this._raf);
    window.removeEventListener('pointermove', this._onPtr);
    this._io.disconnect();
    this._ro.disconnect();
    this.renderer.dispose();
    this.renderer.domElement.remove();
    this.hud?.el.remove();
  }
}

/* --------------------------------------------------------- glow sprites */

/**
 * Soft additive point sprites. Attributes: position, color (sRGB), size (world units), alpha.
 */
export function glowPoints(count, { sizeAttenuation = true, core = 0.35 } = {}) {
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.BufferAttribute(new Float32Array(count * 3), 3).setUsage(THREE.DynamicDrawUsage));
  g.setAttribute('color', new THREE.BufferAttribute(new Float32Array(count * 3), 3).setUsage(THREE.DynamicDrawUsage));
  g.setAttribute('size', new THREE.BufferAttribute(new Float32Array(count), 1).setUsage(THREE.DynamicDrawUsage));
  g.setAttribute('alpha', new THREE.BufferAttribute(new Float32Array(count), 1).setUsage(THREE.DynamicDrawUsage));
  const m = new THREE.ShaderMaterial({
    uniforms: { uScale: { value: 400 }, uCore: { value: core }, uFx: FX },
    vertexShader: /* glsl */ `
      attribute float size; attribute float alpha; attribute vec3 color;
      varying vec3 vC; varying float vA;
      uniform float uScale;
      void main(){
        vC = color; vA = alpha;
        vec4 mv = modelViewMatrix * vec4(position,1.0);
        gl_Position = projectionMatrix * mv;
        gl_PointSize = ${sizeAttenuation ? 'size * uScale / -mv.z' : 'size'};
        if (alpha <= 0.001) gl_PointSize = 0.0;
      }`,
    fragmentShader: /* glsl */ `
      varying vec3 vC; varying float vA; uniform float uCore; uniform float uFx;
      void main(){
        vec2 p = gl_PointCoord*2.0-1.0; float r2 = dot(p,p);
        if (r2>1.0) discard;
        float a = exp(-r2*4.0) + uCore*exp(-r2*40.0);
        gl_FragColor = vec4(vC*a*vA*uFx, 1.0);
      }`,
    transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
  });
  const p = new THREE.Points(g, m);
  p.frustumCulled = false;
  return p;
}

/* --------------------------------------------------------- trail ribbons */

/**
 * Continuous, tapered, screen-space ribbons for N trails of K samples.
 * CPU writes trail points into `data` (Float32Array N*K*4: x, y, z, w) each frame,
 * where w = floor(alpha*100) + q*0.999  (q = gradient coordinate, alpha = 0..1 visibility).
 * Sample k = 0 is the head.
 */
export function trailRibbons(stage, N, K, { width = 1.6, intensity = 1, ghost = 0 } = {}) {
  const data = new Float32Array(N * K * 4);
  const tex = new THREE.DataTexture(data, K, N, THREE.RGBAFormat, THREE.FloatType);
  tex.minFilter = tex.magFilter = THREE.NearestFilter;
  tex.needsUpdate = true;

  const ref = new Float32Array(N * K * 2 * 3);
  const index = [];
  let o = 0;
  for (let i = 0; i < N; i++) {
    for (let k = 0; k < K; k++) {
      ref[o++] = k; ref[o++] = i; ref[o++] = -1;
      ref[o++] = k; ref[o++] = i; ref[o++] = 1;
      if (k < K - 1) {
        const b = (i * K + k) * 2;
        index.push(b, b + 1, b + 2, b + 1, b + 3, b + 2);
      }
    }
  }
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.BufferAttribute(ref, 3)); // (k, i, side) — real positions come from the texture
  g.setIndex(N * K * 2 > 65535 ? new THREE.Uint32BufferAttribute(index, 1) : new THREE.Uint16BufferAttribute(index, 1));

  const m = new THREE.ShaderMaterial({
    uniforms: {
      uData: { value: tex }, uRes: { value: new THREE.Vector2(1, 1) },
      uWidth: { value: width }, uK: { value: K }, uIntensity: { value: intensity }, uFx: FX,
    },
    vertexShader: /* glsl */ `
      uniform sampler2D uData; uniform vec2 uRes; uniform float uWidth; uniform int uK;
      varying float vQ; varying float vA; varying float vSide;
      vec4 fetchP(int k, int i) { return texelFetch(uData, ivec2(k, i), 0); }
      void main() {
        int k = int(position.x + 0.5); int i = int(position.y + 0.5);
        vec4 c = fetchP(k, i);
        vec4 p = fetchP(max(k - 1, 0), i);
        vec4 n = fetchP(min(k + 1, uK - 1), i);
        mat4 pmv = projectionMatrix * modelViewMatrix;
        vec4 cc = pmv * vec4(c.xyz, 1.0);
        vec4 cp = pmv * vec4(p.xyz, 1.0);
        vec4 cn = pmv * vec4(n.xyz, 1.0);
        vec2 d = (cn.xy / cn.w - cp.xy / cp.w) * uRes;
        float len = length(d);
        float taper = clamp(1.0 - float(k) / float(uK - 1), 0.0, 1.0); // GPU division may overshoot 1
        float w = uWidth * (0.3 + 0.7 * taper);
        if (len < 1e-4) { d = vec2(1.0, 0.0); w = 0.0; } else d /= len;
        vec2 nrm = vec2(-d.y, d.x);
        cc.xy += nrm * position.z * w / uRes * cc.w;
        gl_Position = cc;
        float a = floor(c.w) / 100.0;
        vQ = fract(c.w);
        // fade foreshortened samples: many overlapping additive quads would saturate to white
        // (pow(0, y) is unreliable on some GPUs — avoid it at the tail sample)
        vA = a * taper * sqrt(sqrt(taper)) * smoothstep(0.6, 3.0, len * 0.5);
        vSide = position.z;
      }`,
    fragmentShader: /* glsl */ `
      ${GLSL_GRADIENT}
      uniform float uIntensity; uniform float uFx;
      varying float vQ; varying float vA; varying float vSide;
      void main() {
        float edge = 1.0 - smoothstep(0.35, 1.0, abs(vSide));
        gl_FragColor = vec4(xvGradient(vQ) * vA * edge * uIntensity * uFx, 1.0);
      }`,
    transparent: true, depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
  });
  const mesh = new THREE.Mesh(g, m);
  mesh.frustumCulled = false;
  mesh.renderOrder = 2;
  if (ghost > 0) {
    // faint x-ray pass so the flow still reads where it runs behind solid parts
    const gm = m.clone();
    gm.uniforms = { ...m.uniforms, uIntensity: { value: ghost * intensity } };
    gm.depthTest = false;
    const gmesh = new THREE.Mesh(g, gm);
    gmesh.frustumCulled = false;
    gmesh.renderOrder = 1;
    mesh.add(gmesh);
  }
  stage.onUpdate(() => {
    m.uniforms.uRes.value.set(stage.w, stage.h);
  });
  return {
    mesh, data,
    commit() { tex.needsUpdate = true; },
  };
}

/* --------------------------------------------------------- geometry helpers */

/** Lathe around world +X. Profile [[x, r], ...]; θ measured with y = r cosθ, z = r sinθ. */
export function latheX(profile, segments, th0 = 0, th1 = Math.PI * 2) {
  const pts = profile.map(([x, r]) => new THREE.Vector2(Math.max(r, 0), x));
  const g = new THREE.LatheGeometry(pts, segments, th0 - Math.PI / 2, th1 - th0);
  g.rotateZ(-Math.PI / 2);
  return g;
}

/** Flat cap of a lathe cross-section [[x, r], ...] placed in the half-plane at angle θ. */
export function capAt(poly, th) {
  const g = new THREE.ShapeGeometry(new THREE.Shape(poly.map(([x, r]) => new THREE.Vector2(x, r))));
  const p = g.attributes.position;
  const c = Math.cos(th), s = Math.sin(th);
  for (let i = 0; i < p.count; i++) {
    const x = p.getX(i), r = p.getY(i);
    p.setXYZ(i, x, r * c, r * s);
  }
  return g;
}

/** Hatching lines for the two cut faces of a lathe section. */
export function sectionHatch(poly, th0, th1, spacing = 0.042) {
  const out = [];
  for (const th of [th0, th1]) {
    const c = Math.cos(th), s = Math.sin(th);
    for (const [x0, r0, x1, r1] of hatchPolygon(poly, spacing)) out.push(x0, r0 * c, r0 * s, x1, r1 * c, r1 * s);
  }
  return out;
}

/** Extrude a 2D shape (x, y) along world X, centred on x = 0. */
export function extrudeAlongX(shape, depth, { bevel = 0, curveSegments = 24, steps = 1 } = {}) {
  const g = new THREE.ExtrudeGeometry(shape, {
    depth: depth - bevel * 2, bevelEnabled: bevel > 0, bevelThickness: bevel, bevelSize: bevel,
    bevelSegments: 1, curveSegments, steps,
  });
  g.translate(0, 0, -(depth - bevel * 2) / 2);
  g.rotateY(Math.PI / 2);
  return g;
}

/** Frustum-like prism between two horizontal rectangles (legs, towers). */
export function prismBetween(b, t, hb, ht) {
  const P = [];
  for (const [c, h] of [[b, hb], [t, ht]]) {
    P.push([c[0] - h[0], c[1], c[2] - h[1]], [c[0] + h[0], c[1], c[2] - h[1]], [c[0] + h[0], c[1], c[2] + h[1]], [c[0] - h[0], c[1], c[2] + h[1]]);
  }
  const quads = [[0, 1, 2, 3], [7, 6, 5, 4], [0, 4, 5, 1], [1, 5, 6, 2], [2, 6, 7, 3], [3, 7, 4, 0]];
  const pos = [];
  for (const [a, b2, c, d] of quads) pos.push(...P[a], ...P[b2], ...P[c], ...P[a], ...P[c], ...P[d]);
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
  return g;
}

/** Point `obj` (whose geometry runs along +Y from 0 to 1) from a to b. */
const _up = new THREE.Vector3(0, 1, 0), _dir = new THREE.Vector3();
export function spanBetween(obj, a, b, stretch = true) {
  _dir.subVectors(b, a);
  const len = _dir.length();
  obj.position.copy(a);
  obj.quaternion.setFromUnitVectors(_up, _dir.normalize());
  if (stretch) obj.scale.set(1, len, 1);
  return len;
}
