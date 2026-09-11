<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalNotification extends Model
{
    use HasFactory;

    protected $table = 'internal_notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'notifiable_role',
        'is_read',
        'related_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
