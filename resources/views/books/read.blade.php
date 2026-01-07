@extends('layouts.base')

@section('content')
<style>
    * {
        -webkit-tap-highlight-color: transparent;
    }

    #canvasContainer {
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }

    #pdfCanvas {
        transition: opacity 0.3s ease-in-out, transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .control-btn {
        transition: all 0.2s ease;
        touch-action: manipulation;
        user-select: none;
    }

    .control-btn:active {
        transform: scale(0.95);
        opacity: 0.9;
    }

    #canvasContainer::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    #canvasContainer::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    #canvasContainer::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 4px;
        border: 2px solid #f1f5f9;
    }

    #canvasContainer::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-transition-up {
        animation: slideInUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-transition-down {
        animation: slideInDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    @keyframes swipeHint {

        0%,
        100% {
            transform: translateY(0);
            opacity: 0.7;
        }

        50% {
            transform: translateY(-8px);
            opacity: 1;
        }
    }

    .swipe-hint {
        animation: swipeHint 2s ease-in-out infinite;
    }

    /* Improved Mobile Responsiveness */
    @media (max-width: 640px) {
        .control-btn {
            padding: 0.5rem !important;
        }

        .control-btn svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        #pageInfo {
            min-width: 80px !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem;
        }
    }

    @media (min-width: 641px) and (max-width: 1024px) {
        #canvasContainer {
            max-height: 75vh !important;
        }
    }

    /* Better touch targets for mobile */
    @media (hover: none) and (pointer: coarse) {
        .control-btn {
            min-height: 44px;
            min-width: 44px;
        }
    }

    footer{
        display: none!important;
    }
</style>

