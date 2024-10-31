<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctorsNumber',
        'specialization'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function name() : string
    {
        return $this->user()->firstName . ' ' . $this->user()->middleName . ' ' . $this->user()->lastName;
    }
}
