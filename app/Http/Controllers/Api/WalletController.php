<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use PHPUnit\TextUI\XmlConfiguration\FailedSchemaDetectionResult;

class WalletController extends Controller
{
    //
    //specific user number of coin
    public function balance(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string|exists:users,user_id',
            ]);

            $userId = $request->input('user_id');
            // return response()->json([
            //     'user_id' => $userId
            // ], 200);
            $user = User::firstWhere('user_id', '=', $userId);
            if ($user) {
                $balance = $user->wallet->balance;
                if ($balance || $balance == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => "Balance fetched successfully",
                        'data' => [
                            'balance' => $balance,
                        ],
                    ], 200);
                }
                return response()->json([
                    'success' => false,
                    'message' => "Could not retrive balance",
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "User not found",
                ], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function actual_balance(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $userId = $request->input('user_id');

            $user = User::first($userId);
            if ($user) {
                $balance = $user->wallet->actual_balance;
                if ($balance || $balance == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => "Balance fetched successfully",
                        'data' => [
                            'balance' => $balance,
                        ],
                    ], 200);
                }
                return response()->json([
                    'success' => false,
                    'message' => "Could not retrive balance",
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "User not found",
                ], 200);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function deduct_coin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string|exists:users,user_id',
            ]);
            $userId = $request->input('user_id');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function recharge_coin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string|exists:users,user_id',
            ]);
            $userId = $request->input('user_id');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }

    }
}
