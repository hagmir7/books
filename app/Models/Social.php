<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = ['name', 'icon', 'color'];

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_social')
            ->withPivot('url')
            ->withTimestamps();
    }
}
