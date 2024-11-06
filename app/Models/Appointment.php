<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'date',
        'time',
        'remarks',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function health_center(): BelongsTo
    {
        return $this->belongsTo(HealthCenter::class)->withDefault();
    }

    public function doctor() : BelongsTo
    {
        return $this->belongsTo(Doctor::class)->withDefault();
    }
}
