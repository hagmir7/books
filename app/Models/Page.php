<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Page extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'slug', 'language_id', 'site_id'];


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

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function language()
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
}
