<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'footer', 'header', 'new_tab', 'site_id'];


    public function site(){
        return $this->belongsTo(Site::class);
    }
}
