<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['full_name', 'description', "image", "verified", "slug"];

    public function books(){
        return $this->hasMany(Book::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->full_name, '-');
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


        public function next()
    {
        return static::where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    // Get the previous book based on ID
    public function previous()
    {
        return static::where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate();
    }
}
