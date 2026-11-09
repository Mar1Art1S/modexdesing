// Text selection in the physics gradient. ::selection only takes a flat colour, so the page's own
// selection is made transparent and each selected line gets a bar drawn over it. One gradient runs
// in reading order from where the selection starts (blue) to where it ends (orange), across every
// line, multiplied into the paper so the text keeps its colour. Without this script the
// stylesheet's flat selection colour shows instead.
(function () {
  if (!window.getSelection || !document.createRange) return;

  // the brand's heat (press kit, 2026-10-20), as --xv in site.css
  var GRADIENT = 'linear-gradient(90deg, #0067FF 0%, #0B6EFF 4.2%, #227FFF 8.3%, #3C95FF 12.5%, #57ACFF 16.7%, #6FC0FD 20.8%, #83CFFB 25%, #8CD7FA 29.2%, #8FD7F7 33.3%, #9CD5EB 37.5%, #ADD1D8 41.7%, #BFCDC0 45.8%, #D2C7A5 50%, #E2C188 54.2%, #F0BA6B 58.3%, #FAB551 62.5%, #FFB240 66.7%, #FFB03E 70.8%, #FFA739 75%, #FF9832 79.2%, #FF8628 83.3%, #FF721D 87.5%, #FF5E11 91.7%, #FF4F05 95.8%, #FF4800 100%)';
  // button labels sit on a dark fill and aren't content; they're also unselectable in site.css
  var SKIP = '.btn, .cta';
  var layer = null, queued = false, active = false;

  function textRects(range) {
    var root = range.commonAncestorContainer, out = [];
    var nodes = [];
    if (root.nodeType === 3) nodes.push(root);
    else {
      var walk = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
      while (walk.nextNode()) if (range.intersectsNode(walk.currentNode)) nodes.push(walk.currentNode);
    }
    nodes.forEach(function (n) {
      if (!n.data.trim() || n.parentElement.closest(SKIP)) return;
      var r = document.createRange();
      r.selectNodeContents(n);
      if (n === range.startContainer) r.setStart(n, range.startOffset);
      if (n === range.endContainer) r.setEnd(n, range.endOffset);
      Array.prototype.forEach.call(r.getClientRects(), function (b) {
        if (b.width > 0.5 && b.height > 0.5) out.push({ left: b.left, top: b.top, right: b.right, bottom: b.bottom });
      });
    });
    return out;
  }

  // join pieces that sit on the same line and touch, so each line is one bar
  function merge(rects) {
    var out = [];
    rects.forEach(function (r) {
      var last = out[out.length - 1];
      if (last && Math.abs(last.top - r.top) < 3 && r.left - last.right < 4 && r.left >= last.left) {
        last.right = Math.max(last.right, r.right);
        last.bottom = Math.max(last.bottom, r.bottom);
      } else out.push(r);
    });
    // tight leading (the headline) makes neighbouring lines overlap; split them at the midpoint
    // so no band is tinted twice
    var lines = [];
    out.forEach(function (r) {
      var line = lines[lines.length - 1];
      if (line && Math.abs(line[0].top - r.top) < 3) line.push(r);
      else lines.push([r]);
    });
    for (var i = 1; i < lines.length; i++) {
      var a = lines[i - 1], b = lines[i];
      var aBottom = Math.max.apply(null, a.map(function (r) { return r.bottom; }));
      var bTop = Math.min.apply(null, b.map(function (r) { return r.top; }));
      if (bTop < aBottom) {
        var mid = (aBottom + bTop) / 2;
        a.forEach(function (r) { r.bottom = Math.min(r.bottom, mid); });
        b.forEach(function (r) { r.top = Math.max(r.top, mid); });
      }
    }
    return out;
  }

  function render() {
    queued = false;
    var sel = getSelection();
    var rects = [];
    if (sel.rangeCount && !sel.isCollapsed) {
      for (var i = 0; i < sel.rangeCount; i++) rects = rects.concat(textRects(sel.getRangeAt(i)));
      rects = merge(rects);
    }
    active = rects.length > 0;
    if (!layer) {
      layer = document.createElement('div');
      layer.className = 'sel-layer';
      layer.setAttribute('aria-hidden', 'true');
      document.body.appendChild(layer);
    }
    var total = 0;
    rects.forEach(function (r) { total += r.right - r.left; });
    var html = '', run = 0, sx = window.scrollX, sy = window.scrollY;
    rects.forEach(function (r) {
      var w = r.right - r.left;
      html += '<i style="left:' + (r.left + sx) + 'px;top:' + (r.top + sy) + 'px;width:' + w + 'px;height:' +
        (r.bottom - r.top) + 'px;background-size:' + total + 'px 100%;background-position:' + -run + 'px 0"></i>';
      run += w;
    });
    layer.innerHTML = html;
  }

  function queue() {
    if (!queued) { queued = true; requestAnimationFrame(render); }
  }

  var style = document.createElement('style');
  style.textContent =
    // !important: the light themes set their own selection colour with a stronger selector
    ':root.sel-gradient ::selection{background:transparent!important}' +
    '.sel-layer{position:absolute;top:0;left:0;width:0;height:0;pointer-events:none}' +
    '.sel-layer i{position:absolute;z-index:1000;background-image:' + GRADIENT +
    ';background-repeat:no-repeat;mix-blend-mode:multiply;opacity:.34;border-radius:2px}';
  document.head.appendChild(style);
  document.documentElement.classList.add('sel-gradient');

  document.addEventListener('selectionchange', queue);
  window.addEventListener('resize', function () { if (active) queue(); });
  window.addEventListener('scroll', function () { if (active) queue(); }, { passive: true });
})();
