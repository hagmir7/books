<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'site_id',
        'title',
        'description',
        'status',
        'priority',
        'user_id',
        'due_date',
        'completed_at',
        'type',
        'tags',
        'image'
    ];

    protected $casts = [
        'status'   => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
