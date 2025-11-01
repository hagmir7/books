@extends('layouts.base')

@section('content')
<!-- Wrapper sets language and direction for the page -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-4 px-3">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-md md:text-xl lg:text-2xl py-2">{{ str_replace(":attr", $book->name,
            app('site')->site_options['read_book_title']) }}</h1>
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <!-- Canvas Container - Remove RTL from here to let PDF render naturally -->
            <div id="canvasContainer" class="bg-slate-200 overflow-auto touch-pan-y"
                style="min-height:70vh; direction: ltr;">
                <div class="flex items-center justify-center w-full h-full p-0 md:p-4">
                    <!-- Loading Spinner (only for initial load) -->
                    <div id="loadingSpinner"
                        class="absolute inset-0 flex items-center justify-center bg-slate-200 z-10">
                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-12 h-12 border-4 border-violet-200 border-t-violet-600 rounded-full animate-spin">
                            </div>
                            <p class="text-slate-600 text-sm font-medium">{{ __('Loading PDF...') }}</p>
                        </div>
                    </div>
                    <canvas id="pdfCanvas"
                        class="shadow-sm rounded-xl max-w-full h-auto block transition-opacity duration-300"></canvas>
                </div>
            </div>
        </div>

        <!-- Fixed Bottom Controls -->
        <div class="fixed inset-x-0 bottom-0 z-50 pointer-events-none">
            <div class="max-w-5xl mx-auto px-3">
                <div class="pointer-events-auto mb-safe rounded-t-2xl bg-white/95 backdrop-blur-sm border border-slate-200 shadow-lg overflow-hidden"
                    style="margin-bottom: env(safe-area-inset-bottom);">
                    <div class="flex items-center justify-between gap-2 px-3 py-2 overflow-auto">
                        <!-- Left: Prev / Next (visually on the right for RTL) -->
                        <div class="flex items-center gap-2">
                            <button id="prev"
                                class="hidden lg:flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition disabled:opacity-50"
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
                                class=" hidden lg:flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition disabled:opacity-50"
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
                            <div
                                class="inline-flex items-center gap-2 bg-white border border-slate-200 rounded-lg px-2 py-1">
                                <!-- wrap select & icon in label so clicking icon opens select on all browsers -->
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <!-- the select: appearance-none keeps the chevron hidden if you want custom icon.
                                     If you want the native chevron keep 'appearance-auto' -->
                                    <select id="zoomSel" name="zoomSel"
                                        class="appearance-none px-2 py-1 text-sm outline-none bg-transparent cursor-pointer"
                                        aria-label="Zoom">
                                        <option value="0.5">50%</option>
                                        <option value="0.75">75%</option>
                                        <option value="1" selected>100%</option>
                                        <option value="1.25">125%</option>
                                        <option value="1.5">150%</option>
                                        <option value="2">200%</option>
                                    </select>

                                    <!-- desktop label text -->
                                    <span id="zoomLabel"
                                        class="hidden lg:block text-sm text-slate-600 w-12 text-right">100%</span>

                                    <!-- mobile icon (visible only <lg) -->
                                    <span class="lg:hidden inline-flex items-center justify-center w-8 h-8">
                                        <!-- SVG icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <circle cx="11" cy="11" r="7" />
                                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                        </svg>
                                    </span>
                                </label>
                            </div>

                            <input id="zoomRange" type="range" min="50" max="200" step="5" value="100"
                                class="hidden sm:block w-36 h-2 accent-slate-600" aria-label="Zoom slider">
                        </div>

                        <!-- Right: Actions (visually left in RTL) -->
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
                                class="hidden lg:flex items-center gap-2 px-2 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition  ">
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
        <div class="mt-6 bg-white rounded-xl shadow-sm p-4 hidden md:block">
            <h2 class="font-semibold text-slate-700 mb-2">{{ __('Keyboard Shortcuts') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-slate-600">
                <div class="flex items-center gap-2 justify-end">
                    <span>{{ __('Previous page') }}</span>
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">←</kbd>
                </div>
                <div class="flex items-center gap-2 justify-end">
                    <span>{{ __('Next page') }}</span>
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">→</kbd>
                </div>
                <div class="flex items-center gap-2 justify-end">
                    <span>{{ __('Zoom in') }}</span>
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">+</kbd>
                </div>
                <div class="flex items-center gap-2 justify-end">
                    <span>{{ __('Zoom out') }}</span>
                    <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-300">-</kbd>
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
  const loadingSpinner = document.getElementById('loadingSpinner');

  if (!canvas || !ctx) { console.error('pdfCanvas or its 2D context not found.'); return; }

  // Show/hide loading spinner (only for initial load)
  let isInitialLoad = true;

  function showLoading() {
    if (loadingSpinner && isInitialLoad) loadingSpinner.style.display = 'flex';
  }

  function hideLoading() {
    if (loadingSpinner) {
      loadingSpinner.style.display = 'none';
      isInitialLoad = false;
    }
  }

  // Page transition animation
  function fadeOut(callback) {
    canvas.style.opacity = '0';
    setTimeout(callback, 150);
  }

  function fadeIn() {
    setTimeout(() => {
      canvas.style.opacity = '1';
    }, 50);
  }

  // Detect RTL direction from document or html element
  const isRTL = document.documentElement.dir === 'rtl' ||
                document.body.dir === 'rtl' ||
                getComputedStyle(document.documentElement).direction === 'rtl';

  // State
  let pdfDoc = null;
  let currentPage = 1;
  let rotation = 0;
  let scale = 1.0;
  if (zoomSel && zoomSel.value) { const v = parseFloat(zoomSel.value); if (!isNaN(v)) scale = v; }

  function updatePageInfo() {
    if (!pageInfo) return;
    pageInfo.innerHTML = pdfDoc ? `<span class="hidden md:block">{{ __('Page') }}</span> ${currentPage} / ${pdfDoc.numPages}` : '{{ __("Page - / -") }}';
  }

  function goToNextPage() {
    if (!pdfDoc || currentPage >= pdfDoc.numPages) return;
    fadeOut(() => {
      currentPage++;
      renderPage(currentPage);
    });
  }

  function goToPrevPage() {
    if (!pdfDoc || currentPage <= 1) return;
    fadeOut(() => {
      currentPage--;
      renderPage(currentPage);
    });
  }

  async function renderPage(pageNum) {
    if (!pdfDoc) return;
    try {
      if (isInitialLoad) showLoading();
      updatePageInfo();
      const page = await pdfDoc.getPage(pageNum);
      const vp = page.getViewport({ scale: scale, rotation: rotation });
      const dpr = window.devicePixelRatio || 1;
      canvas.width = Math.floor(vp.width * dpr);
      canvas.height = Math.floor(vp.height * dpr);
      canvas.style.width = Math.floor(vp.width) + 'px';
      canvas.style.height = Math.floor(vp.height) + 'px';
      canvas.style.maxWidth = '100%';
      canvas.style.height = 'auto';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      const renderContext = {
        canvasContext: ctx,
        viewport: vp
      };

      await page.render(renderContext).promise;

      // Center canvas in container
      if (container) {
        const offset = (canvas.offsetWidth - container.clientWidth) / 2;
        if (offset > 0) {
          container.scrollTo({ left: Math.round(offset), behavior: 'smooth' });
        } else {
          container.scrollLeft = 0;
        }
      }

      if (isInitialLoad) {
        hideLoading();
      }
      fadeIn();
    } catch (err) {
      console.error('Error rendering page:', err);
      hideLoading();
    }
  }

  async function loadPdfFromUrl(url) {
    try {
      showLoading();
      const loadingTask = pdfjsLib.getDocument({
        url: url,
        cMapUrl: 'https://unpkg.com/pdfjs-dist@3.11.174/cmaps/',
        cMapPacked: true,
        standardFontDataUrl: 'https://unpkg.com/pdfjs-dist@3.11.174/standard_fonts/'
      });
      pdfDoc = await loadingTask.promise;
      currentPage = 1;
      updatePageInfo();
      await renderPage(currentPage);
      if (downloadBtn) downloadBtn.onclick = () => { window.open(url, '_blank'); };
    } catch (err) {
      console.error('Failed to load PDF:', err);
      alert('{{ __("Failed to load PDF") }}: ' + (err && err.message ? err.message : err));
      hideLoading();
    }
  }

  // Navigation - RTL aware
  if (prevBtn) prevBtn.addEventListener('click', goToPrevPage);
  if (nextBtn) nextBtn.addEventListener('click', goToNextPage);

  // Zoom select
  if (zoomSel) zoomSel.addEventListener('change', () => {
    const v = parseFloat(zoomSel.value);
    if (!isNaN(v)) {
      scale = v;
      if (zoomRange) zoomRange.value = Math.round(scale * 100);
      const label = document.getElementById('zoomLabel');
      if (label) label.textContent = Math.round(scale * 100) + '%';
      if (pdfDoc) {
        fadeOut(() => renderPage(currentPage));
      }
    }
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
        if (pdfDoc) {
          fadeOut(() => renderPage(currentPage));
        }
      }
    });
  }

  // Rotate
  if (rotateBtn) rotateBtn.addEventListener('click', () => {
    rotation = (rotation + 90) % 360;
    if (pdfDoc) {
      fadeOut(() => renderPage(currentPage));
    }
  });

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
        const label = document.getElementById('zoomLabel');
        if (label) label.textContent = Math.round(scale * 100) + '%';
        fadeOut(() => renderPage(currentPage));
      } catch (err) { console.error('Fit to width error:', err); }
    });
  }

  // Keyboard - RTL aware
  window.addEventListener('keydown', (e) => {
    if (!pdfDoc) return;

    // For RTL: Right arrow = Previous, Left arrow = Next
    // For LTR: Right arrow = Next, Left arrow = Previous
    if (e.key === 'ArrowRight') {
      e.preventDefault();
      if (isRTL) {
        goToPrevPage();
      } else {
        goToNextPage();
      }
    }
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      if (isRTL) {
        goToNextPage();
      } else {
        goToPrevPage();
      }
    }

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

  // Touch gestures - RTL aware
  (function setupTouchGestures() {
    let touchStartX = 0;
    let touchStartY = 0;
    let touchStartTime = 0;
    let isSwiping = false;
    let isScrolling = false;

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
        isSwiping = false;
        isScrolling = false;
        lastTouchDistance = null;
      } else if (e.touches.length === 2) {
        lastTouchDistance = getDistance(e.touches[0], e.touches[1]);
        initialScale = scale;
        isSwiping = false;
        isScrolling = false;
      }
    }, { passive: true });

    container.addEventListener('touchmove', function (e) {
      if (!pdfDoc) return;
      if (e.touches.length === 1) {
        const dx = e.touches[0].clientX - touchStartX;
        const dy = e.touches[0].clientY - touchStartY;
        const absDx = Math.abs(dx);
        const absDy = Math.abs(dy);

        // Determine direction on first significant movement
        if (!isSwiping && !isScrolling && (absDx > 10 || absDy > 10)) {
          if (absDx > absDy) {
            // Horizontal swipe for page navigation
            isSwiping = true;
            isScrolling = false;
          } else {
            // Vertical movement for scrolling
            isScrolling = true;
            isSwiping = false;
          }
        }

        // Prevent default only for horizontal page swipes
        if (isSwiping && absDx > 10) {
          e.preventDefault();
        }
        // Allow native scrolling for vertical movement
      } else if (e.touches.length === 2) {
        e.preventDefault();
        const dist = getDistance(e.touches[0], e.touches[1]);
        if (lastTouchDistance !== null && lastTouchDistance > 0) {
          const factor = dist / lastTouchDistance;
          let newScale = initialScale * factor;
          newScale = Math.max(0.25, Math.min(3, newScale));
          if (Math.abs(newScale - scale) > 0.01) {
            scale = newScale;
            if (zoomSel) zoomSel.value = scale.toString();
            if (zoomRange) zoomRange.value = Math.round(scale * 100);
            const label = document.getElementById('zoomLabel');
            if (label) label.textContent = Math.round(scale * 100) + '%';
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
        const absDx = Math.abs(dx);
        const absDy = Math.abs(dy);

        // Only trigger page change if horizontal swipe is dominant
        if (absDx > 50 && absDx > absDy * 1.5) {
          // For RTL: Swipe left = Next, Swipe right = Previous
          // For LTR: Swipe left = Previous, Swipe right = Next
          if (dx < 0) { // Swipe left
            if (isRTL) {
              goToNextPage();
            } else {
              goToPrevPage();
            }
          } else { // Swipe right
            if (isRTL) {
              goToPrevPage();
            } else {
              goToNextPage();
            }
          }
        }
      }
      isSwiping = false;
      isScrolling = false;
      lastTouchDistance = null;
      initialScale = scale;
    }, { passive: true });
  })();

  // Load PDF URL from blade Storage helper
  const pdfUrl = `{{ Storage::url($book->file) }}`;
  if (pdfUrl && pdfUrl.length > 0) {
    loadPdfFromUrl(pdfUrl);
  } else {
    console.error('PDF URL is empty: {{ Storage::url($book->file) }}');
  }


