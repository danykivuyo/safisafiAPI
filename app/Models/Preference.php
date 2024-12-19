<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function podcasts()
    {
        return $this->belongsToMany(Podcast::class)
            ->withTimestamps(); // If you use timestamps in pivot table
    }
}
