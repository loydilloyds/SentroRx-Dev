<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctorsNumber',
        'specialization'
    ];

    public function user() : belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments() : HasMany
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }
}
