// Every homepage design option, in one place. Read by the homepage (to apply them), the preview
// Design switcher and the options directory (to list and explain them). Production ignores all
// URL options and shows the defaults, so this file only describes what previews can do.
(function () {
  'use strict';

  var HEADLINES = {
    where: { name: 'Where', title: 'Where AI learns real engineering', sub: 'High-fidelity reinforcement learning environments and evals, built by industry experts around real engineering workflows.' },
    build: { name: 'Build', title: 'AI learned to write.|Now it learns to build.', sub: 'We build reinforcement-learning environments for physical engineering. Agents design with the tools engineers use, and physics grades the result.' },
    next: { name: 'Next', title: 'Engineering is *next*.', sub: 'We’re teaching AI models to do real engineering, with the tools engineers use and physics as the grader.' },
    real: { name: 'Real', title: 'Training AI to do real engineering.', sub: 'Reinforcement-learning environments built from real design problems. Agents work with CAD, meshers and solvers; physics decides the score.' },
    learn: { name: 'Learn', title: 'Where models learn to engineer.', sub: 'Reinforcement-learning environments for physical engineering: real design problems, the tools engineers use, and physics as the grader.' },
    atoms: { name: 'Atoms', title: 'From bytes|to *atoms*.', sub: 'AI learned to write in bytes. Next it learns to build in atoms, trained on real engineering and checked against physics.' },
    checked: { name: 'Checked', title: 'Models learn what they can be *checked* on.', sub: 'Engineering can be checked. We build the problems, the tools and the physics-based grading that let models learn it.' },
    speed: { name: 'Speed', title: 'The speed of civilization is the speed of its *engineering*.', sub: 'We train AI models on real engineering work, checked against physics, so that speed can go up.' },
  };

  var MACHINES = ['turbine', 'bridge', 'engine', 'telescope', 'pcb', 'rocket', 'exchanger'];

  var AXES = [
    { key: 'theme', label: 'Theme', help: 'Colours, paper and type for the whole page.', def: 'paper', options: [
      { v: 'noir', name: 'Noir', desc: 'Black page, white line work, colour only in the physics.', bg: '#000000' },
      { v: 'graphite', name: 'Graphite', desc: 'Soft charcoal instead of pure black; the same white line work, a little warmer.', bg: '#16171a' },
      { v: 'paper', name: 'Paper', desc: 'Off-white page with the machines drawn in black ink.', bg: '#faf9f5' },
      { v: 'mono', name: 'Mono', desc: 'Pure white and black. Even the physics is greyscale.', bg: '#ffffff' },
      { v: 'journal', name: 'Journal', desc: 'Beige dotted notebook with a serif headline and coloured-pencil physics.', bg: '#efe8d8' },
      { v: 'vellum', name: 'Vellum', desc: 'Cool tracing paper with navy ink, like a drawing office print.', bg: '#eef2f4' },
      { v: 'archive', name: 'Archive', desc: 'Aged cream paper with sepia ink, like a drawing from the 1950s.', bg: '#ede3cc' },
      { v: 'blueprint', name: 'Blueprint', desc: 'Navy drawing sheet with a grid, a border and grid references.', bg: '#0b1d38' },
      { v: 'sketch', name: 'Sketch', desc: 'Engineering pad with a green grid, hand lettering and hand-drawn line edges.', bg: '#f6f5ef' },
    ] },
    { key: 'layout', label: 'Layout', help: 'Where the words and the machine sit. Every layout fits one screen on desktop; phones stack everything.', def: 'side', options: [
      { v: 'side', name: 'Side', desc: 'Words on the left, machine on the right.' },
      { v: 'bleed', name: 'Bleed', desc: 'Words on the left; a larger machine runs off the right edge of the screen.' },
      { v: 'stack', name: 'Stack', desc: 'Machine across the top, header centred underneath.' },
      { v: 'plate', name: 'Plate', desc: 'Header centred on top, machine below, like a museum label.' },
      { v: 'lead', name: 'Lead', desc: 'Headline top left with the text beside it, machine across the full width below.' },
      { v: 'poster', name: 'Poster', desc: 'Machine fills the top; one very large headline across the bottom.' },
      { v: 'split', name: 'Split', desc: 'Text on a panel beside the machine in its own rounded black window.' },
      { v: 'corners', name: 'Corners', desc: 'Machine in the middle, the words pinned to the four corners.' },
    ] },
    { key: 'nav', label: 'Navigation', help: 'The header: the xplore logo, Essay (not yet available) and a Contact button that emails info@xplore.ai.', def: 'bar', options: [
      { v: 'bar', name: 'Bar', desc: 'Logo on the left, Contact on the right.' },
      { v: 'center', name: 'Centred', desc: 'Logo in the middle, Contact on the right.' },
      { v: 'pill', name: 'Pill', desc: 'A floating rounded bar, centred at the top, holding the logo and Contact.' },
      { v: 'rail', name: 'Rail', desc: 'A slim vertical strip down the left edge, set sideways.' },
      { v: 'logo', name: 'Logo only', desc: 'Just the logo. Contact lives in the page’s Get a sample button.' },
    ] },
    { key: 'copy', label: 'Headline', help: 'A written headline and its supporting line. Pick one, or edit the text to write your own.', def: 'where',
      options: Object.keys(HEADLINES).map(function (k) { return { v: k, name: HEADLINES[k].name, desc: '“' + HEADLINES[k].title.replace(/\|/g, ' ').replace(/\*/g, '') + '”' }; })
        .concat([{ v: 'custom', name: 'Custom', desc: 'Your own title and subtitle, from the text fields.' }]) },
    { key: 'reel', label: 'Machines', help: 'Which machines appear in the drawing, and in which set. A single machine just runs, with no transitions.', def: 'all', options: [
      { v: 'all', name: 'All seven', desc: 'Turbofan turbine, Golden Gate, Merlin V12, Hubble, RTX 5090 board, F-1 rocket engine, heat exchanger.' },
      { v: 'aero', name: 'Aerospace', desc: 'Turbofan turbine, Hubble and the F-1 rocket engine.' },
      { v: 'infra', name: 'Industry', desc: 'Golden Gate, Merlin V12, RTX 5090 board and heat exchanger.' },
      { v: 'turbine', name: 'Turbine', desc: 'Only the turbofan turbine, running.' },
      { v: 'engine', name: 'Merlin', desc: 'Only the Rolls-Royce Merlin V12, running.' },
      { v: 'bridge', name: 'Golden Gate', desc: 'Only the Golden Gate Bridge, with traffic and fog.' },
      { v: 'rocket', name: 'F-1', desc: 'Only the F-1, the Saturn V engine, firing.' },
      { v: 'telescope', name: 'Hubble', desc: 'Only the Hubble Space Telescope, in orbit.' },
      { v: 'pcb', name: 'RTX 5090', desc: 'Only the RTX 5090 board, its memory, PCIe and display links lit.' },
    ] },
    { key: 'morph', label: 'Transition', help: 'How one machine turns into the next.', def: 'fly', options: [
      { v: 'fly', name: 'Fly', desc: 'The machine breaks into its edges, which fly across and reassemble as the next machine.' },
      { v: 'draw', name: 'Draw', desc: 'A sweep erases the machine stroke by stroke, then draws the next one in.' },
      { v: 'fade', name: 'Fade', desc: 'A quiet cross-fade: one machine fades out, the next fades in.' },
    ] },
    { key: 'pencil', label: 'Line style', help: 'How the machine’s outlines are drawn. The drawing never flickers in any style.', def: '0', options: [
      { v: '0', name: 'Clean', desc: 'Precise, ruled lines, like CAD.' },
      { v: '1', name: 'Subtle hand', desc: 'Long lines lean very slightly and run a touch past their corners.' },
      { v: '2', name: 'Hand-drawn', desc: 'A more visible hand: longer overshoots and a little more lean, like a quick sketch.' },
    ] },
    { key: 'tempo', label: 'Pace', help: 'How long each machine stays on screen and how quickly the transition runs.', def: 'normal', options: [
      { v: 'calm', name: 'Calm', desc: 'About 8 seconds per machine, slow transitions.' },
      { v: 'normal', name: 'Normal', desc: 'About 5 seconds per machine.' },
      { v: 'brisk', name: 'Brisk', desc: 'About 3.5 seconds per machine, quick transitions.' },
    ] },
  ];

  var REELS = {
    all: MACHINES,
    aero: ['turbine', 'telescope', 'rocket'],
    infra: ['bridge', 'engine', 'pcb', 'exchanger'],
  };
  var TEMPO = { calm: { dwell: 1.5, duration: 3.8 }, normal: { dwell: 1, duration: 3.2 }, brisk: { dwell: 0.65, duration: 2.4 } };

  // defaults a theme brings with it (used when the URL doesn't say)
  var THEME_DEFAULTS = { sketch: { pencil: '2' } };

  function axis(key) { for (var i = 0; i < AXES.length; i++) if (AXES[i].key === key) return AXES[i]; return null; }
  function valid(key, v) { var a = axis(key); if (!a) return false; for (var i = 0; i < a.options.length; i++) if (a.options[i].v === v) return true; return false; }

  /** Resolve a full option set from URL parameters (or any URLSearchParams-like source). */
  function resolve(q) {
    var o = {};
    AXES.forEach(function (a) { var v = q.get(a.key); o[a.key] = valid(a.key, v) ? v : a.def; });
    var td = THEME_DEFAULTS[o.theme] || {};
    Object.keys(td).forEach(function (k) { if (!valid(k, q.get(k))) o[k] = td[k]; });
    o.title = (q.get('h') || '').slice(0, 160);
    o.sub = (q.get('s') || '').slice(0, 320);
    if (o.title || o.sub) o.copy = 'custom';
    return o;
  }

  /** Build a homepage link, leaving out anything that is already the default. */
  function link(o) {
    var q = new URLSearchParams();
    var td = THEME_DEFAULTS[o.theme] || {};
    AXES.forEach(function (a) {
      var v = o[a.key];
      if (a.key === 'copy' && v === 'custom') return;
      var def = td[a.key] !== undefined ? td[a.key] : a.def;
      if (a.key === 'theme' || a.key === 'layout' || v !== def) q.set(a.key, v);
    });
    if (o.copy === 'custom') { if (o.title) q.set('h', o.title); if (o.sub) q.set('s', o.sub); }
    return '/?' + q.toString();
  }

  /** Headline markup: "|" starts the softer second half, *word* is emphasised. Input is escaped. */
  function headlineHTML(text) {
    var esc = String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    var parts = esc.split('|');
    var fmt = function (s) { return s.replace(/\*([^*]+)\*/g, '<em>$1</em>'); };
    return fmt(parts[0]) + (parts.length > 1 ? ' <span class="soft">' + fmt(parts.slice(1).join(' ')) + '</span>' : '');
  }

  window.XV = { AXES: AXES, HEADLINES: HEADLINES, REELS: REELS, TEMPO: TEMPO, MACHINES: MACHINES, THEME_DEFAULTS: THEME_DEFAULTS,
    axis: axis, valid: valid, resolve: resolve, link: link, headlineHTML: headlineHTML };
})();
