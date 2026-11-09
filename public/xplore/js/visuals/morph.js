/*
 * XV morph reel — one renderer hosts every machine in REEL. After each machine's dwell,
 * the current machine freezes, its physics fades, and every white edge flies (GPU-animated,
 * glowing in the XV gradient mid-flight) to an edge of the next machine while the camera
 * glides between views. Order and screen times: see REEL.
 */
import {
  THREE, Stage, FX, GLSL_GRADIENT, LineSegments2, LineSegmentsGeometry, lerp, smoothstep, clamp, SKETCH, sketchLines,
} from './core.js';
import { mountTurbine, TURBINE_VIEW } from './turbine.js';
import { mountEngine, ENGINE_VIEW } from './engine.js';
import { mountPCB, PCB_VIEW } from './pcb.js';
import { mountRocket, ROCKET_VIEW } from './rocket.js';
import { mountBridge, BRIDGE_VIEW } from './bridge.js';
import { mountTelescope, TELESCOPE_VIEW } from './telescope.js';
import { mountExchanger, EXCHANGER_VIEW } from './exchanger.js';

// reel order alternates silhouettes; each machine gets its own screen time.
// `restart` machines replay their sequence from the top whenever they come on.
const DWELL_SCALE = 0.6;   // screen time per machine, relative to the dwell values below
export const REEL = [
  { name: 'turbine', view: TURBINE_VIEW, mount: mountTurbine, dwell: 9 },
  { name: 'bridge', view: BRIDGE_VIEW, mount: mountBridge, dwell: 11 },
  { name: 'engine', view: ENGINE_VIEW, mount: mountEngine, dwell: 9 },
  { name: 'telescope', view: TELESCOPE_VIEW, mount: mountTelescope, dwell: 10 },
  { name: 'pcb', view: PCB_VIEW, mount: mountPCB, dwell: 9 },
  { name: 'rocket', view: ROCKET_VIEW, mount: mountRocket, dwell: 8 },
  { name: 'exchanger', view: EXCHANGER_VIEW, mount: mountExchanger, dwell: 8 },
];


/* ------------------------------------------------------------ morph line material */

