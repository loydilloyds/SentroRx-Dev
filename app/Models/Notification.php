<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'isAnnouncement',
        'recipients',
    ];

    protected $casts = [
        'isAnnouncement' => 'boolean',
    ];
}
