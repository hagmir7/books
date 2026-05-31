<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SiteSocial extends Pivot
{
    protected $fillable = [
        'site_id',
        'social_id',
        'url'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function social()
    {
        return $this->belongsTo(Social::class);
    }
}
