<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Comment;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OpenAI;

class BookController extends Controller
{


    public function index()
    {
        return view("books.list");
    }

    public function books()
    {
        return view('home', [
            'books' => Book::with(['author', 'category'])
                ->whereHas('language', fn(Builder $query) => ($query->where('code', app()->getLocale())))
                ->where('verified', true)
                ->latest()->paginate(30)
        ]);
    }

    public function read(Book $book)
    {
        !$book->is_public && abort(403);
        !$book->verified && abort(404);

        // if (app('site')->domain == 'agmir.shop') {
        //     return view('books.redirect', compact('book'));
        // }

        $book->load(['author', 'language', 'category']);

        return view("books.read", [
            "book" => $book,
            "title" => str_replace(":attr", $book->name, app('site')->site_options['read_book_title']),
            "description" => \Illuminate\Support\Str::limit($book->description, 160),
            "tags" => $book->tags,
            "author" => $book->author->full_name,
            "image" => $book->image,
            "rating" => Comment::where("book_id", $book->id)->avg('stars')
        ]);
    }


    public function show(Book $book)
    {
        !$book->is_public && abort(403);
        !$book->verified && abort(404);

        app()->setLocale($book->language->code);

        return view("books.show", [
            "book" => $book,
            "title" => str_replace(":attr", $book->name, app('site')->site_options['book_title']),
            "description" => \Illuminate\Support\Str::limit($book->description, 160),
            "tags" => $book->tags,
            "author" => $book->author->full_name,
            "image" => $book->image,
            "rating" => Comment::where("book_id", $book->id)->avg('stars')
        ]);
    }


    public function create()
    {
        return view('books.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'title' => 'nullable|string|max:150',
            'user_id' => 'required|exists:users,id',
            'author_id' => 'nullable|exists:authors,id',
            'book_category_id' => 'nullable|exists:book_categories,id',
            'language_id' => 'nullable|exists:languages,id',
            'pages' => 'nullable|integer',
            'size' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:10',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'tags' => 'nullable|string|max:500',
            'file' => 'nullable|string',
            'is_public' => 'boolean',
            'slug' => 'nullable|string|unique:books,slug',
        ]);

        $book = Book::create([
            'name' => $request->name,
            'title' => $request->title,
            'user_id' => $request->user_id,
            'author_id' => $request->author_id,
            'book_category_id' => $request->book_category_id,
            'language_id' => $request->language_id,
            'pages' => $request->pages,
            'size' => $request->size,
            'type' => $request->type,
            'image' => $request->image,
            'description' => $request->description,
            'body' => $request->body,
            'tags' => $request->tags,
            'file' => $request->file,
            'is_public' => $request->is_public,
            'slug' => $request->slug,
        ]);

