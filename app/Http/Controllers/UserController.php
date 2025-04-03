<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|max:50|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,customer,warehouse_manager,staff',
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors (e.g., duplicate username or email)
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (QueryException $e) {
            
            if ($e->getCode() === '23505') { 
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'users_username_unique') !== false) {
                    return response()->json(['message' => 'Username is already taken.'], 409);
                } elseif (strpos($errorMessage, 'users_email_unique') !== false) {
                    return response()->json(['message' => 'Email is already taken.'], 409);
                }
                return response()->json(['message' => 'Username or email already taken.'], 409);
            }

          
            Log::error('Database error during registration: ' . $e->getMessage());

            return response()->json([
                'message' => 'A database error occurred. Please try again later.',
            ], 500);

        } catch (\Exception $e) {
           
            Log::error('Unexpected error during registration: ' . $e->getMessage());

            
            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
}