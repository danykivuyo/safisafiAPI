<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentPlay extends Model
{
    use HasFactory;
    protected $fillable = [
        'podcast_id',
        'user_id',
        'played_at',
        'device',
    ];

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
