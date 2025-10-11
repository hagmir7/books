@extends('layouts.base')

@section('content')
<section class="flex justify-center py-12">
    <div class="w-full container px-4 flex justify-center">
        <div class="flex flex-col">
            <!-- Page Title -->
            <div class="w-full mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
            </div>

            <!-- Page Content -->
            <div class="w-full mx-auto">
                <article class="prose prose-lg prose-gray
                                prose-p:text-base prose-p:leading-relaxed
                                prose-h1:text-3xl prose-h1:font-bold prose-h1:mt-8 prose-h1:mb-4
                                prose-h2:text-2xl prose-h2:font-bold prose-h2:mt-8 prose-h2:mb-4
                                prose-h3:text-xl prose-h3:font-bold prose-h3:mt-6 prose-h3:mb-3
                                prose-h4:text-lg prose-h4:font-bold prose-h4:mt-4 prose-h4:mb-2
                                prose-h5:text-base prose-h5:font-bold prose-h5:mt-4 prose-h5:mb-2
                                prose-h6:text-sm prose-h6:font-bold prose-h6:mt-4 prose-h6:mb-2
                                prose-ul:ml-6 prose-ul:space-y-2 prose-ul:list-disc
                                prose-ol:ml-6 prose-ol:space-y-2 prose-ol:list-decimal
                                prose-li:text-base prose-li:leading-relaxed
                                prose-a:text-primary prose-a:underline prose-a:hover:text-primary/80
                                prose-img:rounded-lg prose-img:shadow-md prose-img:my-6
                                prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:my-4 prose-blockquote:bg-gray-50 prose-blockquote:text-gray-700
                                prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-code:font-mono prose-code:text-gray-800
                                prose-pre:bg-gray-900 prose-pre:text-gray-100 prose-pre:p-4 prose-pre:rounded-lg prose-pre:overflow-x-auto prose-pre:my-4
                                prose-pre code:bg-transparent prose-pre code:p-0 prose-pre code:text-gray-100
                                prose-table:w-full prose-table:border-collapse prose-table:my-6
                                prose-th:border prose-th:border-gray-300 prose-th:px-4 prose-th:py-2 prose-th:text-left prose-th:bg-gray-100 prose-th:font-bold
                                prose-td:border prose-td:border-gray-300 prose-td:px-4 prose-td:py-2 prose-td:text-left
                                prose-hr:my-8 prose-hr:border-gray-300
                                prose-strong:font-bold prose-strong:text-gray-900
                                prose-em:italic
                                prose-figure:my-6 prose-figcaption:text-sm prose-figcaption:text-gray-600 prose-figcaption:text-center prose-figcaption:mt-2
                                prose-ul ul:mt-2 prose-ul ul:mb-0
                                prose-ol ol:mt-2 prose-ol ol:mb-0
                                ">
                    {!! $page->body !!}
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
