<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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

        // Delete files from storage whenever the book is deleted.
        static::deleting(function ($book) {
            $book->deleteFiles();
        });
    }


    /**
     * Delete the image and file associated with the book from storage.
     */
    protected function deleteFiles(): void
    {
        // Use getAttributes() to bypass any accessor that might transform the value
        $attributes = $this->getAttributes();

        foreach (['image', 'file'] as $key) {
            $raw = $attributes[$key] ?? null;

            if (!$raw) {
                continue;
            }

            $this->deleteFromStorage($raw);
        }
    }


    /**
     * Delete a single file from storage, handling various path formats.
     */
    protected function deleteFromStorage(string $path): void
    {
        // If the value is a full URL, extract just the path portion
        if (Str::startsWith($path, ['http://', 'https://'])) {
            $path = parse_url($path, PHP_URL_PATH) ?? $path;
        }

        // Normalize: remove leading slash and 'storage/' prefix
        // so the path is relative to the 'public' disk root.
        // Examples:
        //   '/storage/book_files/abc.pdf'        -> 'book_files/abc.pdf'
        //   'storage/book_images/xyz.jpg'        -> 'book_images/xyz.jpg'
        //   'book_files/abc.pdf'                 -> 'book_files/abc.pdf'
        $path = ltrim($path, '/');
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
            return;
        }

        // Fallback: try deleting directly via the filesystem in case the
        // path stored in DB doesn't match what the disk expects.
        $absolute = storage_path('app/public/' . $path);
        if (is_file($absolute)) {
            @unlink($absolute);
        }
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
