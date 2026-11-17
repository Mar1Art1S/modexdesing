/*
 * XV-06 — The Hubble Space Telescope in low Earth orbit, as it has flown since the last servicing
 * mission. Built to the real spacecraft at 1 unit = 2.2 m: 13.2 m long, 4.3 m across the aft
 * shroud, 3.1 m across the forward shell and light shield.
 * From the front: the aperture door standing open, the light shield and forward shell in their
 * quilted thermal panels, the two rigid solar wings (7.1 × 2.6 m) on short masts, the high-gain
 * antennas on their booms, the ring of equipment bays, the aft shroud with its instrument doors,
 * handrails for the astronauts who serviced it, and the soft-capture ring on the aft bulkhead.
 * A window cut into the tube shows the Ritchey–Chrétien optics: a 2.4 m f/2.3 primary with its
 * central hole and baffle, the 0.3 m secondary 4.9 m in front of it on a four-vane spider (the
 * diffraction spikes in every Hubble picture), focusing at f/24 among the instruments behind the primary.
 * Colour = wavelength of each photon packet. Earth turns below and the stars drift: we're orbiting.
 */
import {
  THREE, Stage, mergeParts, lines, circleSegments, latheX, capAt, sectionHatch, rng, smoothstep, lerp, clamp, trailRibbons,
} from './core.js';

const U = 1 / 2.2;                        // metres -> units
const R_TUBE = 1.55 * U;                  // forward shell + light shield
const R_AFT = 2.14 * U;                   // equipment section + aft shroud
const X_AFT = -3.12;                      // aft bulkhead
const X_ES = X_AFT + 3.5 * U;             // aft shroud | equipment section
const X_FS = X_ES + 1.55 * U;             // equipment section | forward shell (the step down)
const X_LS = X_FS + 4.0 * U;              // forward shell | light shield
const X_AP = X_AFT + 13.0 * U;            // aperture
const X_PM = X_FS + 0.12;                 // primary mirror vertex
const F_PM = 5.52 * U;                    // primary focal length (f/2.3)
const R_PM = 1.2 * U, R_HOLE = 0.3 * U;   // 2.4 m primary, 0.6 m central hole
const X_SM = X_PM + 4.9 * U;              // secondary, 4.9 m in front of the primary
const R_SM = 0.15 * U;                    // 0.3 m secondary
const X_FOCUS = X_PM - 1.5 * U;           // f/24 focus, 1.5 m behind the primary

export const TELESCOPE_VIEW = {
  camera: { fov: 30, position: [5.6, 4.8, 10.4], target: [0.0, 0.1, 0] },
  refAspect: 1.8,
  drift: (t) => ({ yaw: Math.sin(t * 0.045) * 0.12, pitch: Math.sin(t * 0.035) * 0.03 }),
  speed: 1,
};

