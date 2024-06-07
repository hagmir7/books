<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'title', 'user_id', 'author_id', 'book_category_id',
        'language_id', 'type', 'pages', 'size', 'image', 'description',
        'body', 'tags', 'file', 'is_public', 'slug',
    ];

    protected $dates = ['deleted_at'];


    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function category(){
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();
        if ($ordered) {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
