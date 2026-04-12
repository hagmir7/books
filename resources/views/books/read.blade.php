@extends('layouts.base')

{{-- @section('seo')
<meta name="description"
    content="{{ str_replace(':attr', $book->name, app('site')->site_options['read_book_description'] ?? 'Read ' . $book->name . ' online') }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:title"
    content="{{ str_replace(':attr', $book->name, app('site')->site_options['read_book_title']) }}">
<meta property="og:type" content="book">
<meta property="og:url" content="{{ url()->current() }}">
@if(!empty($book->cover))
<meta property="og:image" content="{{ Storage::url($book->cover) }}">
@endif
<script type="application/ld+json">
    {
  "@context": "https://schema.org",
  "@type": "Book",
  "name": "{{ addslashes($book->name) }}",
  "url": "{{ url()->current() }}"
}
</script>
@endsection --}}

@section('content')
<main class="pdf-reader" id="pdfReaderApp">
    {!! app("site")->ads !!}

    <!-- Header -->
    <header class="pdf-reader__header">
        <div class="pdf-reader__header-inner">
            <h1 class="pdf-reader__title" title="{{ $book->name }}">
                {{ str_replace(':attr', $book->name, app('site')->site_options['read_book_title']) }}
            </h1>
            <div class="pdf-reader__header-actions">
                <button id="toggleFullscreen" class="btn btn--ghost btn--icon" title="{{ __('Fullscreen') }}"
                    aria-label="{{ __('Toggle fullscreen') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Canvas Viewport -->
    <div id="canvasContainer" class="pdf-reader__viewport" role="document" aria-label="{{ __('PDF Document') }}"
        tabindex="0">
        <!-- Loading State -->
        <div id="loadingOverlay" class="pdf-reader__loading" aria-live="polite">
            <div class="pdf-reader__loading-spinner">
                <svg class="spinner-ring" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20" fill="none" stroke-width="4" stroke="currentColor" opacity="0.15" />
                    <circle cx="24" cy="24" r="20" fill="none" stroke-width="4" stroke="currentColor"
                        stroke-dasharray="80 50" stroke-linecap="round" class="spinner-arc" />
                </svg>
            </div>
            <p class="pdf-reader__loading-text">{{ __('Loading PDF...') }}</p>
        </div>

        <!-- Error State -->
        <div id="errorOverlay" class="pdf-reader__error" style="display:none;" role="alert">
            <svg class="icon icon--lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v4m0 4h.01" />
            </svg>
            <p id="errorMessage" class="pdf-reader__error-text">{{ __('Failed to load PDF') }}</p>
            <button id="retryBtn" class="btn btn--primary">{{ __('Retry') }}</button>
        </div>

        <!-- Canvas -->
        <canvas id="pdfCanvas" class="pdf-reader__canvas" aria-label="{{ __('PDF page content') }}"></canvas>
    </div>

    {!! app("site")->ads !!}

    <!-- Mobile Page Navigation (swipe hint on first load) -->
    <div id="swipeHint" class="pdf-reader__swipe-hint" aria-hidden="true">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 4l-4 4 4 4" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M10 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round" transform="translate(8,0)" />
        </svg>
        <span>{{ __('Swipe to change pages') }}</span>
    </div>

    <!-- Bottom Toolbar -->
    <nav class="pdf-reader__toolbar" role="toolbar" aria-label="{{ __('PDF Controls') }}">
        <div class="pdf-reader__toolbar-inner">

            <!-- Page Navigation -->
            <div class="toolbar-group toolbar-group--nav">
                <button id="prevBtn" class="btn btn--tool" disabled title="{{ __('Previous page') }}"
                    aria-label="{{ __('Previous page') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>

                <div class="page-indicator" role="status" aria-live="polite">
                    <input id="pageInput" type="number" class="page-indicator__input" value="1" min="1"
                        aria-label="{{ __('Current page') }}">
                    <span class="page-indicator__sep">/</span>
                    <span id="totalPages" class="page-indicator__total">-</span>
                </div>

                <button id="nextBtn" class="btn btn--tool" disabled title="{{ __('Next page') }}"
                    aria-label="{{ __('Next page') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>

            <!-- Zoom Controls -->
            <div class="toolbar-group toolbar-group--zoom">
                <button id="zoomOut" class="btn btn--tool" title="{{ __('Zoom out') }}"
                    aria-label="{{ __('Zoom out') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.35-4.35" />
                        <path d="M8 11h6" />
                    </svg>
                </button>

                <input id="zoomRange" type="range" min="25" max="300" step="5" value="100" class="zoom-slider"
                    aria-label="{{ __('Zoom level') }}">

                <span id="zoomLabel" class="zoom-label">100%</span>

                <button id="zoomIn" class="btn btn--tool" title="{{ __('Zoom in') }}" aria-label="{{ __('Zoom in') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.35-4.35" />
                        <path d="M11 8v6m-3-3h6" />
                    </svg>
                </button>

                <button id="fitWidth" class="btn btn--tool btn--hide-mobile" title="{{ __('Fit to width') }}"
                    aria-label="{{ __('Fit to width') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10H3m18 4H3m15-8l3 4-3 4M6 6L3 10l3 4" />
                    </svg>
                </button>
            </div>

            <!-- Actions -->
            <div class="toolbar-group toolbar-group--actions">
                <button id="rotateBtn" class="btn btn--tool" title="{{ __('Rotate') }}"
                    aria-label="{{ __('Rotate page') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 4v6h6" />
                        <path d="M3.51 15a9 9 0 102.13-9.36L1 10" />
                    </svg>
                </button>

                <button id="downloadBtn" class="btn btn--accent" title="{{ __('Download PDF') }}"
                    aria-label="{{ __('Download PDF') }}">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    <span class="btn__label">{{ __('Download') }}</span>
                </button>
            </div>
        </div>

        <!-- Progress bar -->
        <div class="pdf-reader__progress" aria-hidden="true">
            <div id="progressBar" class="pdf-reader__progress-bar" style="width:0%"></div>
        </div>
    </nav>

    <!-- Keyboard Shortcuts Panel (hidden by default, toggled) -->
    <aside id="shortcutsPanel" class="pdf-reader__shortcuts" style="display:none" role="complementary"
        aria-label="{{ __('Keyboard Shortcuts') }}">
        <div class="shortcuts-grid">
            <h2 class="shortcuts-title">{{ __('Keyboard Shortcuts') }}</h2>
            <div class="shortcut"><kbd>←</kbd><span>{{ __('Previous page') }}</span></div>
            <div class="shortcut"><kbd>→</kbd><span>{{ __('Next page') }}</span></div>
            <div class="shortcut"><kbd>+</kbd><span>{{ __('Zoom in') }}</span></div>
            <div class="shortcut"><kbd>−</kbd><span>{{ __('Zoom out') }}</span></div>
            <div class="shortcut"><kbd>R</kbd><span>{{ __('Rotate') }}</span></div>
            <div class="shortcut"><kbd>F</kbd><span>{{ __('Fit to width') }}</span></div>
            <div class="shortcut"><kbd>Home</kbd><span>{{ __('First page') }}</span></div>
            <div class="shortcut"><kbd>End</kbd><span>{{ __('Last page') }}</span></div>
            <div class="shortcut"><kbd>?</kbd><span>{{ __('Toggle shortcuts') }}</span></div>
        </div>
    </aside>
