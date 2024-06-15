<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'tags',
        'description',
        'body',
        'slug',
        'user_id',
        'language_id'
    ];

    public function language(){
        return $this->belongsTo(Language::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title, '-');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();
        if ($ordered) {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }
}