        return response()->json($book, 201);
    }




    public function api_list()
    {
        return BookResource::collection(Book::where('is_public', true)->paginate(20));
    }

    public function api_show(Book $book)
    {
        return BookResource::make($book);
    }


    public function uploadBooks(Request $request)
    {
        $request->validate([
            'books_file' => 'required|file|mimes:json'
        ]);

        $jsonContent = file_get_contents($request->file('books_file'));
        $books = json_decode($jsonContent, true);

        if (!is_array($books)) {
            return response()->json(['message' => 'Invalid JSON structure'], 422);
        }

        foreach ($books as $book) {
            $category = BookCategory::firstOrCreate(['name' => $book['category']]);

            $author = Author::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($book['author'])],
                ['full_name' => $book['author'], 'verified' => false]
            );

            $filePath = basename($book['file']);


            $imagePath = basename($book['image']);


            Book::firstOrCreate(['name' => $book['name']], [
                'author_id' => $author->id,
                'file' => "book_files/" . $filePath,
                'image' => "book_images/" . $imagePath,
                'pages' => $book['pages'],
                'size' => $book['size'],
                'description' => $book['description'],
                'tags' => $book['tags'],
                'type' => "PDF",
                'book_category_id' => $category->id,
                'language_id' => 2,
                'user_id' => 1,
                'verified' => false,
            ]);
        }

        return response()->json([
            'message' => 'Books uploaded successfully',
            'books_count' => count($books)
        ], 201);
    }





    public function updateAndPublishBooksWithSdk(): \Illuminate\Http\JsonResponse
    {
        $client = OpenAI::client(config('services.openai.api_key'));

        $books = Book::with('author')->where('verified', false)
            ->latest()
            ->where('language_id', 2)
            ->where('file', 'like', '%pdf%')
            ->take(10)
            ->get();

        $updated = 0;
        $failed = 0;

        foreach ($books as $book) {
            $bookName = $book->name;
            $authorName = $book->author->name;

            $systemPrompt = <<<SYSTEM
أنت كاتب محتوى عربي محترف ومتخصص في وصف الكتب وتحسين محركات البحث (SEO).

## مهمتك
إنشاء وصف تفصيلي غني ووسوم وصفية لكتب عربية.

## قواعد صارمة
- أجب **فقط** بكائن JSON صالح. لا تضف أي نص قبله أو بعده.
- لا تستخدم علامات markdown مثل ```json أو ```.
- لا تبدأ أي نص بكلمة "اكتشف".
- لا تكرر نفس الوصف التعريفي لكتب مختلفة.

## بنية JSON المطلوبة
{
  "meta_description": "...",
  "content": "...",
  "tags": "..."
}
SYSTEM;

            $userPrompt = <<<PROMPT
اكتب محتوى للكتاب التالي:
- **عنوان الكتاب**: "{$bookName}"
- **المؤلف**: "{$authorName}"

---

### meta_description
وصف تعريفي قصير بالعربية محسّن لمحركات البحث.
- الطول: بين 140 و 159 حرفاً بالضبط (هذا شرط أساسي).
- يجب أن يكون جذاباً ويحتوي على اسم الكتاب والمؤلف.
- لا تبدأ بكلمة "اكتشف".
- لا تستخدم علامات HTML.

### content
وصف تفصيلي طويل وشامل للكتاب بالعربية — وليس ملخصاً.
- **الطول**: أكثر من 1500 حرف (كلما كان أطول وأغنى كان أفضل).
- **التنسيق**: HTML فقط باستخدام وسوم <h2> و <h3> و <p>. لا تستخدم أي وسوم أخرى.
- **الأسلوب**: اكتب بأسلوب أدبي جذاب ومتنوع. نوّع في طول الجمل واستخدم لغة حية.
- **البنية المقترحة**:
  - تقديم عن الكتاب وسياقه الأدبي والثقافي
  - أبرز المحاور والأفكار التي يتناولها الكتاب (3-5 محاور)
  - أسلوب المؤلف وما يميز هذا العمل
  - لمن يُنصح بقراءة هذا الكتاب ولماذا
- **ممنوع**: لا تستخدم كلمة "مقدمة" أو "خاتمة" كعناوين. لا تكتب ملخصاً للفصول.
- لا تكرر نفس الفكرة في أكثر من فقرة.

### tags
من 8 إلى 12 كلمة مفتاحية عربية مرتبطة بالكتاب.
- تشمل: اسم الكتاب، اسم المؤلف، النوع الأدبي، الموضوعات الرئيسية.
- مفصولة بفاصلة إنجليزية (,) وليست فاصلة عربية (،).
- مثال: "رواية عربية,اسم المؤلف,اسم الكتاب,أدب معاصر,..."
PROMPT;

            try {
                $result = $client->chat()->create([
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.7,
                    'response_format' => ['type' => 'json_object'],
                ]);

                $content = trim($result->choices[0]->message->content);
                $data = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error("Invalid JSON from OpenAI for book ID {$book->id}", [
                        'response' => Str::limit($content, 500),
                        'json_error' => json_last_error_msg(),
                    ]);
                    $failed++;
                    continue;
                }

                $missingKeys = array_diff(['meta_description', 'content', 'tags'], array_keys($data));
                if (!empty($missingKeys)) {
                    Log::warning("Missing keys in OpenAI response for book ID {$book->id}", [
                        'missing' => $missingKeys,
                    ]);
                    $failed++;
                    continue;
                }

                $contentLength = mb_strlen(strip_tags($data['content']));
                $metaLength = mb_strlen($data['meta_description']);

                if ($contentLength < 1000) {
                    Log::warning("Content too short for book ID {$book->id}: {$contentLength} chars");
                    $failed++;
                    continue;
                }

                if ($metaLength < 140 || $metaLength > 159) {
                    Log::warning("Meta description out of range for book ID {$book->id}: {$metaLength} chars");
                    // Don't fail — truncate or let it pass, since content is valid
                }

                $book->update([
                    'description' => $data['meta_description'],
                    'body' => $data['content'],
                    'tags' => $data['tags'],
                    'verified' => true,
                    'is_public' => true,
                ]);

                $updated++;

                usleep(500000);
            } catch (\Exception $e) {
                Log::error("OpenAI API call failed for book ID {$book->id}", [
                    'error' => $e->getMessage(),
                ]);
                $failed++;
            }
        }

        return response()->json([
            'message' => 'Books processed',
            'updated' => $updated,
            'failed' => $failed,
        ]);
    }


    public function redirector(Book $book)
    {
        return view('books.redirect', compact('book'));
    }


    public function cerate(){
        return view('books.create');
    }
}