function morphMaterial(stage, draw, chaos) {
  const m = stage.lineMaterial({ width: 1.15 });
  m.uniforms.uP = { value: 0 };
  m.uniforms.uChaos = { value: chaos };
  m.uniforms.uDraw = { value: draw ? 1 : 0 };
  m.uniforms.uCA = { value: new THREE.Vector3() };
  m.uniforms.uCB = { value: new THREE.Vector3() };
  m.onBeforeCompile = (sh) => {
    sh.uniforms.uP = m.uniforms.uP; sh.uniforms.uCA = m.uniforms.uCA; sh.uniforms.uCB = m.uniforms.uCB; sh.uniforms.uDraw = m.uniforms.uDraw; sh.uniforms.uChaos = m.uniforms.uChaos;
    sh.vertexShader = sh.vertexShader
      .replace('void main() {', /* glsl */ `
        attribute vec3 instanceStartB; attribute vec3 instanceEndB; attribute vec4 instanceMorph;
        uniform float uP; uniform vec3 uCA; uniform vec3 uCB; uniform float uDraw; uniform float uChaos;
        varying float vGray; varying float vFly; varying float vHue;
        vec3 rotY(vec3 p, float a) { float c = cos(a), s = sin(a); return vec3(c * p.x + s * p.z, p.y, -s * p.x + c * p.z); }
        vec3 flyTo(vec3 a, vec3 b, vec3 mid, float e, float arc, float seed) {
          vec3 p = mix(a, b, e);
          vec3 c = mix(uCA, uCB, e);
          vec3 out_ = normalize(mid - c + vec3(1e-4));
          arc *= uChaos;                                             // chaos 0: every edge glides straight across
          p += out_ * arc * (0.25 + 0.6 * seed);                   // bloom outward
          p.y += arc * (seed - 0.4) * 0.6;                           // rise / fall
          return c + rotY(p - c, arc * (0.35 + 0.25 * seed));        // one coherent swirl about the vertical
        }
        void main() {`)
      .replace('void main() {', /* glsl */ `void main() {
          float q = clamp((uP - instanceMorph.x) / 0.6, 0.0, 1.0);
          float e = q * q * q * (q * (q * 6.0 - 15.0) + 10.0);
          float arc = sin(3.14159265 * q);
          vec3 midA = 0.5 * (instanceStart + instanceEnd), midB = 0.5 * (instanceStartB + instanceEndB);
          vec3 mid = mix(midA, midB, e);
          vec3 mS = flyTo(instanceStart, instanceStartB, mid, e, arc, instanceMorph.y);
          vec3 mE = flyTo(instanceEnd, instanceEndB, mid, e, arc, instanceMorph.y);
          vGray = mix(instanceMorph.z, instanceMorph.w, e);
          vFly = arc; vHue = instanceMorph.y;
          if (uDraw > 0.5) {
            // draw mode: a sweep erases every old stroke in the first half, the new machine is drawn in the
            // second; nothing is on screen at the midpoint, which is when the camera cuts to the new view
            float wave = 1.5 * instanceMorph.x;
            float er = 1.0 - clamp((uP * 2.0 - wave) / 0.4, 0.0, 1.0);
            float dr = clamp((uP * 2.0 - 1.0 - wave) / 0.4, 0.0, 1.0);
            dr = 1.0 - (1.0 - dr) * (1.0 - dr);
            if (uP < 0.5) { mS = instanceStart; mE = mix(instanceStart, instanceEnd, er); vGray = instanceMorph.z; }
            else { mS = instanceStartB; mE = mix(instanceStartB, instanceEndB, dr); vGray = instanceMorph.w; }
            vFly = 0.0;
          }`)
      .replace('vec4( instanceStart, 1.0 )', 'vec4( mS, 1.0 )')
      .replace('vec4( instanceEnd, 1.0 )', 'vec4( mE, 1.0 )');
    sh.fragmentShader = sh.fragmentShader
      .replace('void main() {', `${GLSL_GRADIENT}\nvarying float vGray; varying float vFly; varying float vHue; uniform float uChaos;\nvoid main() {`)
      .replace('gl_FragColor = vec4( diffuseColor.rgb, alpha );', /* glsl */ `
        float tint = vHue < 0.26 * uChaos ? clamp(vFly * 1.2, 0.0, 0.7) : 0.0;  // only a minority glows (fewer when calmer)
        vec3 hot = pow(xvGradient(vHue / 0.26), vec3(2.2)) * 1.5;
        gl_FragColor = vec4(mix(diffuseColor.rgb * vGray, hot, tint), alpha);`);
    if (SKETCH.on) sketchLines(sh);   // flying edges keep the pencil look
  };
  m.customProgramCacheKey = () => (SKETCH.on ? 'xv-morph-sketch' : 'xv-morph');
  return m;
}

/* ------------------------------------------------------------ segment snapshots */

// Primary (full-white) edges of one scene as live references: each flyer remembers which
// line object and which segment it came from, so it keeps following that part while it moves.
// Silhouette sets are skipped (their segments change meaning every frame).
function collectEdges(root, baseOpacity, skip) {
  const objs = [], refObj = [], refSeg = [];
  root.updateMatrixWorld(true);
  root.traverse((o) => {
    if (!o.isLineSegments2 || skip.has(o) || o.material.blending === THREE.AdditiveBlending) return;
    for (let p = o; p && p !== root.parent; p = p.parent) if (!p.visible) return;
    if (baseOpacity(o.material) < 0.9) return;
    const arr = o.geometry.attributes.instanceStart?.data.array;
    if (!arr) return;
    const n = arr.length / 6;
    const oi = objs.push(o) - 1;
    for (let i = 0; i < n; i++) { refObj.push(oi); refSeg.push(i); }
  });
  const E = { objs, refObj: Int32Array.from(refObj), refSeg: Int32Array.from(refSeg), n: refObj.length };
  E.segs = new Float32Array(E.n * 6);
  writeLive(E, null, E.segs);
  return E;
}

// world-space endpoints of edges (all, or the subset `pick`) from their objects' current state
function writeLive(E, pick, out) {
  const K = pick ? pick.length : E.n;
  for (let k = 0; k < K; k++) {
    const i = pick ? pick[k] : k;
    const o = E.objs[E.refObj[i]];
    const a = o.geometry.attributes.instanceStart.data.array, e = o.matrixWorld.elements, s = E.refSeg[i] * 6, d = k * 6;
    for (let j = 0; j < 6; j += 3) {
      const x = a[s + j], y = a[s + j + 1], z = a[s + j + 2];
      out[d + j] = e[0] * x + e[4] * y + e[8] * z + e[12];
      out[d + j + 1] = e[1] * x + e[5] * y + e[9] * z + e[13];
      out[d + j + 2] = e[2] * x + e[6] * y + e[10] * z + e[14];
    }
  }
}

