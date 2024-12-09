<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function index()
    {
        return response()->json(Podcast::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audio_url' => 'required|url',
        ]);

        $podcast = Podcast::create($request->all());

        return response()->json($podcast, 201);
    }
}
