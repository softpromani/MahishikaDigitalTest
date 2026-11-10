<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_interest',
        'help_topics',
        'budget',
        'timeline',
        'message',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'help_topics' => 'array',
    ];
}
