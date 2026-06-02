<div>
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        {{-- Status --}}
        @if($status)
        <div class="mb-4 p-3 text-sm rounded-lg
                {{ str_contains($status,'✅')
                    ? 'bg-green-50 text-green-800'
                    : 'bg-yellow-50 text-yellow-800' }}">
            {{ $status }}
        </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">

            <h1 class="text-xl font-semibold text-gray-800 flex items-center gap-2">


                {{ __("Laravel Log Viewer") }}
            </h1>

            {{-- Buttons --}}
            <div class="flex gap-3">

                {{-- Refresh --}}
                <button wire:click="refreshLogs" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                    {{ __("Refresh") }}
                </button>

                {{-- Copy --}}
                <button id="copyLog" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg border hover:bg-gray-200 transition">
                    {{ __("Copy") }}
                </button>

                {{-- Clear --}}
                <button wire:click="clear" wire:confirm="⚠️ {{ __("Are you sure you want to clear all logs?") }}"
                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                    {{ __("Clear Logs") }}
                </button>

            </div>
        </div>

        {{-- CodeMirror --}}
        <div class="border border-gray-300 rounded-lg overflow-hidden shadow-inner" wire:ignore>
            <textarea id="logViewer">{{ $logContent }}</textarea>
        </div>

    </div>

    {{-- CodeMirror Assets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/codemirror.min.css" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/theme/material-palenight.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/codemirror.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {

        let editor;

        function initEditor() {

            const textarea = document.getElementById('logViewer');

            if (!textarea) return;

            if (!editor) {

                editor = CodeMirror.fromTextArea(textarea, {
                    mode: 'text/plain',
                    lineNumbers: true,
                    theme: 'material-palenight',
                    readOnly: true,
                    lineWrapping: true,
                    scrollbarStyle: 'native',
                });

                // Set fixed height
                editor.setSize(null, 500);
            }

            editor.setValue(@this.get('logContent'));

            setTimeout(() => {
                editor.scrollTo(
                    null,
                    editor.getScrollInfo().height
                );
            }, 100);
        }

        initEditor();

        Livewire.hook('morphed', () => {
            if (editor) {
                editor.setValue(@this.get('logContent'));
            }
        });

        // COPY BUTTON (event delegation → survives Livewire refreshes)
        document.addEventListener('click', async (e) => {

            if (e.target.id !== 'copyLog') return;

            try {

                await navigator.clipboard.writeText(
                    editor.getValue()
                );

                const btn = e.target;

                btn.textContent = '{{ __("Copied!") }}';
                btn.classList.add(
                    'bg-green-600',
                    'text-white'
                );

                setTimeout(() => {

                    btn.textContent = '{{ __("Copy") }}';

                    btn.classList.remove(
                        'bg-green-600',
                        'text-white'
                    );

                }, 1500);

            } catch (err) {
                console.error('Copy failed:', err);
            }
        });

    });
    </script>
</div>
