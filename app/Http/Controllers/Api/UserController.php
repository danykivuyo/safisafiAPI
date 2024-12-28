<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate a token
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['user_id' => $user->user_id, 'token' => $token]);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'name' => 'required',
                'mobile_number' => 'required',
                'country' => 'required',
                'region' => 'required'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Missing required parameters"
            ], 401);
        }

        $res = $this->createUserOrReturnExisting(
            $request->email,
            $request->password,
            $request->name,
            $request->mobile_number,
            $request->country,
            $request->region,
            $request->preference1,
            $request->preference2,
            $request->preference3,
            $request->preference4
        );

        //failed to register
        if ($res['success'] == false) {
            $response = [
                'status' => false,
                'message' => $res['message'],
            ];

            return response()->json($response, 401);
        }

        //user registered
        else if ($res['data']['status'] == 2) {
            $response = [
                'status' => true,
                'message' => "User already registered",
                'data' => [
                    'user' => $res['data']['user']
                ]
            ];

            return response()->json($response, 200);
        }

        //created
        else {
            $response = [
                'status' => true,
                'message' => "User created successfully",
                'data' => $res['data'],
            ];

            return response()->json($response, 200);
        }

    }


    protected function createUserOrReturnExisting(string $email, string $password, string $name, string $mobile_number, string $country, string $region, string $preference1 = null, string $preference2 = null, string $preference3 = null, string $preference4 = null)
    {
        try {
            $user = User::create([
                'email' => $email,
                'password' => $password,
                'name' => $name,
                'mobile_number' => $mobile_number,
                'country' => $country,
                'region' => $region,
                'preference1' => $preference1,
                'preference2' => $preference2,
                'preference3' => $preference3,
                'preference4' => $preference4,
            ]);

            $res = [
                'status' => true,
                'message' => "User created successfully",
                'data' => [
                    'user' => $user
                ]
            ];
            return $res;
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $user = User::where('email', $email)->first();
                $res = [
                    'success' => false,
                    'message' => 'User exists',
                    'data' => [
                        'status' => 2,
                        'user' => $user
                    ]
                ];
                return $res;
            }
            $res = [
                'success' => false,
                'message' => $e
            ];
        }
    }

}