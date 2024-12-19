<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        return response()->json(Podcast::all(), 200);
    }

    public function fillter_popular(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string|exists:users,user_id',
            ]);
            $user_id = $request->input();

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audio_url' => 'required|url',
            'image_url' => 'required|url',
        ]);
        $podcast = Podcast::create($request->all());
        return response()->json($podcast, 201);
    }

    public function attach_podcast_preference(Request $request)
    {
        $request->validate([
            'podcast_id' => 'required',
            'preference_id' => 'required'
        ]);
        $podcast = Podcast::find($request->podcast_id);
        if ($podcast->preferences()->attach($request->preference_id)) {
            return response()->json([
                'success' => true,
                'message' => 'Attached Successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Attach'
            ], 200);
        }
    }

    public function detach_podcast_preference(Request $request)
    {
        $request->validate([
            'podcast_id' => 'required',
            'preference_id' => 'required'
        ]);

        $podcast = Podcast::find($request->podcast_id);
        if ($podcast->preferences()->detach($request->preference_id)) {
            return response()->json([
                'success' => true,
                'message' => 'Dettached Successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Dettach'
            ], 200);
        }

    }
}
