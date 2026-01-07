@extends('layouts.base')

@section('content')
<style>
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

    @keyframes swipeHint {

        0%,
        100% {
            transform: translateY(0);
            opacity: 0.8;
        }

        50% {
            transform: translateY(-8px);
            opacity: 1;
        }
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

    .animate-spin-custom {
        animation: spin 1s linear infinite;
    }

    .animate-pulse-custom {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-swipe-hint {
        animation: swipeHint 2s ease-in-out infinite;
    }

    .page-transition-up {
        animation: slideInUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-transition-down {
        animation: slideInDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #canvasContainer {
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }

    #pdfCanvas {
        transition: opacity 0.3s ease-in-out, transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #canvasContainer::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    #canvasContainer::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 5px;
    }

    #canvasContainer::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 5px;
        border: 2px solid #e2e8f0;
    }

    #canvasContainer::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    .zoom-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.25rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
    }

    footer{
        display: none
    }
</style>

<div class="max-w-[1400px] mx-auto p-2 min-h-screen md:p-2 pb-14">
    <!-- PDF Container -->
    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 relative">
        <div id="canvasContainer"
            class="bg-gradient-to-b from-slate-100 to-slate-200 min-h-[60vh] max-h-[70vh] md:min-h-[90vh] md:max-h-[80vh] lg:max-h-[75vh] overflow-auto relative">
            <!-- Loading Spinner -->
            <div id="loadingSpinner"
                class="absolute inset-0 flex items-center justify-center bg-gradient-to-b from-slate-100 to-slate-200 z-10">
                <div class="text-center">
                    <div
                        class="w-16 h-16 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin-custom mx-auto mb-4">
                    </div>
                    <div class="text-slate-800 font-semibold text-base">{{ __('Loading PDF...') }}</div>
                    <div class="text-slate-500 text-sm mt-2 animate-pulse-custom">{{ __('Please wait') }}</div>
                </div>
            </div>

            <!-- Swipe Hint -->
            <div id="swipeHint"
                class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 pointer-events-none opacity-0 transition-opacity duration-500">
                <div
                    class="bg-slate-900/95 backdrop-blur-lg text-white px-5 py-3 rounded-full text-sm font-medium flex items-center gap-2 animate-swipe-hint">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    {{ __('Swipe to navigate') }}
                </div>
            </div>

            <!-- Canvas -->
            <div class="flex items-center justify-center w-full h-full">
                <canvas id="pdfCanvas" class="rounded-lg max-w-full h-auto block"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Controls -->
