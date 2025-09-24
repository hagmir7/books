<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BookCategory extends Model
{
    use HasFactory;
    protected $fillable = ["name", 'title',  "image", "description", 'language', "slug"];


    public function books() : HasMany {
        return $this->hasMany(Book::class);
    }


    public function language():BelongsTo
    {
        return $this->belongsTo(Language::class);
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }

}
