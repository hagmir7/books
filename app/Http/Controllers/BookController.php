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

    public function read(Book $book){
        !$book->is_public && abort(403);
        !$book->verified && abort(404);

        if (app('site')->domain == 'agmir.shop') {
            return view('books.redirect');
        }

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

        if(app('site')->domain == 'agmir.shop'){
            return redirect('https://www.yakk.shop/books/'. $book->slug);
        }

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
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $books = Book::with('author')->where('verified', false)
            ->latest()
            ->where('language_id', 2)
            ->where('file', "like", "%pdf%")
            ->take(10)
            ->get();

        $updated = 0;
        $failed = 0;

        foreach ($books as $book) {
            $prompt = <<<PROMPT
        Return only a valid JSON object. Do not include markdown or code block formatting.

        Keys to include in the JSON:
        - "meta_description": a short, SEO-optimized details in Arabic, between 140 and 159 characters (important for seo), ignore (اكتشف).
        - "content": a long, detailed Arabic description of the book (NOT a summary, don't use Introduction (خاتمة) and conclusen (مقدمة)). Write in rich HTML format using only <h2>, <h3>, and <p> tags. The content must be more than 1000 characters.
        - "tags": 8 to 12 relevant Arabic meta keywords related to the book, genre, author, and themes, separated by commas, Type of camma is (,).

        Avoid repeating the same meta description for different books. Do not add introductions or explanations.


        Book Title: "{$book->name}"
        Author: "{$book->author->name}"
        PROMPT;

            try {
                $result = $client->chat()->create([
                    'model' => 'gpt-5',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an assistant that creates improved book long descriptions and meta descriptions. Respond only in valid JSON format.',
                        ],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);


                $content = trim($result->choices[0]->message->content);

                // Clean up markdown if accidentally added
                $content = preg_replace('/^```(?:json)?|```$/', '', $content);

                $data = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error("Invalid JSON from OpenAI for book ID {$book->id}", [
                        'response' => Str::limit($content, 500),
                        'json_error' => json_last_error_msg(),
                    ]);
                    $failed++;
                    continue;
                }

                if (isset($data['meta_description'], $data['content'], $data['tags'])) {
                    if (mb_strlen(strip_tags($data['content'])) < 1000) {
                        Log::warning("Generated content too short for book ID {$book->id}");
                        $failed++;
                        continue;
                    }

                    $book->update([
                        'description' => $data['meta_description'],
                        'body' => $data['content'],
                        'tags' => $data['tags'],
                        'verified' => true,
                        'is_public' => true
                    ]);

                    $updated++;
                } else {
                    Log::warning("Missing keys in OpenAI response for book ID {$book->id}", [
                        'response' => $content,
                    ]);
                    $failed++;
                }

                // Avoid rate limiting
                usleep(500000); // 0.5 second
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
        return view('books.redirect', compact($book));
    }
}
