<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Album::firstOrCreate(
            ['title' => 'No Album'], // Check if an album with this title exists
            [
                'description' => 'Default album for items without a specific album.',
                'type' => 'podcast', // You can adjust this if needed
                'artist_name' => 'System', // A default name for the artist
                'cover_image' => null, // No cover image
                'genre' => null, // No specific genre
                'release_date' => now(), // Default to the current date
                'user_id' => null, // Optionally assign to a specific user, or leave as null
            ]
        );
    }
}