export function mountTelescope(el, opts = {}) {
  const stage = opts.stage || new Stage(el, { ...TELESCOPE_VIEW, ...opts, hud: false });
  const { scene } = stage;
  const rand = rng(81);
  const Xv = new THREE.Vector3(1, 0, 0), Yv = new THREE.Vector3(0, 1, 0), Zv = new THREE.Vector3(0, 0, 1);

  const sc = new THREE.Group();            // the observatory (slews slowly)
  scene.add(sc);
  const solid = [], dim = [], faint = [];
  const ringArc = (out, x, r, a0, a1, n = 64) => {
    for (let i = 0; i < n; i++) {
      const b0 = a0 + ((a1 - a0) * i) / n, b1 = a0 + ((a1 - a0) * (i + 1)) / n;
      out.push(x, r * Math.cos(b0), r * Math.sin(b0), x, r * Math.cos(b1), r * Math.sin(b1));
    }
  };

  /* forward shell + light shield, with a window cut toward the camera ------------------------ */
  const camDir = Math.atan2(stage.basePos.z - stage.target.z, stage.basePos.y - stage.target.y);
  const CUT = 0.62;
  const th0 = camDir + CUT, th1 = camDir + Math.PI * 2 - CUT;
  const T = 0.025;
  const shell = [[X_FS, R_TUBE - T], [X_AP, R_TUBE - T], [X_AP, R_TUBE + 0.03], [X_AP - 0.05, R_TUBE + 0.03], [X_AP - 0.05, R_TUBE],
    [X_LS + 0.03, R_TUBE], [X_LS + 0.03, R_TUBE + 0.015], [X_LS - 0.03, R_TUBE + 0.015], [X_LS - 0.03, R_TUBE], [X_FS, R_TUBE]];
  solid.push(latheX([...shell, shell[0]], 96, th0, th1), capAt(shell, th0), capAt(shell, th1));
  const hatch = sectionHatch(shell, th0, th1, 0.02);
  // quilted thermal panels: longitudinal seams every 15°, hoops every ~0.6 m
  for (let k = 0; k < 24; k++) {
    const a = (k / 24) * Math.PI * 2;
    if (!(((a - th0) % (2 * Math.PI) + 2 * Math.PI) % (2 * Math.PI) < th1 - th0)) continue;
    const r = R_TUBE + 0.003;
    faint.push(X_FS + 0.02, r * Math.cos(a), r * Math.sin(a), X_AP - 0.06, r * Math.cos(a), r * Math.sin(a));
  }
  for (let x = X_FS + 0.28; x < X_AP - 0.1; x += 0.27) ringArc(faint, x, R_TUBE + 0.003, th0, th1, 80);
  // light baffle rings inside the shield
  for (let x = X_LS + 0.2; x < X_AP; x += 0.3) ringArc(faint, x, R_TUBE - 0.09, th0, th1, 64);

  // aperture door, hinged at the top of the light shield, standing open
  const doorPivot = new THREE.Group(); doorPivot.position.set(X_AP, R_TUBE + 0.05, 0); sc.add(doorPivot);
  const door = latheX([[0, 0], [0, R_TUBE + 0.04], [0.045, R_TUBE + 0.04], [0.06, R_TUBE - 0.1], [0.06, 0]], 64);
  door.translate(0, -(R_TUBE + 0.05), 0);
  doorPivot.add(stage.wire(door, { crease: 30 }));
  doorPivot.rotation.z = -1.85;
  const hinge = new THREE.BoxGeometry(0.16, 0.08, 0.36); hinge.translate(X_AP - 0.03, R_TUBE + 0.06, 0);
  const mags = [-1, 1].map((s) => { const g = new THREE.BoxGeometry(0.22, 0.05, 0.07); g.translate(X_AP - 0.22, R_TUBE * Math.cos(s * 0.5) + 0.03, R_TUBE * Math.sin(s * 0.5)); return g; });   // magnetometers
  solid.push(hinge, ...mags);

  /* equipment section (a ring of ten bays) and aft shroud ----------------------------------- */
  solid.push(latheX([[X_ES, R_TUBE], [X_ES, R_AFT], [X_FS, R_AFT], [X_FS, R_TUBE]], 10, Math.PI / 10, Math.PI / 10 + Math.PI * 2));   // flat bay doors
  solid.push(latheX([[X_AFT, 0], [X_AFT, R_AFT - 0.06], [X_AFT + 0.05, R_AFT], [X_ES, R_AFT], [X_ES, 0]], 72));
  solid.push(latheX([[X_AFT - 0.16, 0.18], [X_AFT - 0.16, 0.36], [X_AFT, 0.36], [X_AFT, 0.18]], 48));            // soft-capture ring
  const bays = [];
  for (let k = 0; k < 10; k++) {
    const a0 = Math.PI / 10 + (k / 10) * Math.PI * 2, a1 = a0 + Math.PI / 5, am = (a0 + a1) / 2, rr = R_AFT * Math.cos(Math.PI / 10) + 0.004;
    const n = [Math.cos(am), Math.sin(am)], t = [-Math.sin(am), Math.cos(am)], w = 0.24;
    const P = (x, s) => [x, n[0] * rr + t[0] * s, n[1] * rr + t[1] * s];
    const q = [P(X_ES + 0.06, -w), P(X_FS - 0.06, -w), P(X_FS - 0.06, w), P(X_ES + 0.06, w)];
    for (let i = 0; i < 4; i++) bays.push(...q[i], ...q[(i + 1) % 4]);
    const H = (x) => [x, n[0] * (rr + 0.04), n[1] * (rr + 0.04)];          // handrails along every bay
    bays.push(...H(X_ES + 0.04), ...H(X_FS - 0.04));
  }
  for (let k = 0; k < 4; k++) {                                           // instrument access doors on the aft shroud
    const am = Math.PI / 4 + (k / 4) * Math.PI * 2, r = R_AFT + 0.004, h = 0.42;
    const P = (x, s) => [x, r * Math.cos(am + s), r * Math.sin(am + s)];
    const q = [P(X_AFT + 0.2, -h), P(X_ES - 0.12, -h), P(X_ES - 0.12, h), P(X_AFT + 0.2, h)];
    for (let i = 0; i < 4; i++) {
      const A = q[i], B = q[(i + 1) % 4];
      if (i % 2) for (let j = 0; j < 8; j++) {                              // curved edges follow the shroud
        const s0 = lerp(i === 1 ? -h : h, i === 1 ? h : -h, j / 8), s1 = lerp(i === 1 ? -h : h, i === 1 ? h : -h, (j + 1) / 8);
        bays.push(...P(A[0], s0), ...P(A[0], s1));
      } else bays.push(...A, ...B);
    }
    const H = (s) => [X_AFT + 0.12, (r + 0.04) * Math.cos(am + s), (r + 0.04) * Math.sin(am + s)];
    bays.push(...H(-h), ...H(h));
    for (const s of [-0.62, 0.62]) bays.push(X_AFT + 0.15, (r + 0.04) * Math.cos(am + s), (r + 0.04) * Math.sin(am + s), X_ES - 0.1, (r + 0.04) * Math.cos(am + s), (r + 0.04) * Math.sin(am + s));
  }
  ringArc(bays, X_ES, R_AFT + 0.004, 0, Math.PI * 2, 96);
  dim.push(...bays);

  /* optics: primary (with central hole and baffle), secondary on a four-vane spider, focal plane */
  const pm = [[X_PM, R_HOLE]];
  for (let i = 0; i <= 12; i++) { const r = lerp(R_HOLE, R_PM, i / 12); pm.push([X_PM + (r * r) / (4 * F_PM), r]); }
  pm.push([X_PM - 0.14, R_PM], [X_PM - 0.14, R_HOLE]);
  const sm = latheX([[X_SM, 0], [X_SM, R_SM], [X_SM + 0.04, R_SM], [X_SM + 0.1, 0.035], [X_SM + 0.1, 0]], 40);
  const pmBaffle = latheX([[X_PM - 0.14, R_HOLE - 0.012], [X_PM + 0.62, R_HOLE - 0.012], [X_PM + 0.62, R_HOLE], [X_PM - 0.14, R_HOLE]], 40);
  const smBaffle = latheX([[X_SM - 0.22, R_SM + 0.07], [X_SM + 0.03, R_SM + 0.07], [X_SM + 0.03, R_SM + 0.085], [X_SM - 0.22, R_SM + 0.085]], 40);
  const mainRing = latheX([[X_PM - 0.18, R_PM + 0.02], [X_PM - 0.18, R_TUBE - T], [X_PM - 0.06, R_TUBE - T], [X_PM - 0.06, R_PM + 0.02]], 72, th0, th1);
  sc.add(stage.wire(mergeParts([latheX([...pm, pm[0]], 72), sm, pmBaffle, smBaffle, mainRing]), { crease: 26 }));
  const spider = [];
  for (let k = 0; k < 4; k++) {
    const a = Math.PI / 4 + (k / 4) * Math.PI * 2;
    for (const dx of [0.02, 0.07]) spider.push(X_SM + dx, (R_SM + 0.085) * Math.cos(a), (R_SM + 0.085) * Math.sin(a), X_SM + dx, (R_TUBE - T) * Math.cos(a), (R_TUBE - T) * Math.sin(a));
  }
  circleSegments(spider, new THREE.Vector3(X_FOCUS, 0, 0), Yv, Zv, 0.04, 16);
  sc.add(lines(stage, spider, stage.mat.line));

  /* solar wings on short masts, high-gain antennas on booms ------------------------------------ */
  const XW = X_FS + 0.25;                                       // where the wing masts leave the forward shell
  const WL = 7.1 * U, WW = 2.6 * U, WD = R_AFT + WW / 2 + 0.1;    // wing length (along the telescope), width, mast reach
  const wings = [];
  const panelG = new THREE.BoxGeometry(WL, 0.025, WW);
  const cells = [];
  for (let k = 1; k < 10; k++) { const x = -WL / 2 + (k * WL) / 10; cells.push(x, 0.014, -WW / 2 + 0.02, x, 0.014, WW / 2 - 0.02); }
  for (const z of [-WW / 4, 0, WW / 4]) cells.push(-WL / 2 + 0.03, 0.014, z, WL / 2 - 0.03, 0.014, z);
  const spineG = new THREE.CylinderGeometry(0.02, 0.02, WL, 10); spineG.rotateZ(Math.PI / 2);
  const mastG = new THREE.CylinderGeometry(0.03, 0.03, WD - R_TUBE, 12); mastG.rotateX(Math.PI / 2); mastG.translate(0, 0, (WD - R_TUBE) / 2);
  const driveG = new THREE.BoxGeometry(0.12, 0.12, 0.14); driveG.translate(0, 0, 0.07);
  for (const s of [1, -1]) {
    const root = new THREE.Group(); root.position.set(XW, 0, s * R_TUBE); root.rotation.y = s > 0 ? 0 : Math.PI; sc.add(root);
    root.add(stage.wire(mergeParts([mastG, driveG]), { crease: 30 }));
    const drive = new THREE.Group(); drive.position.z = WD - R_TUBE; root.add(drive);
    const wing = new THREE.Group(); drive.add(wing);
    wing.add(stage.wire(mergeParts([panelG, spineG]), { crease: 30, silhouette: false }));
    wing.add(lines(stage, cells, stage.mat.dim));
    wings.push({ drive });
  }
  const hga = [];
  const RD = 0.65 * U;                                          // 1.3 m dishes
  const dishG = new THREE.LatheGeometry(Array.from({ length: 10 }, (_, i) => new THREE.Vector2(0.001 + (i / 9) * RD, ((i / 9) * RD) ** 2 * 1.4)), 36);
  const BL = 4.4 * U;
  const boomG = new THREE.CylinderGeometry(0.022, 0.022, BL, 10); boomG.translate(0, BL / 2, 0);
  for (const s of [1, -1]) {
    const boom = new THREE.Group(); boom.position.set(X_FS + 0.55, s * R_TUBE, 0); boom.rotation.x = s > 0 ? 0 : Math.PI; sc.add(boom);
    boom.add(stage.wire(boomG, { crease: 30 }));
    const gimbal = new THREE.Group(); gimbal.position.y = BL; boom.add(gimbal);
    const d = stage.wire(dishG, { crease: 30 }); d.position.y = 0.05; gimbal.add(d);
    const feed = new THREE.CylinderGeometry(0.008, 0.008, 0.16, 6); feed.translate(0, 0.13, 0);
    gimbal.add(stage.wire(feed, { crease: 30 }));
    hga.push(gimbal);
  }
  // low-gain antennas fore and aft, a handrail along the forward shell
  const lgaF = new THREE.ConeGeometry(0.06, 0.12, 10); lgaF.translate(X_AP - 0.4, R_TUBE + 0.07, 0);
  const lgaA = new THREE.ConeGeometry(0.06, 0.12, 10); lgaA.rotateZ(Math.PI / 2); lgaA.translate(X_AFT - 0.06, 0, -(R_AFT - 0.3));
  solid.push(lgaF, lgaA);
  for (const a of [Math.PI * 0.75, Math.PI * 1.25]) dim.push(X_FS + 0.1, (R_TUBE + 0.04) * Math.cos(a), (R_TUBE + 0.04) * Math.sin(a), X_LS - 0.1, (R_TUBE + 0.04) * Math.cos(a), (R_TUBE + 0.04) * Math.sin(a));

  sc.add(stage.wire(mergeParts(solid), { crease: 20 }));
  sc.add(lines(stage, dim, stage.mat.dim), lines(stage, faint, stage.mat.faint), lines(stage, hatch, stage.mat.hatch));

  /* starlight through the optics: aperture -> primary -> secondary -> focus ------------------- */
  const NPH = 520, KPH = 12;
  const ph = trailRibbons(stage, NPH, KPH, { width: 1.6, ghost: 0.22 });
  sc.add(ph.mesh);
  const XPF = X_PM + F_PM;                                  // prime focus the secondary intercepts
  const rays = Array.from({ length: NPH }, () => {
    const rho = lerp(R_SM + 0.1, R_PM - 0.02, Math.sqrt(rand())), a = rand() * Math.PI * 2, c = Math.cos(a), s = Math.sin(a);
    const xp = X_PM + (rho * rho) / (4 * F_PM);
    const rs = rho * (XPF - X_SM) / (XPF - xp);
    const pts = [[X_AP + 1.4, rho * c, rho * s], [xp, rho * c, rho * s], [X_SM, rs * c, rs * s], [X_FOCUS, 0, 0]];
    const seg = [];
    for (let i = 1; i < 4; i++) seg.push(Math.hypot(pts[i][0] - pts[i - 1][0], pts[i][1] - pts[i - 1][1], pts[i][2] - pts[i - 1][2]));
    const L = seg.reduce((p, q) => p + q, 0);
    return { pts, seg, L, s: rand() * L, q: rand() };
  });
  const at = (R, d, out, o) => {
    d = clamp(d, 0, R.L);
    let i = 0; while (i < 2 && d > R.seg[i]) { d -= R.seg[i]; i++; }
    const a = R.pts[i], b = R.pts[i + 1], f = d / R.seg[i];
    out[o] = a[0] + (b[0] - a[0]) * f; out[o + 1] = a[1] + (b[1] - a[1]) * f; out[o + 2] = a[2] + (b[2] - a[2]) * f;
  };

  /* Earth close below, stars ------------------------------------------------------------------ */
  const earth = new THREE.Group();
  earth.position.set(-4, -46, -14);
  earth.rotation.set(1.1, 0, 0.25);
  scene.add(earth);
  earth.add(stage.wire(new THREE.SphereGeometry(40, 140, 70), { crease: 80 }));
  const grat = [];
  for (let lat = -80; lat <= 80; lat += 8) {
    const r = 40.04 * Math.cos((lat * Math.PI) / 180), y = 40.04 * Math.sin((lat * Math.PI) / 180);
    circleSegments(grat, new THREE.Vector3(0, y, 0), Xv, Zv, r, 220);
  }
  for (let lon = 0; lon < 180; lon += 8) { const a = (lon * Math.PI) / 180; circleSegments(grat, new THREE.Vector3(), new THREE.Vector3(Math.cos(a), 0, Math.sin(a)), Yv, 40.04, 220); }
  earth.add(lines(stage, grat, stage.mat.faint));
  const sp = [];
  for (let i = 0; i < 1500; i++) {
    const u = rand() * 2 - 1, a = rand() * Math.PI * 2, r = 80;
    sp.push(r * Math.sqrt(1 - u * u) * Math.cos(a), r * u, r * Math.sqrt(1 - u * u) * Math.sin(a));
  }
  const starG = new THREE.BufferGeometry(); starG.setAttribute('position', new THREE.Float32BufferAttribute(sp, 3));
  const stars = new THREE.Points(starG, new THREE.PointsMaterial({ color: 0xffffff, size: 1.3, sizeAttenuation: false, transparent: true, opacity: 0.55, depthWrite: false }));
  scene.add(stars);

  const SUN = new THREE.Vector3(0.25, 0.75, 0.6).normalize();   // sun roughly behind the viewer: wings face us
  const N = new THREE.Vector3();

  stage.onUpdate((t, dt) => {
    // orbital motion: ground track streams beneath, sky wheels slowly, observatory holds attitude
    earth.rotation.y = t * 0.05;
    stars.rotation.set(0.3, t * 0.01, t * 0.004);
    sc.rotation.set(0.03 * Math.sin(t * 0.17), 0.12 * Math.sin(t * 0.07), 0.05 * Math.sin(t * 0.11));
    sc.updateMatrixWorld(true);
    // solar wings turn about their masts to face the sun
    for (const W of wings) {
      let best = 0, bv = -2;
      for (let k = 0; k < 36; k++) {
        const b = (k / 36) * Math.PI * 2;
        W.drive.rotation.z = b; W.drive.updateMatrixWorld(true);
        N.set(0, 1, 0).transformDirection(W.drive.matrixWorld);
        const v = N.dot(SUN); if (v > bv) { bv = v; best = b; }
      }
      W.drive.rotation.z = best;
    }
    // antennas track a relay satellite
    hga.forEach((g, i) => { g.rotation.set(0.6 * Math.sin(t * 0.21 + i), 0, 0.5 + 0.3 * Math.sin(t * 0.13 + i * 2)); });

    const D = ph.data;
    for (let i = 0; i < NPH; i++) {
      const R = rays[i];
      R.s += dt * 2.2;
      if (R.s > R.L + 0.3) { R.s = 0; R.q = rand(); }
      const fa = Math.floor(99 * smoothstep(0, 0.6, R.s) * (1 - smoothstep(R.L - 0.2, R.L + 0.3, R.s)));
      for (let k = 0; k < KPH; k++) {
        const o = (i * KPH + k) * 4;
        at(R, R.s - k * 0.07, D, o);
        D[o + 3] = fa + R.q * 0.999;
      }
    }
    ph.commit();
  });

  return stage;
}
