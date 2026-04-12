<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Success / Error Flash --}}
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-emerald-800 text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 002 0V5zm-1 8a1 1 0 100 2 1 1 0 000-2z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Add New Book</h1>
        <p class="mt-1 text-sm text-gray-500">Fill in the details below to add a new book to the library.</p>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- ─── Basic Info Section ─── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-3">Basic Information</h2>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Book Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" wire:model.blur="name" placeholder="Enter book name"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition" />
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- ISBN --}}
            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN <span
                        class="text-red-500">*</span></label>
                <input type="text" id="isbn" wire:model.blur="isbn" placeholder="e.g. 978-3-16-148410-0"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition" />
                @error('isbn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Short Description <span
                        class="text-red-500">*</span></label>
                <textarea id="description" wire:model.blur="description" rows="3" maxlength="500"
                    placeholder="Brief summary of the book..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition"></textarea>
                <p class="mt-1 text-xs text-gray-400">{{ strlen($description) }}/500 characters</p>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Body (Rich Text) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Description <span
                        class="text-red-500">*</span></label>
                <div wire:ignore x-data="{
                        init() {
                            const editor = new Quill(this.$refs.editor, {
                                theme: 'snow',
                                placeholder: 'Write the full book description...',
                                modules: {
                                    toolbar: [
                                        [{ 'header': [2, 3, false] }],
                                        ['bold', 'italic', 'underline', 'strike'],
                                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                        ['blockquote', 'link'],
                                        [{ 'direction': 'rtl' }],
                                        ['clean']
                                    ]
                                }
                            });
                            editor.on('text-change', () => {
                                $wire.set('body', editor.root.innerHTML);
                            });
                        }
                    }">
                    <div x-ref="editor" class="min-h-[200px]"></div>
                </div>
                @error('body') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ─── Author & Category Section ─── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-3">Author & Category</h2>

            {{-- Author Combobox --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Author <span
                        class="text-red-500">*</span></label>
                <div class="relative" x-data="{ open: @entangle('showAuthorDropdown') }" @click.outside="open = false">
                    @if ($selectedAuthorName)
                    {{-- Selected state --}}
                    <div
                        class="flex items-center gap-2 px-3 py-2 rounded-lg border border-indigo-200 bg-indigo-50 text-sm">
                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-indigo-800 font-medium">{{ $selectedAuthorName }}</span>
                        <button type="button" wire:click="clearAuthor"
                            class="ml-auto text-indigo-400 hover:text-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @else
                    {{-- Search input --}}
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="authorSearch"
                            placeholder="Search or type a new author name..."
                            @focus="if ($wire.authorSearch.length >= 2) open = true"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm pl-9 transition" />
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <div wire:loading wire:target="authorSearch" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Dropdown --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute z-30 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                        @forelse ($authorResults as $author)
                        <button type="button"
                            wire:click="selectAuthor({{ $author['id'] }}, '{{ addslashes($author['name']) }}')"
                            class="w-full text-left px-4 py-2.5 text-sm hover:bg-indigo-50 flex items-center gap-2 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $author['name'] }}</span>
                        </button>
                        @empty
                        @if (strlen($authorSearch) >= 2)
                        <div class="px-4 py-3 text-sm text-gray-500">
                            <p>No author found.</p>
                            <p class="text-indigo-600 font-medium mt-1">
                                "<span class="font-semibold">{{ $authorSearch }}</span>" will be created as a new
                                author.
                            </p>
                        </div>
                        @endif
                        @endforelse
                    </div>
                    @endif
                </div>
                @error('authorSearch') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Category Combobox --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                        class="text-red-500">*</span></label>
                <div class="relative" x-data="{ open: @entangle('showCategoryDropdown') }"
                    @click.outside="open = false">
                    @if ($selectedCategoryName)
                    {{-- Selected state --}}
                    <div
                        class="flex items-center gap-2 px-3 py-2 rounded-lg border border-emerald-200 bg-emerald-50 text-sm">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-emerald-800 font-medium">{{ $selectedCategoryName }}</span>
                        <button type="button" wire:click="clearCategory"
                            class="ml-auto text-emerald-400 hover:text-emerald-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @else
                    {{-- Search input --}}
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="categorySearch"
                            placeholder="Search or type a new category name..."
                            @focus="if ($wire.categorySearch.length >= 2) open = true"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm pl-9 transition" />
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <div wire:loading wire:target="categorySearch"
                            class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Dropdown --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute z-30 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                        @forelse ($categoryResults as $category)
                        <button type="button"
                            wire:click="selectCategory({{ $category['id'] }}, '{{ addslashes($category['name']) }}')"
                            class="w-full text-left px-4 py-2.5 text-sm hover:bg-emerald-50 flex items-center gap-2 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $category['name'] }}</span>
                        </button>
                        @empty
                        @if (strlen($categorySearch) >= 2)
                        <div class="px-4 py-3 text-sm text-gray-500">
                            <p>No category found.</p>
                            <p class="text-emerald-600 font-medium mt-1">
                                "<span class="font-semibold">{{ $categorySearch }}</span>" will be created as a new
                                category.
                            </p>
                        </div>
                        @endif
                        @endforelse
                    </div>
                    @endif
                </div>
                @error('categorySearch') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ─── Media Section ─── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-3">Media & Files</h2>

            {{-- Cover Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                <div x-data="{ dragging: false }" x-on:dragover.prevent="dragging = true"
                    x-on:dragleave.prevent="dragging = false" x-on:drop.prevent="dragging = false" class="relative">
                    @if ($image)
                    <div class="relative rounded-lg overflow-hidden border-2 border-indigo-200 bg-gray-50">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                            class="w-full h-56 object-contain bg-gray-100" />
                        <button type="button" wire:click="$set('image', null)"
                            class="absolute top-2 right-2 bg-white/90 backdrop-blur rounded-full p-1.5 shadow hover:bg-red-50 transition">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @else
                    <label :class="dragging ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 bg-gray-50'"
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition">
                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-500">Click or drag to upload cover image</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                        <input type="file" wire:model="image" accept="image/*" class="hidden" />
                    </label>
                    @endif
                    <div wire:loading wire:target="image" class="mt-2">
                        <div class="flex items-center gap-2 text-sm text-indigo-600">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            Uploading image...
                        </div>
                    </div>
                </div>
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- PDF File --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PDF File <span
                        class="text-red-500">*</span></label>
                <div x-data="{ dragging: false }" x-on:dragover.prevent="dragging = true"
                    x-on:dragleave.prevent="dragging = false" x-on:drop.prevent="dragging = false">
                    @if ($file)
                    <div class="rounded-lg border-2 border-emerald-200 bg-emerald-50/50 p-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-lg p-2.5 shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $file->getClientOriginalName()
                                    }}</p>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1.5">
                                    @if ($pdfSize)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0014.586 3H7c-2 0-3 1-3 3v1z" />
                                        </svg>
                                        Size: <strong>{{ $pdfSize }}</strong>
                                    </span>
                                    @endif
                                    @if ($pdfPages)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Pages: <strong>{{ $pdfPages }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <button type="button" wire:click="$set('file', null)"
                                class="text-gray-400 hover:text-red-500 transition shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @else
                    <label :class="dragging ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 bg-gray-50'"
                        class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition">
                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-500">Click or drag to upload PDF</p>
                        <p class="text-xs text-gray-400 mt-1">PDF up to 50MB</p>
                        <input type="file" wire:model="file" accept=".pdf,application/pdf" class="hidden" />
                    </label>
                    @endif
                    <div wire:loading wire:target="file" class="mt-2">
                        <div class="flex items-center gap-2 text-sm text-indigo-600">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            Uploading & analyzing PDF...
                        </div>
                    </div>
                </div>
                @error('file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ─── Submit ─── --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('books.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-not-allowed"
                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                <span wire:loading.remove wire:target="save">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <svg wire:loading wire:target="save" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                Save Book
            </button>
        </div>
    </form>

    {{-- Quill CSS/JS --}}
    @push('styles')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 200px;
            font-size: 0.875rem;
        }

        .ql-toolbar {
            border-radius: 0.5rem 0.5rem 0 0;
            border-color: #d1d5db;
        }

        .ql-container {
            border-radius: 0 0 0.5rem 0.5rem;
            border-color: #d1d5db;
        }
    </style>
    @endpush
    @push('scripts')
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    @endpush
</div>
