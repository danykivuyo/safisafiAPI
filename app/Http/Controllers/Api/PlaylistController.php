<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    protected $user;

    /**
     * Attach podcasts to a playlist.
     */
    public function add_to_playlist(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,user_id',
                'podcast_id.*' => 'required',
            ]);

            try {
                $playlist_name = $request->input('playlist_name');
                $podcast_ids = $request->input('podcast_id');
            } catch (\Exception $e) {
                // return response()->json([
                //     "success" => false,
                // ]);
            }
            if (isset($request->playlist_name)) {

                $this->user = User::where("user_id", $request->user_id)->first();
                // return response()->json($this->user);
                $playlist = $this->user->playlists()->create([
                    'name' => $playlist_name,
                ]);

                $playlist->podcasts()->attach($podcast_ids);
                return response()->json([
                    'success' => true,
                    'message' => "Added to playlist $playlist_name"
                ], 200);
            } else {

            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Incorrect JSON data sent: $e"
            ]);
        }
    }

    public function get_playlists(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,user_id',
            ]);
            $this->user = User::where('user_id', $request->user_id)->first();
            $playlists = $this->user->playlists()->select('name')->get();

            return response()->json($playlists, 200);
        } catch (\Exception $e) {
        }
    }

    public function get_podcasts_by_playlist(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,user_id',
                'playlist_name' => 'required|exists:playlist,name'
            ]);

            $this->user = User::where('user_id', $request->user_id)->first();
            $podcasts = $this->user->playlists()->where('name', $request->playlist_name)->get();

            return response()->json([
                'success' => true,
                'message' => "Fetched successfully",
                'data' => $podcasts
            ]);
        } catch (\Exception $e) {

        }
    }
}