</main>

<style>
    /* ── Design tokens ── */
    :root {
        --reader-bg: #f0f0f0;
        --reader-surface: #ffffff;
        --reader-text: #1a1a2e;
        --reader-text-muted: #6b7280;
        --reader-border: #e2e5ea;
        --reader-accent: #4338ca;
        --reader-accent-hover: #3730a3;
        --reader-accent-soft: #eef2ff;
        --reader-success: #059669;
        --reader-toolbar-bg: rgba(255, 255, 255, 0.97);
        --reader-toolbar-shadow: 0 -1px 12px rgba(0, 0, 0, 0.08);
        --reader-radius: 12px;
        --reader-radius-sm: 8px;
        --reader-font: 'Segoe UI', system-ui, -apple-system, sans-serif;
        --toolbar-h: 56px;
        --header-h: 48px;
        --safe-bottom: env(safe-area-inset-bottom, 0px);
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --reader-bg: #111118;
            --reader-surface: #1c1c27;
            --reader-text: #e8e8ed;
            --reader-text-muted: #9ca3af;
            --reader-border: #2d2d3a;
            --reader-accent: #6366f1;
            --reader-accent-hover: #818cf8;
            --reader-accent-soft: #1e1b4b;
            --reader-toolbar-bg: rgba(28, 28, 39, 0.97);
            --reader-toolbar-shadow: 0 -1px 12px rgba(0, 0, 0, 0.3);
        }
    }

    /* ── Reset ── */
    .pdf-reader *,
    .pdf-reader *::before,
    .pdf-reader *::after {
        box-sizing: border-box;
    }

    /* ── Layout ── */
    .pdf-reader {
        font-family: var(--reader-font);
        color: var(--reader-text);
        background: var(--reader-bg);
        min-height: 100vh;
        min-height: 100dvh;
        display: flex;
        flex-direction: column;
    }

    /* ── Header ── */
    .pdf-reader__header {
        position: sticky;
        top: 0;
        z-index: 40;
        background: var(--reader-toolbar-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--reader-border);
        height: var(--header-h);
        flex-shrink: 0;
    }

    .pdf-reader__header-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .pdf-reader__title {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
    }

    /* ── Viewport ── */
    .pdf-reader__viewport {
        flex: 1;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        position: relative;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 16px 8px calc(var(--toolbar-h) + var(--safe-bottom) + 24px);
        direction: ltr;
        /* PDF canvas always LTR */
        outline: none;
    }

    .pdf-reader__canvas {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.04);
        transition: opacity 0.18s ease;
        background: white;
    }

    /* ── Loading ── */
    .pdf-reader__loading {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        background: var(--reader-bg);
        z-index: 10;
    }

    .pdf-reader__loading-spinner {
        width: 48px;
        height: 48px;
        color: var(--reader-accent);
    }

    .spinner-ring {
        display: block;
    }

    .spinner-arc {
        animation: spin 1s linear infinite;
        transform-origin: center;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .pdf-reader__loading-text {
        font-size: 14px;
        color: var(--reader-text-muted);
        margin: 0;
    }

    /* ── Error ── */
    .pdf-reader__error {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: var(--reader-bg);
        z-index: 10;
        color: var(--reader-text-muted);
    }

    .pdf-reader__error-text {
        font-size: 14px;
        margin: 0;
    }

    /* ── Swipe hint ── */
    .pdf-reader__swipe-hint {
        position: fixed;
        bottom: calc(var(--toolbar-h) + var(--safe-bottom) + 16px);
        left: 50%;
        transform: translateX(-50%);
        display: none;
        /* shown via JS on mobile */
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        border-radius: 999px;
        font-size: 13px;
        z-index: 45;
        animation: fadeHint 3s ease forwards;
        pointer-events: none;
    }

    @keyframes fadeHint {

        0%,
        70% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            display: none;
        }
    }

    /* ── Toolbar ── */
    .pdf-reader__toolbar {
        position: fixed;
        inset-inline: 0;
        bottom: 0;
        z-index: 50;
        background: var(--reader-toolbar-bg);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-top: 1px solid var(--reader-border);
        box-shadow: var(--reader-toolbar-shadow);
        padding-bottom: var(--safe-bottom);
    }

    .pdf-reader__toolbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        height: var(--toolbar-h);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        padding: 0 10px;
    }

    /* ── Progress bar ── */
    .pdf-reader__progress {
        position: absolute;
        top: 0;
        inset-inline: 0;
        height: 3px;
        background: transparent;
    }

    .pdf-reader__progress-bar {
        height: 100%;
        background: var(--reader-accent);
        border-radius: 0 3px 3px 0;
        transition: width 0.25s ease;
    }

    /* ── Toolbar groups ── */
    .toolbar-group {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .toolbar-group--zoom {
        gap: 6px;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        line-height: 1;
        transition: all 0.15s ease;
        white-space: nowrap;
        -webkit-tap-highlight-color: transparent;
        user-select: none;
    }

    .btn:disabled {
        opacity: 0.35;
        pointer-events: none;
    }

    .btn--tool {
        width: 38px;
        height: 38px;
        border-radius: var(--reader-radius-sm);
        background: transparent;
        color: var(--reader-text);
    }

    .btn--tool:hover {
        background: var(--reader-accent-soft);
        color: var(--reader-accent);
    }

    .btn--tool:active {
        transform: scale(0.92);
    }

    .btn--ghost {
        background: transparent;
        color: var(--reader-text-muted);
        padding: 6px;
        border-radius: var(--reader-radius-sm);
    }

    .btn--ghost:hover {
        color: var(--reader-text);
        background: var(--reader-accent-soft);
    }

    .btn--icon {
        width: 36px;
        height: 36px;
    }

    .btn--primary {
        background: var(--reader-accent);
        color: #fff;
        padding: 8px 20px;
        border-radius: var(--reader-radius-sm);
    }

    .btn--primary:hover {
        background: var(--reader-accent-hover);
    }

    .btn--accent {
        background: var(--reader-accent);
        color: #fff;
        padding: 0 14px;
        height: 38px;
        border-radius: var(--reader-radius-sm);
    }

    .btn--accent:hover {
        background: var(--reader-accent-hover);
    }

    .btn--accent:active {
        transform: scale(0.96);
    }

    .btn__label {
        display: none;
    }

    /* ── Icons ── */
    .icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .icon--lg {
        width: 36px;
        height: 36px;
    }

    /* ── Page indicator ── */
    .page-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        font-weight: 500;
        color: var(--reader-text);
        background: var(--reader-surface);
        border: 1px solid var(--reader-border);
        border-radius: var(--reader-radius-sm);
        padding: 0 10px;
        height: 38px;
    }

    .page-indicator__input {
        width: 32px;
        text-align: center;
        border: none;
        background: transparent;
        font: inherit;
        color: inherit;
        outline: none;
        -moz-appearance: textfield;
    }

    .page-indicator__input::-webkit-inner-spin-button,
    .page-indicator__input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .page-indicator__input:focus {
        background: var(--reader-accent-soft);
        border-radius: 4px;
    }

    .page-indicator__sep {
        color: var(--reader-text-muted);
    }

    .page-indicator__total {
        color: var(--reader-text-muted);
    }

    /* ── Zoom slider ── */
    .zoom-slider {
        -webkit-appearance: none;
        appearance: none;
        width: 80px;
        height: 4px;
        border-radius: 4px;
        background: var(--reader-border);
        outline: none;
    }

    .zoom-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--reader-accent);
        cursor: pointer;
        border: 2px solid var(--reader-surface);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
    }

    .zoom-slider::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--reader-accent);
        cursor: pointer;
        border: 2px solid var(--reader-surface);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
    }

    .zoom-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--reader-text-muted);
        min-width: 36px;
        text-align: center;
    }

    /* ── Shortcuts panel ── */
    .pdf-reader__shortcuts {
        position: fixed;
        bottom: calc(var(--toolbar-h) + var(--safe-bottom) + 8px);
        inset-inline-end: 16px;
        z-index: 55;
        background: var(--reader-surface);
        border: 1px solid var(--reader-border);
        border-radius: var(--reader-radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        padding: 16px 20px;
        max-width: 320px;
    }

    .shortcuts-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--reader-text-muted);
        margin: 0 0 10px;
    }

    .shortcuts-grid {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .shortcut {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--reader-text);
    }

    .shortcut kbd {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        padding: 2px 8px;
        font-size: 12px;
        font-family: inherit;
        font-weight: 600;
        background: var(--reader-bg);
        border: 1px solid var(--reader-border);
        border-radius: 6px;
        color: var(--reader-text-muted);
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .pdf-reader__viewport {
            padding: 8px 4px calc(var(--toolbar-h) + var(--safe-bottom) + 16px);
        }

        .btn--hide-mobile {
            display: none !important;
        }

        .toolbar-group--zoom .zoom-slider {
            width: 56px;
        }

        .toolbar-group--zoom .zoom-label {
            display: none;
        }

        .pdf-reader__title {
            font-size: 13px;
        }
    }

    @media (min-width: 641px) {
        .btn__label {
            display: inline;
        }

        .zoom-slider {
            width: 100px;
        }
    }

    @media (min-width: 1024px) {
        .pdf-reader__viewport {
            padding: 24px 16px calc(var(--toolbar-h) + var(--safe-bottom) + 32px);
        }

        .zoom-slider {
            width: 120px;
        }
    }

    /* ── Print ── */
    @media print {

        .pdf-reader__toolbar,
        .pdf-reader__header,
        .pdf-reader__shortcuts {
            display: none !important;
        }

        .pdf-reader__viewport {
            padding: 0;
        }
    }
