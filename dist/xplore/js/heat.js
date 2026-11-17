// Heat on the dark buttons: the cursor is a hot tip held at a fixed temperature (T = 1) and the
// button face is a thin plate around it. Explicit finite differences on a coarse grid, coloured
// with the brand's heat gradient.
//
//   dT/dt = a * lap(T) - b * T,   with T = 1 under the cursor
//
// Edges (previews can compare them with ?wall=):
// - adiabatic (default): insulated edges and no face loss while the cursor is in, so the whole
//   button slowly comes up to the tip's temperature.
// - sink: edges held at ambient (T = 0), so a steady gradient forms between tip and edges.
// - robin: edges and face both shed heat to the air, so the glow stays local to the cursor.
// Once the cursor leaves, the face cools to the air (b > 0) in every mode, or the button would
// stay hot for good.
//
// Only dark-filled buttons get it (the homepage's See the benchmark, the thesis's Get a sample, the nav's Contact), so the label stays light
// over the colour.
(function () {
  if (!window.matchMedia || matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  // the brand's heat (press kit, 2026-10-20), sampled evenly: pressed blue, holds, load, yields
  var STOPS = [[0, 103, 255], [34, 127, 255], [87, 172, 255], [131, 207, 251], [143, 215, 247], [173, 209, 216], [210, 199, 165], [240, 186, 107], [255, 178, 64], [255, 167, 57], [255, 134, 40], [255, 94, 17], [255, 72, 0]];
  var CELL = 3;          // px per grid cell
  var RATE = 480;        // solver steps per second, whatever the display's refresh rate
  var A = 0.2;           // conduction, cells^2 per step (explicit limit is 0.25)
  var B = A / 100;       // face loss to the air: fin length sqrt(A / B) = 10 cells, 30 px
  var SIGMA = 1.6;       // tip radius in cells

  var wall = 'adiabatic';
  if (location.hostname !== 'xplore.ai') {
    var w = new URLSearchParams(location.search).get('wall');
    if (w === 'sink' || w === 'adiabatic' || w === 'robin') wall = w;
  }
  // ghost cell beyond each edge = edge cell * G: 1 mirrors it (no flux), -1 pins the wall face at 0,
  // 0.5 is a convective edge (Biot 0.5)
  var G = wall === 'sink' ? -1 : wall === 'adiabatic' ? 1 : 0.5;

  function luminance(css) {
    var m = css.match(/[\d.]+/g);
    if (!m || (m.length > 3 && +m[3] === 0)) return null;
    return (0.2126 * m[0] + 0.7152 * m[1] + 0.0722 * m[2]) / 255;
  }

  function ramp(t, out) {
    var f = Math.min(0.9999, Math.max(0, t)) * (STOPS.length - 1), i = f | 0, k = f - i, a = STOPS[i], b = STOPS[i + 1];
    out[0] = a[0] + (b[0] - a[0]) * k;
    out[1] = a[1] + (b[1] - a[1]) * k;
    out[2] = a[2] + (b[2] - a[2]) * k;
  }

  function attach(btn) {
    var fill = luminance(getComputedStyle(btn).backgroundColor);
    if (fill === null || fill > 0.35) return;

    var canvas = document.createElement('canvas');
    canvas.className = 'heat';
    canvas.setAttribute('aria-hidden', 'true');
    btn.prepend(canvas);
    btn.classList.add('has-heat');
    var ctx = canvas.getContext('2d');

    var nx, ny, T, N, img, rgb = [0, 0, 0];
    var inside = false, px = 0, py = 0, lx = 0, ly = 0, running = false, last = 0, debt = 0;

    function size() {
      var r = btn.getBoundingClientRect();
      nx = Math.max(8, Math.round(r.width / CELL));
      ny = Math.max(4, Math.round(r.height / CELL));
      canvas.width = nx; canvas.height = ny;
      T = new Float32Array(nx * ny);
      N = new Float32Array(nx * ny);
      img = ctx.createImageData(nx, ny);
    }

    // hold the tip at T = 1, blending softly over its radius
    function tip(cx, cy) {
      var R = Math.ceil(SIGMA * 2.5), inv = 1 / (2 * SIGMA * SIGMA);
      var x0 = Math.max(0, Math.floor(cx - R)), x1 = Math.min(nx - 1, Math.ceil(cx + R));
      var y0 = Math.max(0, Math.floor(cy - R)), y1 = Math.min(ny - 1, Math.ceil(cy + R));
      for (var y = y0; y <= y1; y++) for (var x = x0; x <= x1; x++) {
        var dx = x - cx, dy = y - cy, k = Math.exp(-(dx * dx + dy * dy) * inv), i = y * nx + x;
        T[i] += (1 - T[i]) * k;
      }
    }

    function step(b) {
      for (var y = 0; y < ny; y++) {
        for (var x = 0; x < nx; x++) {
          var i = y * nx + x, c = T[i];
          var l = x > 0 ? T[i - 1] : c * G;
          var r = x < nx - 1 ? T[i + 1] : c * G;
          var u = y > 0 ? T[i - nx] : c * G;
          var d = y < ny - 1 ? T[i + nx] : c * G;
          N[i] = c + A * (l + r + u + d - 4 * c) - b * c;
        }
      }
      var s = T; T = N; N = s;
    }

    function draw() {
      var data = img.data, peak = 0;
      for (var i = 0, n = nx * ny; i < n; i++) {
        var t = T[i];
        if (t > peak) peak = t;
        ramp(t, rgb);
        var a = t <= 0.02 ? 0 : t >= 0.32 ? 1 : (t - 0.02) / 0.3;
        var o = i * 4;
        data[o] = rgb[0]; data[o + 1] = rgb[1]; data[o + 2] = rgb[2];
        data[o + 3] = a * a * (3 - 2 * a) * 153;    // 60 %: the ink shows through, keeping the light label at 3.6:1 or better over the pale middle of the heat
      }
      ctx.putImageData(img, 0, 0);
      return peak;
    }

    function frame(now) {
      debt = Math.min(debt + (now - last) * RATE / 1000, 48);
      last = now;
      var n = debt | 0;
      debt -= n;
      // face loss: always for robin; otherwise only once the cursor has left
      var b = wall === 'robin' || !inside ? B : 0;
      for (var s = 1; s <= n; s++) {
        if (inside) tip(lx + (px - lx) * s / n, ly + (py - ly) * s / n);
        step(b);
      }
      if (n) { lx = px; ly = py; }
      var peak = draw();
      if (inside || peak > 0.004) requestAnimationFrame(frame);
      else { running = false; T.fill(0); draw(); }
    }

    function locate(e) {
      var r = btn.getBoundingClientRect();
      px = (e.clientX - r.left) / r.width * nx;
      py = (e.clientY - r.top) / r.height * ny;
    }

    btn.addEventListener('pointerenter', function (e) {
      if (e.pointerType === 'touch') return;
      if (!T || canvas.width !== Math.max(8, Math.round(btn.getBoundingClientRect().width / CELL))) size();
      locate(e); lx = px; ly = py; inside = true;
      if (!running) { running = true; last = performance.now(); debt = 0; requestAnimationFrame(frame); }
    });
    btn.addEventListener('pointermove', function (e) { if (inside) locate(e); });
    btn.addEventListener('pointerleave', function () { inside = false; });
  }

  function init() { document.querySelectorAll('.btn.solid, nav .cta').forEach(attach); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
