<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'user_id',
        'author_id',
        'book_category_id',
        'language_id',
        'type',
        'pages',
        'size',
        'image',
        'description',
        'body',
        'tags',
        'file',
        'is_public',
        'slug',
        'site_id',
        'copyright_date',
        'verified',
        'isbn'
    ];

    protected $dates = ['deleted_at'];


    public function next()
    {
        return static::with(['category', 'author'])->where('id', '>', $this->id)
            ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
            ->orderBy('id', 'asc')
            ->where('is_public', true)
            ->whereNull('copyright_date')
            ->where('verified', true)
            ->first();
    }

    public function previous()
    {
        return static::where('id', '<', $this->id)
            ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
            ->where('verified', true)
            ->where('is_public', true)
            ->whereNull('copyright_date')
            ->orderBy('id', 'desc')
            ->first();
    }


    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            $book->slug = Str::slug($book->name, '-');

            if ($book->size && !Str::contains($book->size, ['MB', 'KB'])) {
                $book->size = round($book->size / 1024, 2) . ' MB';
            }
        });

        // Fires on both soft delete and force delete
        static::deleting(function ($book) {
            $book->deleteFiles();
        });
    }


    /**
     * Delete the image and file associated with the book from storage.
     */
    protected function deleteFiles(): void
    {
        Log::info('[Book::deleteFiles] called', ['book_id' => $this->id]);

        // Read raw DB values, bypassing any accessors
        $attributes = $this->getAttributes();

        foreach (['image', 'file'] as $key) {
            $raw = $attributes[$key] ?? null;

            Log::info("[Book::deleteFiles] {$key} raw value", ['value' => $raw]);

            if (!$raw) {
                continue;
            }

            $this->deleteFromStorage($raw, $key);
        }
    }


    /**
     * Delete a single file from storage.
     */
    protected function deleteFromStorage(string $path, string $label = ''): void
    {
        $original = $path;

        // 1. If it's a full URL (http:// or https://), extract only the path portion.
        //    'https://lacabook.com/storage/book_files/abc.pdf' -> '/storage/book_files/abc.pdf'
        if (Str::startsWith($path, ['http://', 'https://'])) {
            $path = parse_url($path, PHP_URL_PATH) ?: $path;
        }

        // 2. Strip leading slash.   '/storage/book_files/abc.pdf' -> 'storage/book_files/abc.pdf'
        $path = ltrim($path, '/');

        // 3. Strip 'storage/' prefix. 'storage/book_files/abc.pdf' -> 'book_files/abc.pdf'
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        // 4. URL-decode in case the filename was encoded
        $path = urldecode($path);

        $disk = Storage::disk('public');
        $absolute = storage_path('app/public/' . $path);

        Log::info("[Book::deleteFiles] normalized {$label}", [
            'original'       => $original,
            'normalized'     => $path,
            'disk_exists'    => $disk->exists($path),
            'absolute_path'  => $absolute,
            'file_exists'    => is_file($absolute),
        ]);

        // Try the disk API first
        if ($disk->exists($path)) {
            $disk->delete($path);
            Log::info("[Book::deleteFiles] deleted via disk", ['path' => $path]);
            return;
        }

        // Fallback: direct unlink
        if (is_file($absolute)) {
            @unlink($absolute);
            Log::info("[Book::deleteFiles] deleted via unlink", ['path' => $absolute]);
            return;
        }

        Log::warning("[Book::deleteFiles] file not found", [
            'label'    => $label,
            'original' => $original,
            'tried'    => $absolute,
        ]);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug', 'id')
            ->slugsShouldBeNoLongerThan(55)
            ->doNotGenerateSlugsOnUpdate();
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