<div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-2 px-2 pb-28 sm:py-4 sm:px-3 sm:pb-24 md:pb-20">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-6 fade-in">
            <h1
                class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800 mb-2 sm:mb-3 bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 bg-clip-text text-transparent leading-tight">
                {{ str_replace(":attr", $book->name, app('site')->site_options['read_book_title']) }}
            </h1>
            {{-- <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm text-slate-600">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    <span class="font-medium">{{ __('Swipe up/down to navigate') }}</span>
                </div>
                <span class="hidden sm:inline text-slate-400">•</span>
                <span class="hidden sm:inline">{{ __('Pinch to zoom') }}</span>
            </div> --}}
        </div>

        <!-- PDF Viewer Container -->
        <div class="bg-white rounded-xl  sm:rounded-2xl overflow-hidden border border-slate-200 fade-in">
            <div id="canvasContainer"
                class="bg-gradient-to-br pb-6 from-slate-100 to-slate-200 overflow-auto touch-pan-x touch-pan-y relative"
                style="direction: ltr;">
                <!-- Loading Spinner -->
                <div id="loadingSpinner"
                    class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 z-10">
                    <div class="flex flex-col items-center gap-3 sm:gap-4">
                        <div class="relative">
                            <div
                                class="w-12 h-12 sm:w-16 sm:h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin">
                            </div>
                            <div class="absolute inset-0 w-12 h-12 sm:w-16 sm:h-16 border-4 border-transparent border-b-indigo-400 rounded-full animate-spin"
                                style="animation-duration: 1.5s;"></div>
                        </div>
                        <div class="text-center px-4">
                            <p class="text-slate-700 text-sm sm:text-base font-semibold mb-1">{{ __('Loading PDF...') }}
                            </p>
                            <p class="text-slate-500 text-xs sm:text-sm animate-pulse">{{ __('Please wait') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Swipe Hint -->
                <div id="swipeHint"
                    class="absolute bottom-6 sm:bottom-8 left-1/2 transform -translate-x-1/2 z-20 pointer-events-none opacity-0 transition-opacity duration-500">
                    <div
                        class="bg-slate-800/90 backdrop-blur-sm text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium flex items-center gap-2 swipe-hint">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        {{ __('Swipe to navigate') }}
                    </div>
                </div>

                <!-- Canvas -->
                <div class="flex items-center justify-center w-full h-full p-2 sm:p-4">
                    <canvas id="pdfCanvas" class="rounded-lg max-w-full h-auto block"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Fixed Bottom Controls -->
<div class="fixed inset-x-0 bottom-0 z-50 pointer-events-none">
    <div class="max-w-6xl mx-auto px-2 sm:px-3 pb-safe">
        <div
            class="pointer-events-auto rounded-t-xl sm:rounded-t-2xl bg-white/95 backdrop-blur-md border-t border-x border-slate-200">
            <div class="px-2 py-2 sm:px-4 sm:py-3">
                <!-- Main Controls Row -->
                <div class="flex items-center justify-between gap-1.5 sm:gap-2 md:gap-3 flex-wrap">
                    <!-- Navigation Controls -->
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button id="prev"
                            class="control-btn flex items-center justify-center gap-1 sm:gap-2 px-2 py-2 sm:px-3 sm:py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-slate-600 to-slate-700 text-white rounded-lg sm:rounded-xl hover:from-slate-700 hover:to-slate-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="hidden sm:inline text-xs md:text-sm font-medium">{{ __('Prev') }}</span>
                        </button>

                        <div id="pageInfo"
                            class="flex items-center gap-1 sm:gap-2 px-2 py-2 sm:px-4 sm:py-2 md:px-5 md:py-2.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg sm:rounded-xl text-xs sm:text-sm md:text-base text-slate-800 font-semibold border-2 border-blue-200 min-w-[80px] sm:min-w-[100px] md:min-w-[120px] justify-center">
                            {{ __('Page - / -') }}
                        </div>

                        <button id="next"
                            class="control-btn flex items-center justify-center gap-1 sm:gap-2 px-2 py-2 sm:px-3 sm:py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-slate-600 to-slate-700 text-white rounded-lg sm:rounded-xl hover:from-slate-700 hover:to-slate-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="hidden sm:inline text-xs md:text-sm font-medium">{{ __('Next') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Zoom Controls -->
                    <div class="flex items-center gap-1 sm:gap-2">
                        <div
                            class="inline-flex items-center gap-1.5 sm:gap-2 bg-white border-2 border-slate-200 rounded-lg sm:rounded-xl px-2 py-1.5 sm:px-3 sm:py-2">
                            <label class="flex items-center gap-1.5 sm:gap-2 cursor-pointer">
                                <select id="zoomSel"
                                    class="appearance-none px-1 sm:px-2 py-0.5 sm:py-1 text-xs sm:text-sm font-medium outline-none bg-transparent cursor-pointer text-slate-700">
                                    <option value="0.5">50%</option>
                                    <option value="0.75">75%</option>
                                    <option value="1" selected>100%</option>
                                    <option value="1.25">125%</option>
                                    <option value="1.5">150%</option>
                                    <option value="2">200%</option>
                                </select>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="7" stroke-width="2" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2" />
                                </svg>
                            </label>
                        </div>
                        <input id="zoomRange" type="range" min="50" max="200" step="5" value="100"
                            class="hidden md:block w-24 lg:w-32 xl:w-40 h-2 accent-blue-600 cursor-pointer">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-1 sm:gap-2">

                        <!-- ROTATE -->
                        <button id="rotate" class="control-btn flex items-center justify-center gap-1 sm:gap-2
                                   px-2 py-2 sm:px-3 sm:py-2 md:px-4 md:py-2.5
                                   bg-gradient-to-r from-purple-600 to-purple-700
                                   text-white rounded-lg sm:rounded-xl
                                   hover:from-purple-700 hover:to-purple-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="black"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="hidden xl:inline text-xs md:text-sm font-medium">
                                {{ __('Rotate') }}
                            </span>
                        </button>

                        <!-- FIT TO WIDTH -->
                        <button id="fitToWidth" class="control-btn hidden md:flex items-center justify-center gap-1 sm:gap-2
                                   px-2 py-2 sm:px-3 sm:py-2 md:px-4 md:py-2.5
                                   bg-gradient-to-r from-amber-500 to-amber-600
                                   text-white rounded-lg sm:rounded-xl
                                   hover:from-amber-600 hover:to-amber-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="black"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                            </svg>
                            <span class="hidden xl:inline text-xs md:text-sm font-medium">
                                {{ __('Fit') }}
                            </span>
                        </button>

                        <!-- DOWNLOAD -->
                        <button id="download" class="control-btn flex items-center justify-center gap-1 sm:gap-2
                                   px-2 py-2 sm:px-3 sm:py-2 md:px-4 md:py-2.5
                                   bg-gradient-to-r from-green-600 to-green-700
                                   text-white rounded-lg sm:rounded-xl
                                   hover:from-green-700 hover:to-green-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="black"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span class="hidden xl:inline text-xs md:text-sm font-medium">
                                {{ __('Download') }}
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.js"></script>
<script>
    document.addEventListener('DOMContentLoaded',function(){const e=window.pdfjsLib;if(!e)return void console.error("pdfjsLib not found");e.GlobalWorkerOptions.workerSrc="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.js";const t=document.getElementById("pdfCanvas"),n=t?.getContext("2d"),a=document.getElementById("prev"),o=document.getElementById("next"),l=document.getElementById("pageInfo"),s=document.getElementById("zoomSel"),r=document.getElementById("rotate"),i=document.getElementById("download"),d=document.getElementById("zoomRange"),c=document.getElementById("fitToWidth"),u=document.getElementById("canvasContainer"),m=document.getElementById("loadingSpinner"),p=document.getElementById("swipeHint");if(!t||!n)return void console.error("Canvas not found");let g=!0,h=null;function f(){m&&g&&(m.style.display="flex")}function y(){m&&(m.style.display="none",g=!1,setTimeout(()=>{p&&(p.style.opacity="1",setTimeout(()=>p.style.opacity="0",3e3))},500))}function b(e){t.style.opacity="0",t.style.transform="scale(0.95)",setTimeout(e,150)}function E(e=null){"up"===e?t.classList.add("page-transition-up"):"down"===e&&t.classList.add("page-transition-down"),setTimeout(()=>{t.style.opacity="1",t.style.transform="scale(1)",setTimeout(()=>t.classList.remove("page-transition-up","page-transition-down"),300)},50)}const w="rtl"===document.documentElement.dir||"rtl"===document.body.dir||"rtl"===getComputedStyle(document.documentElement).direction;let v=null,k=1,T=0,L=1;if(s?.value){const e=parseFloat(s.value);isNaN(e)||(L=e)}function x(){l&&(l.innerHTML=v?`<span class="hidden sm:inline">{{ __('Page') }}</span> <span class="font-bold">${k}</span> <span class="text-slate-500">/</span> ${v.numPages}`:'{{ __("Page - / -") }}')}function I(){a&&(a.disabled=!v||k<=1),o&&(o.disabled=!v||k>=v.numPages)}function S(){v&&k<v.numPages&&(h="up",b(()=>{k++,N(k)}))}function C(){v&&k>1&&(h="down",b(()=>{k--,N(k)}))}async function N(e){if(!v)return;try{g&&f(),x(),I();const a=await v.getPage(e),o=a.getViewport({scale:L,rotation:T}),l=window.devicePixelRatio||1;t.width=Math.floor(o.width*l),t.height=Math.floor(o.height*l),t.style.width=o.width+"px",t.style.height=o.height+"px",t.style.maxWidth="100%",t.style.height="auto",n.setTransform(l,0,0,l,0,0),n.clearRect(0,0,t.width,t.height),await a.render({canvasContext:n,viewport:o}).promise,u&&u.scrollTo({left:(t.offsetWidth-u.clientWidth)/2>0?Math.round((t.offsetWidth-u.clientWidth)/2):0,behavior:"smooth"}),g&&y(),E(h),h=null}catch(e){console.error("Error rendering page:",e),y()}}a&&a.addEventListener("click",C),o&&o.addEventListener("click",S),s&&s.addEventListener("change",()=>{const e=parseFloat(s.value);isNaN(e)||(L=e,d&&(d.value=Math.round(100*L)),v&&b(()=>N(k)))}),d&&d.addEventListener("input",()=>{const e=Number(d.value)/100;isNaN(e)||(L=e,s&&(s.value=e.toString()),v&&b(()=>N(k)))}),r&&r.addEventListener("click",()=>{T=(T+90)%360,v&&b(()=>N(k))}),c&&c.addEventListener("click",async()=>{if(!v)return;try{const e=await v.getPage(k),t=e.getViewport({scale:1,rotation:T}),n=(u?u.clientWidth-32:window.innerWidth)/t.width;L=Math.max(.25,Math.min(3,n)),s&&(s.value=L.toString()),d&&(d.value=Math.round(100*L)),b(()=>N(k))}catch(e){console.error("Fit to width error:",e)}}),window.addEventListener("keydown",e=>{if(!v)return;if("ArrowRight"===e.key&&(e.preventDefault(),w?C():S()),"ArrowLeft"===e.key&&(e.preventDefault(),w?S():C()),"ArrowDown"===e.key&&(e.preventDefault(),S()),"ArrowUp"===e.key&&(e.preventDefault(),C()),"+"===e.key||"="===e.key){if(e.preventDefault(),!s)return;const t=Array.from(s.options).map(e=>parseFloat(e.value)),n=t.indexOf(L);n<t.length-1&&(s.selectedIndex=n+1,s.dispatchEvent(new Event("change")))}if("-"===e.key){if(e.preventDefault(),!s)return;const t=Array.from(s.options).map(e=>parseFloat(e.value)),n=t.indexOf(L);n>0&&(s.selectedIndex=n-1,s.dispatchEvent(new Event("change")))}}),function(){let e,t,n,a,o,l=null,s=L;function r(e,t){const n=t.clientX-e.clientX,a=t.clientY-e.clientY;return Math.sqrt(n*n+a*a)}u.addEventListener("touchstart",function(r){v&&(r.touches.length>=1&&(e=r.touches[0].clientX,t=r.touches[0].clientY,n=!1,a=!1,l=null),2===r.touches.length&&(l=r(r.touches[0],r.touches[1]),s=L,n=!1,a=!1))},{passive:!0}),u.addEventListener("touchmove",function(i){if(!v)return;if(1===i.touches.length){const o=i.touches[0].clientX-e,l=i.touches[0].clientY-t,s=Math.abs(o),r=Math.abs(l);!n&&!a&&(s>10||r>10)&&(r>1.5*s?(n=!0,a=!1):(a=!0,n=!1)),n&&r>10&&i.preventDefault()}else if(2===i.touches.length){i.preventDefault();const e=r(i.touches[0],i.touches[1]);if(null!==l&&l>0){const t=e/l;let n=s*t;n=Math.max(.25,Math.min(3,n)),Math.abs(n-L)>.01&&(L=n,o&&(o.value=L.toString()),d&&(d.value=Math.round(100*L)),window.requestAnimationFrame(()=>N(k)))}l=e}},{passive:!1}),u.addEventListener("touchend",function(o){if(!v)return;if(n&&o.changedTouches&&1===o.changedTouches.length){const l=o.changedTouches[0].clientX-e,s=o.changedTouches[0].clientY-t,r=Math.abs(l),i=Math.abs(s);i>50&&i>1.5*r&&(s<0?S():C())}n=!1,a=!1,l=null,s=L},{passive:!0})}();const A='{{ Storage::url($book->file) }}';A&&A.length>0?async function(t){try{f();const n=e.getDocument({url:t,cMapUrl:"https://unpkg.com/pdfjs-dist@3.11.174/cmaps/",cMapPacked:!0,standardFontDataUrl:"https://unpkg.com/pdfjs-dist@3.11.174/standard_fonts/"});v=await n.promise,k=1,x(),I(),await N(k),i&&(i.onclick=()=>window.open(t,"_blank"))}catch(e){console.error("Failed to load PDF:",e),alert('{{ __("Failed to load PDF") }}: '+(e?.message||e)),y()}}(A):console.error("PDF URL is empty")});
</script>
@endsection
