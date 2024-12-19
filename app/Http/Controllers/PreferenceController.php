<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    //
    public function index(Request $request)
    {
        $preferences = Preference::all();
        return response()->json([
            'success' => true,
            'message' => 'Fetched successfully',
            'data' => ['preferences' => $preferences]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
    }
}