</style>

<!-- PDF.js -->
<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
  /* ── PDF.js init ── */
  const pdfjsLib = window['pdfjsLib'];
  if (!pdfjsLib) { console.error('pdfjsLib not loaded'); return; }
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.js';

  /* ── DOM refs ── */
  const canvas        = document.getElementById('pdfCanvas');
  const ctx           = canvas.getContext('2d');
  const container     = document.getElementById('canvasContainer');
  const loadingEl     = document.getElementById('loadingOverlay');
  const errorEl       = document.getElementById('errorOverlay');
  const errorMsg      = document.getElementById('errorMessage');
  const retryBtn      = document.getElementById('retryBtn');
  const prevBtn       = document.getElementById('prevBtn');
  const nextBtn       = document.getElementById('nextBtn');
  const pageInput     = document.getElementById('pageInput');
  const totalPagesEl  = document.getElementById('totalPages');
  const zoomRange     = document.getElementById('zoomRange');
  const zoomLabel     = document.getElementById('zoomLabel');
  const zoomInBtn     = document.getElementById('zoomIn');
  const zoomOutBtn    = document.getElementById('zoomOut');
  const fitWidthBtn   = document.getElementById('fitWidth');
  const rotateBtn     = document.getElementById('rotateBtn');
  const downloadBtn   = document.getElementById('downloadBtn');
  const fullscreenBtn = document.getElementById('toggleFullscreen');
  const progressBar   = document.getElementById('progressBar');
  const swipeHint     = document.getElementById('swipeHint');
  const shortcutsEl   = document.getElementById('shortcutsPanel');

  /* ── Direction detection ── */
  const htmlDir = document.documentElement.dir || '';
  const bodyDir = document.body.dir || '';
  const computedDir = getComputedStyle(document.documentElement).direction;
  const isRTL = htmlDir === 'rtl' || bodyDir === 'rtl' || computedDir === 'rtl';

  /* ── State ── */
  let pdfDoc      = null;
  let currentPage = 1;
  let totalPages  = 0;
  let scale       = 1.0;
  let rotation    = 0;
  let rendering   = false;
  let pendingPage = null;
  const pdfUrl    = `{{ Storage::url($book->file) }}`;

  /* ── Helpers ── */
  function showLoading() { loadingEl.style.display = 'flex'; errorEl.style.display = 'none'; }
  function hideLoading() { loadingEl.style.display = 'none'; }
  function showError(msg) { errorEl.style.display = 'flex'; errorMsg.textContent = msg; hideLoading(); }

  function updateNavState() {
    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = !pdfDoc || currentPage >= totalPages;
    pageInput.value = currentPage;
    if (pdfDoc) {
      const pct = (currentPage / totalPages) * 100;
      progressBar.style.width = pct + '%';
    }
  }

  function updateZoomUI() {
    const pct = Math.round(scale * 100);
    zoomLabel.textContent = pct + '%';
    zoomRange.value = pct;
  }

  /* ── Render ── */
  async function renderPage(pageNum) {
    if (!pdfDoc) return;
    if (rendering) { pendingPage = pageNum; return; }
    rendering = true;

    try {
      const page = await pdfDoc.getPage(pageNum);
      const vp = page.getViewport({ scale, rotation });
      const dpr = window.devicePixelRatio || 1;

      canvas.width  = Math.floor(vp.width * dpr);
      canvas.height = Math.floor(vp.height * dpr);
      canvas.style.width  = Math.floor(vp.width) + 'px';
      canvas.style.height = Math.floor(vp.height) + 'px';

      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      await page.render({ canvasContext: ctx, viewport: vp }).promise;

      // Scroll canvas into view if zoomed
      if (container) {
        const offset = (canvas.offsetWidth - container.clientWidth) / 2;
        if (offset > 0) container.scrollTo({ left: Math.round(offset), behavior: 'smooth' });
        else container.scrollLeft = 0;
        container.scrollTop = 0;
      }

      canvas.style.opacity = '1';
      hideLoading();
    } catch (err) {
      console.error('Render error:', err);
    }

    rendering = false;
    if (pendingPage !== null) {
      const p = pendingPage;
      pendingPage = null;
      await renderPage(p);
    }
  }

  function goToPage(num) {
    if (!pdfDoc) return;
    const n = Math.max(1, Math.min(totalPages, num));
    if (n === currentPage && canvas.style.opacity === '1') return;
    canvas.style.opacity = '0.3';
    currentPage = n;
    updateNavState();
    setTimeout(() => renderPage(n), 120);
  }

  function nextPage() {
    if (currentPage < totalPages) goToPage(currentPage + 1);
  }
  function prevPage() {
    if (currentPage > 1) goToPage(currentPage - 1);
  }

  function setZoom(val) {
    scale = Math.max(0.25, Math.min(3, val));
    updateZoomUI();
    renderPage(currentPage);
  }

  /* ── Load PDF ── */
  async function loadPDF(url) {
    showLoading();
    try {
      const loadingTask = pdfjsLib.getDocument({
        url,
        cMapUrl: 'https://unpkg.com/pdfjs-dist@3.11.174/cmaps/',
        cMapPacked: true,
        standardFontDataUrl: 'https://unpkg.com/pdfjs-dist@3.11.174/standard_fonts/'
      });
      pdfDoc = await loadingTask.promise;
      totalPages = pdfDoc.numPages;
      totalPagesEl.textContent = totalPages;
      pageInput.max = totalPages;
      currentPage = 1;
      updateNavState();

      // Auto fit-to-width on first load
      await autoFitWidth();
      await renderPage(1);

      // Show swipe hint on touch devices
      if ('ontouchstart' in window && swipeHint) {
        swipeHint.style.display = 'flex';
      }
    } catch (err) {
      console.error('PDF load error:', err);
      showError('{{ __("Failed to load PDF") }}: ' + (err.message || err));
    }
  }

  async function autoFitWidth() {
    if (!pdfDoc) return;
    try {
      const page = await pdfDoc.getPage(1);
      const vp = page.getViewport({ scale: 1, rotation });
      const w = container ? container.clientWidth - 32 : window.innerWidth - 32;
      scale = Math.max(0.25, Math.min(2, w / vp.width));
      updateZoomUI();
    } catch(e) {}
  }

  /* ── Event listeners ── */

  // Nav buttons
  prevBtn.addEventListener('click', prevPage);
  nextBtn.addEventListener('click', nextPage);

  // Page input
  pageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const n = parseInt(this.value, 10);
      if (!isNaN(n)) goToPage(n);
      this.blur();
    }
  });
  pageInput.addEventListener('blur', function() {
    const n = parseInt(this.value, 10);
    if (!isNaN(n) && n !== currentPage) goToPage(n);
    else this.value = currentPage;
  });

  // Zoom
  zoomRange.addEventListener('input', function() {
    setZoom(Number(this.value) / 100);
  });
  zoomInBtn.addEventListener('click', () => setZoom(scale + 0.15));
  zoomOutBtn.addEventListener('click', () => setZoom(scale - 0.15));

  // Fit width
  if (fitWidthBtn) {
    fitWidthBtn.addEventListener('click', async () => {
      await autoFitWidth();
      renderPage(currentPage);
    });
  }

  // Rotate
  rotateBtn.addEventListener('click', () => {
    rotation = (rotation + 90) % 360;
    renderPage(currentPage);
  });

  // Download
  downloadBtn.addEventListener('click', () => {
    if (pdfUrl) window.open(pdfUrl, '_blank');
  });

  // Retry
  retryBtn.addEventListener('click', () => {
    errorEl.style.display = 'none';
    loadPDF(pdfUrl);
  });

  // Fullscreen
  fullscreenBtn.addEventListener('click', () => {
    const el = document.getElementById('pdfReaderApp');
    if (!document.fullscreenElement) {
      (el.requestFullscreen || el.webkitRequestFullscreen || el.msRequestFullscreen).call(el);
    } else {
      (document.exitFullscreen || document.webkitExitFullscreen || document.msExitFullscreen).call(document);
    }
  });

  /* ── Keyboard ── */
  window.addEventListener('keydown', function(e) {
    // Don't capture when typing in page input
    if (document.activeElement === pageInput) return;
    if (!pdfDoc) return;

    const key = e.key;

    if (key === 'ArrowRight') {
      e.preventDefault();
      isRTL ? prevPage() : nextPage();
    } else if (key === 'ArrowLeft') {
      e.preventDefault();
      isRTL ? nextPage() : prevPage();
    } else if (key === 'ArrowDown' || key === 'PageDown') {
      e.preventDefault();
      nextPage();
    } else if (key === 'ArrowUp' || key === 'PageUp') {
      e.preventDefault();
      prevPage();
    } else if (key === '+' || key === '=') {
      e.preventDefault();
      setZoom(scale + 0.15);
    } else if (key === '-' || key === '_') {
      e.preventDefault();
      setZoom(scale - 0.15);
    } else if (key === '0' && (e.ctrlKey || e.metaKey)) {
      e.preventDefault();
      setZoom(1);
    } else if (key.toLowerCase() === 'r' && !e.ctrlKey && !e.metaKey) {
      rotation = (rotation + 90) % 360;
      renderPage(currentPage);
    } else if (key.toLowerCase() === 'f' && !e.ctrlKey && !e.metaKey) {
      e.preventDefault();
      autoFitWidth().then(() => renderPage(currentPage));
    } else if (key === 'Home') {
      e.preventDefault();
      goToPage(1);
    } else if (key === 'End') {
      e.preventDefault();
      goToPage(totalPages);
    } else if (key === '?') {
      shortcutsEl.style.display = shortcutsEl.style.display === 'none' ? 'block' : 'none';
    }
  });

  /* ── Touch swipe (RTL-aware) ── */
  (function setupTouch() {
    let startX = 0, startY = 0, swiping = false;
    let lastDist = null, initScale = scale;

    function dist(a, b) {
      return Math.hypot(b.clientX - a.clientX, b.clientY - a.clientY);
    }

    container.addEventListener('touchstart', function(e) {
      if (!pdfDoc) return;
      if (e.touches.length === 1) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        swiping = false;
        lastDist = null;
      } else if (e.touches.length === 2) {
        lastDist = dist(e.touches[0], e.touches[1]);
        initScale = scale;
        swiping = false;
      }
    }, { passive: true });

    container.addEventListener('touchmove', function(e) {
      if (!pdfDoc) return;
      if (e.touches.length === 1) {
        const dx = e.touches[0].clientX - startX;
        const dy = e.touches[0].clientY - startY;
        if (!swiping && Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 12) {
          swiping = true;
        }
        if (swiping) e.preventDefault();
      } else if (e.touches.length === 2 && lastDist !== null) {
        e.preventDefault();
        const d = dist(e.touches[0], e.touches[1]);
        const factor = d / lastDist;
        const newScale = Math.max(0.25, Math.min(3, initScale * factor));
        if (Math.abs(newScale - scale) > 0.02) {
          scale = newScale;
          updateZoomUI();
          requestAnimationFrame(() => renderPage(currentPage));
        }
        lastDist = d;
      }
    }, { passive: false });

    container.addEventListener('touchend', function(e) {
      if (!pdfDoc || !swiping) { lastDist = null; initScale = scale; return; }
      if (e.changedTouches.length === 1) {
        const dx = e.changedTouches[0].clientX - startX;
        const dy = e.changedTouches[0].clientY - startY;
        if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) {
          if (dx < 0) { isRTL ? nextPage() : prevPage(); }    // swipe left
          else        { isRTL ? prevPage() : nextPage(); }     // swipe right
        }
      }
      swiping = false;
      lastDist = null;
      initScale = scale;
    }, { passive: true });
  })();

  /* ── Resize handler ── */
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (pdfDoc) renderPage(currentPage);
    }, 200);
  });

  /* ── Ctrl+scroll zoom ── */
  container.addEventListener('wheel', function(e) {
    if (!e.ctrlKey && !e.metaKey) return;
    e.preventDefault();
    const delta = e.deltaY > 0 ? -0.1 : 0.1;
    setZoom(scale + delta);
  }, { passive: false });

  /* ── Start ── */
  if (pdfUrl) {
    loadPDF(pdfUrl);
  } else {
    showError('{{ __("No PDF URL provided") }}');
  }
});
</script>
@endsection
