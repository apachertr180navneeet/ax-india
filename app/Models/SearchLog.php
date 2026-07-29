<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'query', 'result_count',
    ];

    protected $casts = [
        'result_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
