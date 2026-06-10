<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['site_id', 'language_id', 'full_name', 'email', 'status'];


    public function language()
    {
        return $this->belongsTo(Language::class);
    }


    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
