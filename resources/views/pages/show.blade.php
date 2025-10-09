@extends('layouts.base')

@section('content')
<section class="flex m-auto py-12">
    <div class="min-w-6xl px-4">
        <div class="flex flex-wrap">
            <!-- Page Title -->
            <div class="w-full mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $page->title }}</h1>
            </div>

            <!-- Page Content -->
            <div class="w-full">
                <div class="page-content max-w-4xl prose prose-lg">
                    {!! $page->body !!}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Tailwind Typography styles for page content */
    .page-content {
        @apply text-gray-800 leading-relaxed;
    }

    .page-content h1 {
        @apply text-3xl font-bold mt-8 mb-4 text-gray-900;
    }

    .page-content h2 {
        @apply text-2xl font-bold mt-8 mb-4 text-gray-900;
    }

    .page-content h3 {
        @apply text-xl font-bold mt-6 mb-3 text-gray-900;
    }

    .page-content h4 {
        @apply text-lg font-bold mt-4 mb-2 text-gray-900;
    }

    .page-content h5 {
        @apply text-base font-bold mt-4 mb-2 text-gray-900;
    }

    .page-content h6 {
        @apply text-sm font-bold mt-4 mb-2 text-gray-900;
    }

    .page-content p {
        @apply mb-4 text-base leading-relaxed;
    }

    .page-content ul,
    .page-content ol {
        @apply mb-4 ml-6 space-y-2;
    }

    .page-content ul {
        @apply list-disc;
    }

    .page-content ol {
        @apply list-decimal;
    }

    .page-content li {
        @apply text-base leading-relaxed;
    }

    .page-content a {
        @apply text-primary underline hover: text-primary/80 transition-colors;
    }

    .page-content img {
        @apply rounded-lg shadow-md my-6 max-w-full h-auto;
    }

    .page-content blockquote {
        @apply border-l-4 border-primary pl-4 italic my-4 text-gray-700 bg-gray-50 py-2;
    }

    .page-content code {
        @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono text-gray-800;
    }

    .page-content pre {
        @apply bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto my-4;
    }

    .page-content pre code {
        @apply bg-transparent p-0 text-gray-100;
    }

    .page-content table {
        @apply w-full border-collapse my-6;
    }

    .page-content th,
    .page-content td {
        @apply border border-gray-300 px-4 py-2 text-left;
    }

    .page-content th {
        @apply bg-gray-100 font-bold;
    }

    .page-content hr {
        @apply my-8 border-gray-300;
    }

    .page-content strong {
        @apply font-bold text-gray-900;
    }

    .page-content em {
        @apply italic;
    }

    /* Responsive images in content */
    .page-content figure {
        @apply my-6;
    }

    .page-content figcaption {
        @apply text-sm text-gray-600 text-center mt-2;
    }

    /* Nested lists */
    .page-content ul ul,
    .page-content ol ol,
    .page-content ul ol,
    .page-content ol ul {
        @apply mt-2 mb-0;
    }
</style>
@endsection
