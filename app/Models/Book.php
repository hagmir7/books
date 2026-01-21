<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'title', 'user_id', 'author_id', 'book_category_id',
        'language_id', 'type', 'pages', 'size', 'image', 'description',
        'body', 'tags', 'file', 'is_public', 'slug', 'site_id',
        'copyright_date', 'verified','isbn'

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


    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }


    public function category() : BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function site(){
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