(function () {
const sel = document.getElementById('zoomSel');

// If browser supports showPicker (Chromium), it's best UX:
function openSelect() {
if (!sel) return;
if (typeof sel.showPicker === 'function') {
try {
sel.showPicker();
return;
} catch (e) {
// fallthrough to synthetic events
console.warn('showPicker error', e);
}
}

// Focus and try synthetic events (fallback)
sel.focus();

try {
sel.dispatchEvent(new MouseEvent('mousedown', { bubbles: true, cancelable: true, view: window }));
sel.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true, view: window }));
} catch (err) {
// final fallback: key event
try {
sel.dispatchEvent(new KeyboardEvent('keydown', { key: 'ArrowDown', bubbles: true, cancelable: true }));
} catch (e) {
console.warn('Could not open select programmatically', e);
}
}
}

// Attach to the label wrapper so clicks on icon/text open
// Label wrapping means native click will already target <select>, but keep defensive handler:
    const wrapperLabel = sel.closest('label');
    if (wrapperLabel) {
    wrapperLabel.addEventListener('click', function (ev) {
    // If user clicked directly on select, let native behavior happen
    if (ev.target === sel) return;
    // prevent double-handling in some browsers
    ev.preventDefault();
    openSelect();
    });
    }
    })();


});
</script>
@endsection
