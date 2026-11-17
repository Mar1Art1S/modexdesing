// Shared helpers for pages that host a WebGL visual.

export function canUseWebGL() {
  try {
    const c = document.createElement('canvas');
    return !!(window.WebGL2RenderingContext && c.getContext('webgl2'));
  } catch {
    return false;
  }
}

// Fade the canvas in once the scene has built (and, for the reel, every machine has loaded), and only once
// frames are coming steadily: the first renders still upload geometry, and a fade that starts during those
// hitches looks like a pop. Waits for 6 frames in a row under 34 ms, or 1.2 s at most.
export function reveal(el, stage) {
  const show = () => {
    const t0 = performance.now();
    let last = t0, run = 0;
    const tick = (now) => {
      run = now - last < 34 ? run + 1 : 0;
      last = now;
      if (run >= 6 || now - t0 > 1200) el.classList.add('is-live');
      else requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };
  Promise.resolve(stage.ready).then(show, show);
}
