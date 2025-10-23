@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-6 px-3">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <!-- Canvas Container -->
            <div id="canvasContainer" class="bg-slate-200 overflow-auto touch-pan-y" style="min-height:70vh;">
                <div class="flex items-center justify-center w-full h-full p-0 md:p-4">
                    <canvas id="pdfCanvas" class="shadow-sm rounded-xl max-w-full h-auto block"
                        style="touch-action: none;"></canvas>
                </div>
            </div>
        </div>

        <!-- Fixed Bottom Controls -->
        <div class="fixed inset-x-0 bottom-0 z-50 pointer-events-none">
            <div class="max-w-5xl mx-auto px-3">
                <div class="pointer-events-auto mb-safe rounded-t-2xl bg-white/95 backdrop-blur-sm border border-slate-200 shadow-lg overflow-hidden"
                    style="margin-bottom: env(safe-area-inset-bottom);">
                    <div class="flex items-center justify-between gap-2 px-3 py-2">
                        <!-- Left: Prev / Next -->
                        <div class="flex items-center gap-2">
                            <button id="prev"
                                class="flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition disabled:opacity-50"
                                aria-label="Previous page" title="Previous">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                <span class="hidden lg:inline text-sm font-medium">{{ __("Prev") }}</span>
                            </button>

                            <div id="pageInfo"
                                class="flex items-center whitespace-nowrap gap-2 px-3 py-2 bg-white rounded-lg text-sm text-slate-700 font-medium border border-slate-200 min-w-[96px] justify-center">
                                {{ __('Page - / -') }}
                            </div>

                            <button id="next"
                                class="flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition disabled:opacity-50"
                                aria-label="Next page" title="Next">
                                <span class="hidden lg:inline text-sm font-medium">{{ __("Next") }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Center: Zoom -->
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-lg px-2 py-1">
                                <select id="zoomSel"
                                    class="appearance-none px-2 py-1 text-sm outline-none bg-transparent cursor-pointer">
                                    <option value="0.5">50%</option>
                                    <option value="0.75">75%</option>
                                    <option value="1" selected>100%</option>
                                    <option value="1.25">125%</option>
                                    <option value="1.5">150%</option>
                                    <option value="2">200%</option>
                                </select>
                                <span id="zoomLabel" class="text-sm text-slate-600 w-12 text-right">100%</span>
                            </div>

                            <input id="zoomRange" type="range" min="50" max="200" step="5" value="100"
                                class="hidden sm:block w-36 h-2 accent-slate-600" aria-label="Zoom slider">
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-2">
                            <button id="rotate" title="{{ __('Rotate') }}"
                                class="flex items-center gap-2 px-3 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="hidden sm:inline text-sm font-medium">{{ __('Rotate') }}</span>
                            </button>

                            <button id="download" title="{{ __('Download PDF') }}"
                                class="flex items-center gap-2 px-2 py-2 bg-green-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span class="hidden sm:inline text-sm font-medium">{{ __('Download') }}</span>
                            </button>

                            <button id="fitToWidth" title="Fit to width"
                                class="flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 3H5a2 2 0 00-2 2v3m0 8v3a2 2 0 002 2h3m8-18h3a2 2 0 012 2v3M8 21h8" />
                                </svg>
                                <span class="hidden sm:inline text-sm font-medium">{{ __("Fit") }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keyboard Shortcuts Help -->
        <div class="mt-6 bg-white rounded-xl shadow-sm p-4">
            <h3 class="font-semibold text-slate-700 mb-2">{{ __('Keyboard Shortcuts') }}</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-slate-600">
                <div class="flex items-center gap-2">
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">←</kbd>
                    <span>{{ __('Previous page') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">→</kbd>
                    <span>{{ __('Next page') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">+</kbd>
                    <span>{{ __('Zoom in') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">-</kbd>
                    <span>{{ __('Zoom out') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PDF.js -->
<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
  const pdfjsLib = window['pdfjsLib'];
  if (!pdfjsLib) { console.error('pdfjsLib not found'); return; }
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.js';

  const canvas = document.getElementById('pdfCanvas');
  const ctx = canvas ? canvas.getContext('2d') : null;
  const prevBtn = document.getElementById('prev');
  const nextBtn = document.getElementById('next');
  const pageInfo = document.getElementById('pageInfo');
  const zoomSel = document.getElementById('zoomSel');
  const rotateBtn = document.getElementById('rotate');
  const downloadBtn = document.getElementById('download');
  const zoomRange = document.getElementById('zoomRange');
  const fitToWidthBtn = document.getElementById('fitToWidth');
  const container = document.getElementById('canvasContainer');

  if (!canvas || !ctx) { console.error('pdfCanvas or its 2D context not found.'); return; }

  // State
  let pdfDoc = null;
  let currentPage = 1;
  let rotation = 0;
  let scale = 1.0;
  if (zoomSel && zoomSel.value) {
    const v = parseFloat(zoomSel.value); if (!isNaN(v)) scale = v;
  }

  function updatePageInfo() {
    if (!pageInfo) return;
    pageInfo.innerHTML = pdfDoc ? `<span class="hidden md:block">{{ __('Page') }}</span> ${currentPage} / ${pdfDoc.numPages}` : '{{ __("Page - / -") }}';
  }

  async function renderPage(pageNum) {
    if (!pdfDoc) return;
    try {
      updatePageInfo();
      const page = await pdfDoc.getPage(pageNum);
      const vp = page.getViewport({ scale: scale, rotation: rotation });
      const dpr = window.devicePixelRatio || 1;
      canvas.width = Math.floor(vp.width * dpr);
      canvas.height = Math.floor(vp.height * dpr);
      canvas.style.width = Math.floor(vp.width) + 'px';
      canvas.style.height = Math.floor(vp.height) + 'px';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      const renderContext = { canvasContext: ctx, viewport: page.getViewport({ scale: scale, rotation: rotation }) };
      await page.render(renderContext).promise;

      // Ensure container scroll positions center the canvas horizontally on small screens
      if (container) {
        // smooth scroll center if page fits smaller width
        const left = (canvas.offsetWidth - container.clientWidth) / 2;
        if (Math.abs(left) > 0) container.scrollTo({ left, behavior: 'smooth' });
      }
    } catch (err) {
      console.error('Error rendering page:', err);
    }
  }

  async function loadPdfFromUrl(url) {
    try {
      const loadingTask = pdfjsLib.getDocument(url);
      pdfDoc = await loadingTask.promise;
      currentPage = 1;
      updatePageInfo();
      await renderPage(currentPage);
      if (downloadBtn) downloadBtn.onclick = () => { window.open(url, '_blank'); };
    } catch (err) {
      console.error('Failed to load PDF:', err);
      alert('{{ __("Failed to load PDF") }}: ' + (err && err.message ? err.message : err));
    }
  }

  // Navigation
  if (prevBtn) prevBtn.addEventListener('click', () => { if (!pdfDoc || currentPage <= 1) return; currentPage--; renderPage(currentPage); });
  if (nextBtn) nextBtn.addEventListener('click', () => { if (!pdfDoc || currentPage >= pdfDoc.numPages) return; currentPage++; renderPage(currentPage); });

  // Zoom select
  if (zoomSel) zoomSel.addEventListener('change', () => {
    const v = parseFloat(zoomSel.value);
    if (!isNaN(v)) { scale = v; if (zoomRange) zoomRange.value = Math.round(scale * 100); const label = document.getElementById('zoomLabel'); if (label) label.textContent = Math.round(scale * 100) + '%'; if (pdfDoc) renderPage(currentPage); }
  });

  // Zoom range
  if (zoomRange) {
    zoomRange.addEventListener('input', () => {
      const v = Number(zoomRange.value) / 100;
      if (!isNaN(v)) {
        scale = v;
        if (zoomSel) zoomSel.value = v.toString();
        const label = document.getElementById('zoomLabel');
        if (label) label.textContent = Math.round(v * 100) + '%';
        if (pdfDoc) renderPage(currentPage);
      }
    });
  }

  // Rotate
  if (rotateBtn) rotateBtn.addEventListener('click', () => { rotation = (rotation + 90) % 360; if (pdfDoc) renderPage(currentPage); });

  // Fit to width
  if (fitToWidthBtn) {
    fitToWidthBtn.addEventListener('click', async () => {
      if (!pdfDoc) return;
      try {
        const page = await pdfDoc.getPage(currentPage);
        const unscaledViewport = page.getViewport({ scale: 1, rotation: rotation });
        const containerWidth = container ? container.clientWidth - 32 : window.innerWidth;
        const targetScale = (containerWidth / unscaledViewport.width);
        scale = Math.max(0.25, Math.min(3, targetScale));
        if (zoomSel) zoomSel.value = scale.toString();
        if (zoomRange) zoomRange.value = Math.round(scale * 100);
        const label = document.getElementById('zoomLabel'); if (label) label.textContent = Math.round(scale * 100) + '%';
        await renderPage(currentPage);
      } catch (err) { console.error('Fit to width error:', err); }
    });
  }

  // Keyboard
  window.addEventListener('keydown', (e) => {
    if (!pdfDoc) return;
    if (e.key === 'ArrowRight') { e.preventDefault(); if (nextBtn) nextBtn.click(); }
    if (e.key === 'ArrowLeft') { e.preventDefault(); if (prevBtn) prevBtn.click(); }
    if (e.key === '+') {
      if (!zoomSel) return;
      const opts = Array.from(zoomSel.options).map(o => parseFloat(o.value));
      const idx = opts.indexOf(scale);
      if (idx < opts.length - 1) { zoomSel.selectedIndex = idx + 1; zoomSel.dispatchEvent(new Event('change')); }
    }
    if (e.key === '-') {
      if (!zoomSel) return;
      const opts = Array.from(zoomSel.options).map(o => parseFloat(o.value));
      const idx = opts.indexOf(scale);
      if (idx > 0) { zoomSel.selectedIndex = idx - 1; zoomSel.dispatchEvent(new Event('change')); }
    }
  });

  // Touch gestures: swipe & pinch-to-zoom
  (function setupTouchGestures() {
    let touchStartX = 0;
    let touchStartY = 0;
    let touchStartTime = 0;
    let isSwiping = false;

    let lastTouchDistance = null;
    let initialScale = scale;

    function getDistance(t1, t2) {
      const dx = t2.clientX - t1.clientX;
      const dy = t2.clientY - t1.clientY;
      return Math.sqrt(dx*dx + dy*dy);
    }

    container.addEventListener('touchstart', function (e) {
      if (!pdfDoc) return;
      touchStartTime = Date.now();
      if (e.touches.length === 1) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
        isSwiping = true;
        lastTouchDistance = null;
      } else if (e.touches.length === 2) {
        // start pinch
        lastTouchDistance = getDistance(e.touches[0], e.touches[1]);
        initialScale = scale;
        isSwiping = false;
      } else {
        isSwiping = false;
      }
    }, { passive: true });

    container.addEventListener('touchmove', function (e) {
      if (!pdfDoc) return;
      if (e.touches.length === 1 && isSwiping) {
        const dx = e.touches[0].clientX - touchStartX;
        const dy = e.touches[0].clientY - touchStartY;

        // If mostly horizontal movement and abs(dx) > 20px, prevent vertical scroll to allow swipe
        if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 10) {
          e.preventDefault(); // prevent page horizontal drift
        }
      } else if (e.touches.length === 2) {
        // pinch handling
        e.preventDefault();
        const dist = getDistance(e.touches[0], e.touches[1]);
        if (lastTouchDistance !== null && lastTouchDistance > 0) {
          const factor = dist / lastTouchDistance;
          let newScale = initialScale * factor;
          // clamp
          newScale = Math.max(0.25, Math.min(3, newScale));
          if (Math.abs(newScale - scale) > 0.01) {
            scale = newScale;
            if (zoomSel) zoomSel.value = scale.toString();
            if (zoomRange) zoomRange.value = Math.round(scale * 100);
            const label = document.getElementById('zoomLabel');
            if (label) label.textContent = Math.round(scale * 100) + '%';
            // live render (throttle by requestAnimationFrame)
            window.requestAnimationFrame(() => renderPage(currentPage));
          }
        }
        lastTouchDistance = dist;
      }
    }, { passive: false });

    container.addEventListener('touchend', function (e) {
      if (!pdfDoc) return;
      const touchDuration = Date.now() - touchStartTime;
      if (isSwiping && e.changedTouches && e.changedTouches.length === 1) {
        const dx = e.changedTouches[0].clientX - touchStartX;
        const dy = e.changedTouches[0].clientY - touchStartY;
        // swipe threshold
        const absDx = Math.abs(dx);
        const absDy = Math.abs(dy);
        if (absDx > 40 && absDx > absDy) {
          if (dx < 0) {
            // left swipe -> next page
            if (nextBtn) nextBtn.click();
          } else {
            // right swipe -> prev page
            if (prevBtn) prevBtn.click();
          }
        }
      }
      // reset
      isSwiping = false;
      lastTouchDistance = null;
      initialScale = scale;
    }, { passive: true });
  })();

  // Load PDF URL from blade Storage helper (ensure valid url string)
  const pdfUrl = `{{ Storage::url($book->file) }}`;
  if (pdfUrl && pdfUrl.length > 0) {
    loadPdfFromUrl(pdfUrl);
  } else {
    console.error('PDF URL is empty: {{ Storage::url($book->file) }}');
  }
});
</script>
@endsection
