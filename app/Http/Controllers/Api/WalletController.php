<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $user_id = $request->input('user_id');
            // return response()->json([
            //     'user_id' => $user_id
            // ], 200);
            $user = User::firstWhere('user_id', '=', $user_id);
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

            $user_id = $request->input('user_id');

            $user = User::first($user_id);
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
                'deduct_amount' => 'required|numeric',
            ]);

            $user_id = $request->input('user_id');
            $deduct_amount = $request->input('deduct_amount');

            try {
                DB::beginTransaction();
                //accessing user's wallet
                $user = User::firstWhere('user_id', '=', $user_id);
                $user->wallet->balnce -= $deduct_amount;
                if ($user->wallet->save()) {
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => "Successfully deducted",
                        "data" => [
                            "balance" => $user->wallet->balance,
                        ],
                    ], 200);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Could not update data 1",
                    ], 500);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Could not update data",
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    public function recharge_coin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string|exists:users,user_id',
                'recharge_amount' => 'required|numeric',
            ]);
            $user_id = $request->input('user_id');
            $recharge_amount = $request->input('recharge_amount');

            try {
                DB::beginTransaction();
                $user = User::firstWhere('user_id', '=', $user_id);
                $user->wallet->balance += $recharge_amount;

                //actual amount
                $user->wallet->actual_balance += $recharge_amount;
                
                if ($user->wallet->save()) {
                    DB::commit();
                    return response()->json([
                        "success" => true,
                        "message" => "Recharge sucessfull",
                        "data" => [
                            "balance" => $user->wallet->balance,
                        ]
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json([
                        "success" => false,
                        "message" => "Failed to update data",
                        "data" => [
                            "balance" => $user->wallet->balance,
                        ],
                    ], 500);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    "success" => false,
                    "message" => "Could not update data",
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        }

    }
}
