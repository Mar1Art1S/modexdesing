// The machine reel on the homepage: just the drawing, no captions or controls.
// Options:
//   pencil    0 clean · 1 subtle hand · 2 hand-drawn (see enableSketch in visuals/core.js)
//   morph     'fly' edges fly between machines · 'draw' erase and redraw · 'fade' cross-fade
//   machines  names to show, in order (one name = that machine alone, no transitions)
//   tempo     { dwell, duration }: screen-time multiplier and seconds per transition
//   chaos     0..1, how wild the flying edges are (1 = full bloom and swirl, 0 = a straight glide)
import { canUseWebGL, reveal } from './stage.js';

const PENCIL = { 1: { wobble: 0.5, overshoot: 2 }, 2: { wobble: 0.8, overshoot: 3 } };

// The drawing's look, chosen in the reel lab (2026-10-23): a calmer transition, the brand's heat scale (press kit,
// 2026-10-20: pressed blue, holds, load, yields) favouring the hot end, lighter softer lines, sky-blue section
// hatching, the Merlin's front piston and cylinder cut away. Colours are written as they should look on screen.
const LOOK = {
  chaos: 0.6,
  palette: ['#0067ff', '#3c95ff', '#83cffb', '#9cd5eb', '#d2c7a5', '#fab551', '#ffa739', '#ff721d', '#ff4800'],
  map: { lo: 0, hi: 1, gamma: 1.6 },
  line: { width: 0.85, ink: 0.75 },
  hatch: { color: '#9fcdee', opacity: 0.8 },
  cut: { merlin: 'piston+cylinder' },
};
// Light themes show the canvas through invert(1) hue-rotate(180deg): hand the visuals the colour that comes out as intended
const rgb = (h) => [1, 3, 5].map((i) => parseInt(h.slice(i, i + 2), 16) / 255);
const hex = (c) => '#' + c.map((v) => Math.round(Math.min(1, Math.max(0, v)) * 255).toString(16).padStart(2, '0')).join('');
const hue180 = ([r, g, b]) => [-0.574 * r + 1.43 * g + 0.144 * b, 0.426 * r + 0.43 * g + 0.144 * b, 0.426 * r + 1.43 * g - 0.856 * b];
const throughInvert = (h) => hex(hue180(rgb(h)).map((v) => 1 - v));

function applyLook(el) {
  const filter = getComputedStyle(el).getPropertyValue('--canvas-filter');
  const c = /invert\(1\)/.test(filter) && /hue-rotate\(180deg\)/.test(filter) ? throughInvert : (h) => h;
  const g = globalThis;                                           // a page that set its own look keeps it
  g.XV_PALETTE ??= LOOK.palette.map(c);
  g.XV_PALETTE_MAP ??= LOOK.map;
  g.XV_LINE ??= LOOK.line;
  g.XV_HATCH ??= { ...LOOK.hatch, color: c(LOOK.hatch.color) };
  g.XV_CUT ??= LOOK.cut;
}

export async function mountReel(el, { pencil = 0, morph = 'fly', machines, tempo, chaos, onChange } = {}) {
  if (!el || !canUseWebGL()) return null;
  applyLook(el);                                                  // before the visuals load: they read it once
  if (PENCIL[pencil]) (await import('./visuals/core.js')).enableSketch(PENCIL[pencil]);
  const { mountMorph } = await import('./visuals/morph.js');
  const stage = mountMorph(el, {
    style: morph,
    machines,
    dwellScale: tempo?.dwell,
    duration: tempo?.duration,
    chaos: chaos ?? LOOK.chaos,
    controls: false,
    parallax: 0, onChange,   // the drawing holds still under the pointer
  });
  reveal(el, stage);
  return stage;
}