// scan order: x-slices left -> right, Morton (y, z) inside each slice. Returns K evenly spread picks.
function scanPick(S, K) {
  const { segs, n } = S;
  const mid = new Float32Array(n * 3), mn = [Infinity, Infinity, Infinity], mx = [-Infinity, -Infinity, -Infinity];
  for (let i = 0; i < n; i++) for (let a = 0; a < 3; a++) {
    const m = 0.5 * (segs[i * 6 + a] + segs[i * 6 + 3 + a]);
    mid[i * 3 + a] = m; if (m < mn[a]) mn[a] = m; if (m > mx[a]) mx[a] = m;
  }
  const spread = (x) => { x &= 1023; x = (x | (x << 8)) & 0x00ff00ff; x = (x | (x << 4)) & 0x0f0f0f0f; x = (x | (x << 2)) & 0x33333333; return (x | (x << 1)) & 0x55555555; };
  const SL = 40, keys = new Float64Array(n), idx = new Uint32Array(n);
  const nz = (i, a) => (mid[i * 3 + a] - mn[a]) / (mx[a] - mn[a] || 1);
  for (let i = 0; i < n; i++) {
    const slice = Math.min(SL - 1, Math.floor(nz(i, 0) * SL));
    keys[i] = slice * 2 ** 21 + (spread(Math.floor(nz(i, 1) * 1023)) | (spread(Math.floor(nz(i, 2) * 1023)) << 1));
    idx[i] = i;
  }
  idx.sort((a, b) => keys[a] - keys[b]);
  const pick = new Uint32Array(K);
  for (let k = 0; k < K; k++) pick[k] = idx[Math.floor(((k + 0.5) * n) / K)];
  return { pick, mid, c: [(mn[0] + mx[0]) / 2, (mn[1] + mx[1]) / 2, (mn[2] + mx[2]) / 2] };
}

/* ------------------------------------------------------------ mount */