<div class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none">
    <div class="max-w-[1400px] mx-auto px-4 pb-4 md:px-2 md:pb-2">
        <div
            class="pointer-events-auto bg-white/98 backdrop-blur-xl rounded-t-2xl border border-slate-200 border-b-0 p-4 md:p-3">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <!-- Navigation -->
                <div class="flex items-center gap-2 sm:gap-1">
                    <button id="prev"
                        class="inline-flex items-center justify-center gap-2 px-2.5 py-2.5 md:px-2 md:py-2 border-0 rounded-xl text-sm font-semibold cursor-pointer transition-all duration-200 select-none touch-manipulation min-h-[2.75rem] md:min-h-[2.5rem] min-w-[2.75rem] md:min-w-[2.5rem] bg-gradient-to-br from-slate-500 to-slate-600 text-white hover:opacity-90 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none"
                        title="{{ __('Previous') }}">
                        <svg class="w-5 h-5 md:w-4 md:h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div id="pageInfo"
                        class="inline-flex items-center gap-2 px-5 py-2.5 md:px-3 md:py-2 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl border-2 border-blue-400  text-black font-bold  text-sm md:text-xs min-w-[7rem] md:min-w-[5rem] justify-center">
                        {{ __('Page - / -') }}
                    </div>

                    <button id="next"
                        class="inline-flex items-center justify-center gap-2 px-2.5 py-2.5 md:px-2 md:py-2 border-0 rounded-xl text-sm font-semibold cursor-pointer transition-all duration-200 select-none touch-manipulation min-h-[2.75rem] md:min-h-[2.5rem] min-w-[2.75rem] md:min-w-[2.5rem] bg-gradient-to-br from-slate-500 to-slate-600 text-white hover:opacity-90 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none"
                        title="{{ __('Next') }}">
                        <svg class="w-5 h-5 md:w-4 md:h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Zoom Controls -->
                <div class="flex items-center gap-2 sm:gap-1">
                    <div
                        class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 rounded-xl px-3 py-2 md:px-2.5 md:py-1.5">
                        <select id="zoomSel"
                            class="zoom-select border-0 bg-transparent px-2 py-1 text-sm font-semibold text-slate-800 cursor-pointer outline-none pr-6 md:text-xs">
                            <option value="0.5">50%</option>
                            <option value="0.75">75%</option>
                            <option value="1" selected>100%</option>
                            <option value="1.25">125%</option>
                            <option value="1.5">150%</option>
                            <option value="2">200%</option>
                        </select>
                        <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke-width="2" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2" />
                        </svg>
                    </div>
                    <input id="zoomRange" type="range" min="50" max="200" step="5" value="100"
                        class="hidden md:block w-32 h-2 accent-blue-600 cursor-pointer">
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2 sm:gap-1">
                    <button id="rotate"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 md:px-2 md:py-2 border-0 rounded-xl text-sm md:text-xs font-semibold cursor-pointer transition-all duration-200 select-none touch-manipulation min-h-[2.75rem] md:min-h-[2.5rem] md:min-w-[2.5rem] bg-gradient-to-br from-amber-500 to-amber-600 text-white hover:opacity-90 active:scale-95"
                        title="{{ __('Rotate') }}">
                        <svg class="w-5 h-5 md:w-4 md:h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="hidden xl:inline text-black">{{ __('Rotate') }}</span>
                    </button>

                    <button id="fitToWidth"
                        class="hidden md:inline-flex items-center  justify-center gap-2 px-4 py-2.5 md:px-2 md:py-2 border-0 rounded-xl text-sm md:text-xs font-semibold cursor-pointer transition-all duration-200 select-none touch-manipulation min-h-[2.75rem] md:min-h-[2.5rem] md:min-w-[2.5rem] bg-gradient-to-br from-amber-500 to-amber-600 text-white hover:opacity-90 active:scale-95"
                        title="{{ __('Fit to width') }}">
                        <svg class="w-5 h-5 md:w-4 md:h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        <span class="hidden xl:inline text-black">{{ __('Fit') }}</span>
                    </button>

                    <button id="download"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 md:px-2 md:py-2 border-0 rounded-xl text-sm md:text-xs font-semibold cursor-pointer transition-all duration-200 select-none touch-manipulation min-h-[2.75rem] md:min-h-[2.5rem] md:min-w-[2.5rem] bg-gradient-to-br from-emerald-500 to-emerald-600 text-white hover:opacity-90 active:scale-95"
                        title="{{ __('Download') }}">
                        <svg class="w-5 h-5 md:w-4 md:h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden xl:inline">{{ __('Download') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.js"></script>
<script>
    document.addEventListener('DOMContentLoaded',function(){const e=window.pdfjsLib;if(!e)return void console.error("pdfjsLib not found");e.GlobalWorkerOptions.workerSrc="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.js";const t=document.getElementById("pdfCanvas"),n=t?.getContext("2d"),a=document.getElementById("prev"),o=document.getElementById("next"),l=document.getElementById("pageInfo"),s=document.getElementById("zoomSel"),r=document.getElementById("rotate"),i=document.getElementById("download"),d=document.getElementById("zoomRange"),c=document.getElementById("fitToWidth"),u=document.getElementById("canvasContainer"),m=document.getElementById("loadingSpinner"),p=document.getElementById("swipeHint");if(!t||!n)return void console.error("Canvas not found");let g=!0,h=null;function f(){m&&g&&(m.style.display="flex")}function y(){m&&(m.style.display="none",g=!1,setTimeout(()=>{p&&(p.style.opacity="1",setTimeout(()=>p.style.opacity="0",3e3))},500))}function b(e){t.style.opacity="0",t.style.transform="scale(0.95)",setTimeout(e,150)}function E(e=null){"up"===e?t.classList.add("page-transition-up"):"down"===e&&t.classList.add("page-transition-down"),setTimeout(()=>{t.style.opacity="1",t.style.transform="scale(1)",setTimeout(()=>t.classList.remove("page-transition-up","page-transition-down"),300)},50)}const w="rtl"===document.documentElement.dir||"rtl"===document.body.dir||"rtl"===getComputedStyle(document.documentElement).direction;let v=null,k=1,T=0,L=1;if(s?.value){const e=parseFloat(s.value);isNaN(e)||(L=e)}function x(){l&&(l.innerHTML=v?`<span class="hidden sm:inline">{{ __('Page') }}</span> <span>${k}</span> <span style="color: #94a3b8;">/</span> ${v.numPages}`:'{{ __("Page - / -") }}')}function I(){a&&(a.disabled=!v||k<=1),o&&(o.disabled=!v||k>=v.numPages)}function S(){v&&k<v.numPages&&(h="up",b(()=>{k++,N(k)}))}function C(){v&&k>1&&(h="down",b(()=>{k--,N(k)}))}async function N(e){if(!v)return;try{g&&f(),x(),I();const a=await v.getPage(e),o=a.getViewport({scale:L,rotation:T}),l=window.devicePixelRatio||1;t.width=Math.floor(o.width*l),t.height=Math.floor(o.height*l),t.style.width=o.width+"px",t.style.height=o.height+"px",t.style.maxWidth="100%",t.style.height="auto",n.setTransform(l,0,0,l,0,0),n.clearRect(0,0,t.width,t.height),await a.render({canvasContext:n,viewport:o}).promise,u&&u.scrollTo({left:(t.offsetWidth-u.clientWidth)/2>0?Math.round((t.offsetWidth-u.clientWidth)/2):0,behavior:"smooth"}),g&&y(),E(h),h=null}catch(e){console.error("Error rendering page:",e),y()}}a&&a.addEventListener("click",C),o&&o.addEventListener("click",S),s&&s.addEventListener("change",()=>{const e=parseFloat(s.value);isNaN(e)||(L=e,d&&(d.value=Math.round(100*L)),v&&b(()=>N(k)))}),d&&d.addEventListener("input",()=>{const e=Number(d.value)/100;isNaN(e)||(L=e,s&&(s.value=e.toString()),v&&b(()=>N(k)))}),r&&r.addEventListener("click",()=>{T=(T+90)%360,v&&b(()=>N(k))}),c&&c.addEventListener("click",async()=>{if(!v)return;try{const e=await v.getPage(k),t=e.getViewport({scale:1,rotation:T}),n=(u?u.clientWidth-32:window.innerWidth)/t.width;L=Math.max(.25,Math.min(3,n)),s&&(s.value=L.toString()),d&&(d.value=Math.round(100*L)),b(()=>N(k))}catch(e){console.error("Fit to width error:",e)}}),window.addEventListener("keydown",e=>{if(!v)return;if("ArrowRight"===e.key&&(e.preventDefault(),w?C():S()),"ArrowLeft"===e.key&&(e.preventDefault(),w?S():C()),"ArrowDown"===e.key&&(e.preventDefault(),S()),"ArrowUp"===e.key&&(e.preventDefault(),C()),"+"===e.key||"="===e.key){if(e.preventDefault(),!s)return;const t=Array.from(s.options).map(e=>parseFloat(e.value)),n=t.indexOf(L);n<t.length-1&&(s.selectedIndex=n+1,s.dispatchEvent(new Event("change")))}if("-"===e.key){if(e.preventDefault(),!s)return;const t=Array.from(s.options).map(e=>parseFloat(e.value)),n=t.indexOf(L);n>0&&(s.selectedIndex=n-1,s.dispatchEvent(new Event("change")))}}),function(){let e,t,n,a,o,l=null,s=L;function r(e,t){const n=t.clientX-e.clientX,a=t.clientY-e.clientY;return Math.sqrt(n*n+a*a)}u.addEventListener("touchstart",function(r){v&&(r.touches.length>=1&&(e=r.touches[0].clientX,t=r.touches[0].clientY,n=!1,a=!1,l=null),2===r.touches.length&&(l=r(r.touches[0],r.touches[1]),s=L,n=!1,a=!1))},{passive:!0}),u.addEventListener("touchmove",function(i){if(!v)return;if(1===i.touches.length){const o=i.touches[0].clientX-e,l=i.touches[0].clientY-t,s=Math.abs(o),r=Math.abs(l);!n&&!a&&(s>10||r>10)&&(r>1.5*s?(n=!0,a=!1):(a=!0,n=!1)),n&&r>10&&i.preventDefault()}else if(2===i.touches.length){i.preventDefault();const e=r(i.touches[0],i.touches[1]);if(null!==l&&l>0){const t=e/l;let n=s*t;n=Math.max(.25,Math.min(3,n)),Math.abs(n-L)>.01&&(L=n,o&&(o.value=L.toString()),d&&(d.value=Math.round(100*L)),window.requestAnimationFrame(()=>N(k)))}l=e}},{passive:!1}),u.addEventListener("touchend",function(o){if(!v)return;if(n&&o.changedTouches&&1===o.changedTouches.length){const l=o.changedTouches[0].clientX-e,s=o.changedTouches[0].clientY-t,r=Math.abs(l),i=Math.abs(s);i>50&&i>1.5*r&&(s<0?S():C())}n=!1,a=!1,l=null,s=L},{passive:!0})}();const A='{{ Storage::url($book->file) }}';A&&A.length>0?async function(t){try{f();const n=e.getDocument({url:t,cMapUrl:"https://unpkg.com/pdfjs-dist@3.11.174/cmaps/",cMapPacked:!0,standardFontDataUrl:"https://unpkg.com/pdfjs-dist@3.11.174/standard_fonts/"});v=await n.promise,k=1,x(),I(),await N(k),i&&(i.onclick=()=>window.open(t,"_blank"))}catch(e){console.error("Failed to load PDF:",e),alert('{{ __("Failed to load PDF") }}: '+(e?.message||e)),y()}}(A):console.error("PDF URL is empty")});
</script>
@endsection
