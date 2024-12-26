<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-many: Playlist has many Podcasts
    public function podcasts()
    {
        return $this->belongsToMany(Podcast::class, 'playlist_podcasts');
    }
}
