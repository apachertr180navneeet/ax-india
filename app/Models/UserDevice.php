<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_name',
        'platform',
        'browser',
        'ip_address',
        'user_agent',
        'is_current_device',
        'last_active_at',
    ];

    protected $casts = [
        'is_current_device' => 'boolean',
        'last_active_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
