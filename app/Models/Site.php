<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain', 'name', 'footer', 'header', 'keywords', 'description', 'email', 'language_id',
        'icon', 'image', 'logo', 'ads_txt', 'site_options'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function urls(){
        return $this->hasMany(Url::class);
    }
}
