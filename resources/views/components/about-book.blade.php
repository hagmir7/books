{{-- Sidebar: meta + social (lg:col-span-2) --}}
<aside class="lg:col-span-2 w-full">
   <div class="lg:sticky lg:top-4">
    {{-- Book info card --}}
    <div class="overflow-hidden rounded-md border border-gray-300 mb-6 bg-white">
        <div class="overflow-auto">
            <table class="w-full table-auto text-md book-meta">
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="py-2 px-4 font-semibold w-1/3">{{ __("Book name") }}:</td>
                        <td class="py-2 px-4">
                            <span itemprop="bookName">{{ $book->name }}</span>
                            <span class="text-gray-500">({{ $book->updated_at->format("Y") }})</span>
                        </td>
                    </tr>

                    @if ($book->category)
                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("Category") }}:</td>
                        <td class="py-2 px-4">
                            <a itemprop="category" href="{{ route('category.show', $book?->category?->slug) }}"
                                class="text-blue-600 hover:text-blue-800">
                                {{ $book?->category?->name }}
                            </a>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("Authors") }}:</td>
                        <td class="py-2 px-4">
                            @if(isset($book->author) && strlen($book->author->description) > 0 &&
                            $book->author->verified)
                            <span title="{{ __('Verified author') }}" class="inline-block mr-1 text-green-600"
                                aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                            </span>
                            @endif

                            <a href="{{ route('authors.show', $book->author->slug) }}" itemprop="author"
                                class="text-blue-600 hover:text-blue-800">
                                {{ $book->author->full_name }}
                            </a>

                            @if (auth()?->user()?->email_verified_at)
                            -
                            <a href="{{ route('filament.admin.resources.authors.edit', ['record' => $book->author->slug]) }}"
                                class="text-blue-600 hover:text-blue-800 ml-1" aria-label="{{ __('Edit author') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                </svg>
                            </a>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("Pages") }}:</td>
                        <td class="py-2 px-4">
                            <span itemprop="numberOfPages">{{ $book->pages ? $book->pages : "__" }} {{
                                __("pages") }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("Language") }}:</td>
                        <td class="py-2 px-4" itemprop="Language">
                            {{ $book->language->name }}
                        </td>
                    </tr>

                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("Type") }}:</td>
                        <td class="py-2 px-4">
                            <div class="inline-block bg-red-600 text-white px-3 py-1 rounded text-sm">{{
                                $book->type }}</div>
                        </td>
                    </tr>

                    @if ($book->isbn)
                    <tr>
                        <td class="py-2 px-4 font-semibold">{{ __("ISBN13") }}:</td>
                        <td class="py-2 px-4"><span itemprop="isbn">{{ $book->isbn }}</span></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <x-sheare-book :book="$book" />
    <livewire:report-form :book="$book" />
   </div>
</aside>