export function mountMorph(el, opts = {}) {
  const dur = opts.duration ?? 3.2;       // seconds per morph
  const notify = (i, phase) => opts.onChange?.({ index: i, name: reel[i].name, phase, duration: dur, dwell: scenes[i].dwell });
  const reel = (opts.machines || REEL.map((m) => m.name)).map((n) => REEL.find((m) => m.name === n)).filter(Boolean);
  const stage = new Stage(el, { ...reel[0].view, speed: 1, drift: () => ({ yaw: 0, pitch: 0 }), parallax: opts.parallax ?? 1 });

  // one proxy stage per machine: shares renderer/materials, owns its root, updaters and clock
  const scenes = reel.map(({ view, dwell, restart }) => {
    const root = new THREE.Group();
    root.visible = false;
    stage.scene.add(root);
    const p = Object.create(stage);
    p.scene = root; p.hud = null;
    p.ups = [];
    p.onUpdate = (fn) => p.ups.push(fn);
    p.basePos = new THREE.Vector3(...view.camera.position);
    p.target = new THREE.Vector3(...view.camera.target);
    return { view, root, proxy: p, t: 0, dwell: opts.dwell ?? dwell * DWELL_SCALE * (opts.dwellScale ?? 1), restart };
  });
  reel.forEach((m, i) => m.mount(null, { stage: scenes[i].proxy }));
  const ready = Promise.all(scenes.map((S) => S.proxy.ready || Promise.resolve()));

  const tick = (S, dt) => { S.t += dt * S.view.speed; for (const fn of S.proxy.ups) fn(S.t, dt * S.view.speed); };

  // chaos 1 = the full flight (bloom, rise, swirl, a scattered launch, a share of glowing flyers);
  // lower values tame each of those and send fewer edges flying (the rest dissolve in place)
  const chaos = clamp(opts.chaos ?? 1, 0, 1);
  const FLY = Math.round((opts.flyers ?? 6000) * (0.4 + 0.6 * chaos));
  let cur = 0, next = 1, phase = 'hold', clock = 0;
  scenes[0].root.visible = true;
  let morphLines = null;
  // style: 'fly' (default) edges fly between machines; 'draw' erases and redraws strokes; 'fade' cross-fades
  const draw = opts.style === 'draw', fade = opts.style === 'fade';
  const mat = morphMaterial(stage, draw, chaos);
  // fly: the camera glides with the flying edges; draw / fade: it cuts at the midpoint, when the frame is empty
  const camK = (p) => (draw || fade ? (p < 0.5 ? 0 : 1) : ease(p));

  // per-machine copies of every edge / face material so each machine can fade on its own
  const base = new Map();
  const own = (S) => {
    const map = new Map();
    S.mats = [];
    S.root.traverse((o) => {
      const m = o.material;
      if (!m || Array.isArray(m)) return;
      const isLine = m.isLineMaterial && m.blending !== THREE.AdditiveBlending;
      const isFace = o.isMesh && (m === stage.mat.face || m.userData.face);   // the black fill, or a paint
      if (!isLine && !isFace) return;
      let c = map.get(m);
      if (!c) {
        c = m.clone();
        c.onBeforeCompile = m.onBeforeCompile;             // clone() drops shader patches (pencil mode)
        c.customProgramCacheKey = m.customProgramCacheKey;
        if (isLine) stage.lineMaterials.push(c);
        map.set(m, c);
        S.mats.push({ m: c, base: m.opacity, tr: m.transparent, dw: m.depthWrite, face: isFace });
        base.set(c, m.opacity);
      }
      o.material = c;
    });
  };
  const setAlpha = (S, a) => {
    for (const r of S.mats || []) {
      r.m.opacity = r.base * a;
      r.m.transparent = r.tr || a < 0.999;
      if (r.face) r.m.depthWrite = r.dw && a > 0.5;   // an almost-invisible solid must not hide edges
    }
  };
  const baseOpacity = (m) => (base.has(m) ? base.get(m) : m.opacity);
  const ease = (x) => smoothstep(0, 1, x);

  const camFrom = { pos: new THREE.Vector3(), tgt: new THREE.Vector3(), fov: 0, ref: 0, ff: 0 };
  const camTo = { pos: new THREE.Vector3(), tgt: new THREE.Vector3(), fov: 0, ref: 0, ff: 0 };
  const setView = (S) => {                                    // the stage applies fov and fit as it places the camera
    stage.basePos.copy(S.proxy.basePos); stage.target.copy(S.proxy.target);
    stage.fov = S.view.camera.fov; stage.refAspect = S.view.refAspect; stage.fitFov = S.view.fitFov || 0;
  };
  setView(scenes[0]);
  stage.drift = () => scenes[cur].view.drift(scenes[cur].t);
  const ownAll = ready.then(() => {
    scenes.forEach(own);
    // precompute each machine's primary edges + scan order once, and compile every shader up front
    const skip = new Set(stage.wires.map((w) => w.silLines).filter(Boolean));
    const vis = scenes.map((S) => S.root.visible);
    scenes.forEach((S) => {
      S.root.visible = true;
      tick(S, 0);
      S.edges = collectEdges(S.root, baseOpacity, skip);
      S.order = scanPick(S.edges, Math.min(FLY, S.edges.n));
    });
    stage.renderer.compile(stage.scene, stage.camera);
    scenes.forEach((S, i) => { S.root.visible = vis[i]; });
  });

  let queued = -1;
  function requestMorph(to) {
    if (phase !== 'hold') { queued = to; return; }   // clicked mid-morph: go there as soon as this one lands
    if (to === cur) return;
    next = to;
    startMorph();
  }

  let live = null;   // { EA, EB, pickA, pickB, pa, pb, g }
  function startMorph() {
    const A = scenes[cur], B = scenes[next];
    from = { l: hl, r: hr };                             // the playhead glides from wherever it is now
    setAlpha(B, 0);
    // the incoming machine's glow materials stay switched off until its colours may fade in
    // (material-level, so modules that toggle their own object visibility can't flash them)
    B.physics = new Set();
    B.root.traverse((o) => {
      const m = o.material;
      if (m && !Array.isArray(m) && m.blending === THREE.AdditiveBlending && m.visible) B.physics.add(m);
    });
    for (const m of B.physics) m.visible = false;
    B.root.visible = true;
    if (B.restart) B.t = 0;                              // sequenced machines replay from the top
    tick(B, 0);                                          // pose B's mechanisms; it keeps running from here
    live = null;
    if (!fade) {
    const EA = A.edges, EB = B.edges;
    const K = Math.min(A.order.pick.length, B.order.pick.length);
    const sub = (o) => ({ ...o, pick: o.pick.length === K ? o.pick : Uint32Array.from({ length: K }, (_, i) => o.pick[Math.floor((i * o.pick.length) / K)]) });
    const oa = sub(A.order), ob = sub(B.order);
    const pa = new Float32Array(K * 6), pb = new Float32Array(K * 6), mm = new Float32Array(K * 4);
    const hash = (i) => { const x = Math.sin(i * 12.9898) * 43758.5453; return x - Math.floor(x); };
    for (let i = 0; i < K; i++) {
      mm[i * 4] = 0.4 * (0.85 * (i / K) + 0.15 * chaos * hash(i));   // scan wave left -> right, scattered by chaos
      mm[i * 4 + 1] = hash(i + 7.3);
      mm[i * 4 + 2] = 1; mm[i * 4 + 3] = 1;
    }
    writeLive(EA, oa.pick, pa);
    writeLive(EB, ob.pick, pb);
    const g = new LineSegmentsGeometry().setPositions(pa);
    g.attributes.instanceStart.data.setUsage(THREE.DynamicDrawUsage);
    const bufB = new THREE.InstancedInterleavedBuffer(pb, 6, 1).setUsage(THREE.DynamicDrawUsage);
    g.setAttribute('instanceStartB', new THREE.InterleavedBufferAttribute(bufB, 3, 0));
    g.setAttribute('instanceEndB', new THREE.InterleavedBufferAttribute(bufB, 3, 3));
    g.setAttribute('instanceMorph', new THREE.InstancedBufferAttribute(mm, 4));
    if (morphLines) { morphLines.geometry.dispose(); stage.scene.remove(morphLines); }
    morphLines = new LineSegments2(g, mat);
    morphLines.frustumCulled = false;
    stage.scene.add(morphLines);
    live = { EA, EB, pickA: oa.pick, pickB: ob.pick, pa, pb, g, bufB };
    mat.uniforms.uCA.value.set(...oa.c); mat.uniforms.uCB.value.set(...ob.c);
    mat.uniforms.uP.value = 0;
    }

    camFrom.pos.copy(stage.basePos); camFrom.tgt.copy(stage.target); camFrom.fov = stage.fov; camFrom.ref = stage.refAspect; camFrom.ff = stage.fitFov;
    camTo.pos.copy(B.proxy.basePos); camTo.tgt.copy(B.proxy.target); camTo.fov = B.view.camera.fov; camTo.ref = B.view.refAspect; camTo.ff = B.view.fitFov || 0;
    const dA = A.view.drift, dB = B.view.drift;
    stage.drift = () => {
      const k = camK(clock / dur), a = dA(A.t), b = dB(B.t);
      return { yaw: lerp(a.yaw, b.yaw, k), pitch: lerp(a.pitch, b.pitch, k) };
    };
    phase = 'morph'; clock = 0;
    notify(next, 'morph');
  }

  function endMorph() {
    const A = scenes[cur], B = scenes[next];
    A.root.visible = false; setAlpha(A, 1);
    if (B.physics) { for (const m of B.physics) m.visible = true; B.physics = null; }
    setAlpha(B, 1);
    if (morphLines) stage.scene.remove(morphLines);
    setView(B);
    cur = next; phase = 'hold'; clock = 0; live = null;
    notify(cur, 'hold');
    if (queued >= 0 && queued !== cur) { const q = queued; queued = -1; requestMorph(q); } else queued = -1;
    stage.drift = () => scenes[cur].view.drift(scenes[cur].t);
  }

  /* progress bar: one playhead that fills the current segment and slides to the next ----------
     (opts.controls === false leaves the reel with no UI at all) */
  const showBar = opts.controls !== false;
  const bar = showBar ? document.createElement('div') : null;
  let segs = [], head = null;
  if (showBar) {
  bar.className = 'xv-reel';
  bar.innerHTML = scenes.map((S, i) => `<button type="button" style="--d:${S.dwell}" aria-label="Show ${reel[i].name}"><i></i></button>`).join('') + '<b class="xv-head"></b>';
  el.appendChild(bar);
  segs = [...bar.querySelectorAll('button')];
  head = bar.querySelector('.xv-head');
  segs.forEach((b, i) => b.addEventListener('click', () => ownAll.then(() => requestMorph(i))));
  const st = document.createElement('style');
  st.textContent = `
    .xv-reel{position:absolute;left:50%;bottom:max(28px,env(safe-area-inset-bottom,0px));transform:translateX(-50%);display:flex;gap:8px;z-index:2}
    .xv-reel button{all:unset;cursor:pointer;width:calc(var(--d,9) * clamp(3.5px,.7vw,8px));height:14px;display:flex;align-items:center}
    .xv-reel button i{display:block;height:2px;width:100%;background:rgba(255,255,255,.16);transition:background .2s}
    .xv-reel button:hover i{background:rgba(255,255,255,.34)}
    .xv-reel button:focus-visible i{outline:1px solid rgba(255,255,255,.7);outline-offset:4px}
    .xv-reel .xv-head{position:absolute;left:0;top:6px;height:2px;width:0;pointer-events:none;
      background:linear-gradient(90deg,#1a44ff,#8f35e0,#ff3a2c);background-size:var(--bw,100px) 100%;background-position:var(--bx,0) 0}`;
  document.head.appendChild(st);
  }
  const HEAD_MIN = 4;                                  // px the playhead keeps when it arrives
  const segRect = (i) => ({ l: segs[i].offsetLeft, w: segs[i].offsetWidth });
  let hl = 0, hr = HEAD_MIN;
  const drawHead = (l, r) => {
    hl = l; hr = r;
    head.style.transform = `translateX(${l.toFixed(1)}px)`;
    head.style.width = `${Math.max(0, r - l).toFixed(1)}px`;
    head.style.setProperty('--bw', `${bar.offsetWidth}px`);        // gradient spans the whole bar, so colour = position
    head.style.setProperty('--bx', `${(-l).toFixed(1)}px`);
  };
  let from = { l: 0, r: HEAD_MIN };

  /* driver -------------------------------------------------------------------- */
  let owned = false;
  ownAll.then(() => { owned = true; });
  stage.onUpdate((t, dt) => {
    const S = scenes[cur];
    clock += dt;
    if (phase === 'hold') {
      tick(S, dt);
      FX.value = 1;
      if (clock >= S.dwell && owned) requestMorph((cur + 1) % scenes.length);
    } else if (phase === 'morph') {
      const p = Math.min(1, clock / dur);
      const A = scenes[cur], B = scenes[next];
      // both machines keep running: the old one breaks apart in motion, the new one forms in motion
      if (A.root.visible) tick(A, dt);
      tick(B, dt);
      A.root.updateMatrixWorld(true); B.root.updateMatrixWorld(true);
      if (live) {
        writeLive(live.EA, live.pickA, live.pa);
        writeLive(live.EB, live.pickB, live.pb);
        live.g.attributes.instanceStart.data.needsUpdate = true;
        live.bufB.needsUpdate = true;
      }
      mat.uniforms.uP.value = p;
      FX.value = p < 0.5 ? 1 - smoothstep(0.0, 0.3, p) : smoothstep(0.7, 1.0, p);   // old physics out, new in
      setAlpha(A, 1 - smoothstep(0.03, 0.4, p));
      setAlpha(B, smoothstep(0.6, 0.97, p));
      if (p >= 0.7 && B.physics) { for (const m of B.physics) m.visible = true; B.physics = null; }   // FX is ~0 here, then ramps
      if (p > 0.4) A.root.visible = false;
      const k = camK(p);
      stage.basePos.lerpVectors(camFrom.pos, camTo.pos, k);
      stage.target.lerpVectors(camFrom.tgt, camTo.tgt, k);
      stage.fov = lerp(camFrom.fov, camTo.fov, k);
      stage.refAspect = lerp(camFrom.ref, camTo.ref, k);
      stage.fitFov = lerp(camFrom.ff, camTo.ff, k);
      if (p >= 1) endMorph();
    }
    if (!showBar) return;
    if (phase === 'hold') {
      const R = segRect(cur);
      drawHead(R.l, R.l + HEAD_MIN + (R.w - HEAD_MIN) * Math.min(1, clock / scenes[cur].dwell));
      from = { l: hl, r: hr };
    } else {
      // glide: the leading edge travels first, the tail follows, and it lands as a short head
      const p = Math.min(1, clock / dur), R = segRect(next);
      const fwd = R.l >= from.l;
      const lead = ease(Math.min(1, p * 1.35)), tail = ease(Math.max(0, (p - 0.2) / 0.8));
      const toL = R.l, toR = R.l + HEAD_MIN;
      drawHead(lerp(from.l, toL, fwd ? tail : lead), lerp(from.r, toR, fwd ? lead : tail));
    }
  });

  ready.then(() => notify(0, 'hold'));
  stage.ready = ownAll;
  return stage;
}
