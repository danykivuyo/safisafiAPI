<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'audio_url',
        'image_url',
        'genre1',
        'genre2',
        'likes',
        'plays',
        'shares',
        'views',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recentPlays()
    {
        return $this->hasMany(RecentPlay::class);
    }

    public function preferences()
    {
        return $this->belongsToMany(Preference::class)
            ->withTimestamps(); // If you use timestamps in pivot table
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_podcasts');
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
