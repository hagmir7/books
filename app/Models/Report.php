<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $fillable = ['full_name', 'subject', 'content', 'readed_at', 'email', 'book_id'];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
