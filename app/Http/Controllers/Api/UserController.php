<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'phone'=>'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'nullable|in:admin,employees',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? "employees",
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => $user,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'phone'=>'required|numeric',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,employees',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'role' => $request->role,
            'status' => $request->status ?? $user->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Email not found',
            ], 404);
        }

        if ($user->lock_until && now()->lessThan($user->lock_until)) {
            return response()->json([
                'status' => false,
                'message' => 'Account locked for 24 hours',
            ], 403);
        }

        if (! Hash::check($request->password, $user->password)) {
            $user->increment('login_attempts');

            if ($user->login_attempts >= 5) {
                $user->update([
                    'lock_until' => now()->addHours(24),
                    'login_attempts' => 0,
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'Account locked for 24 hours',
                ], 403);
            }

            return response()->json([
                'status' => false,
                'message' => 'Wrong password',
                'attempts_left' => 5 - $user->login_attempts,
            ], 401);
        }

        $user->update([
            'login_attempts' => 0,
            'lock_until' => null,
        ]);

        $user->tokens()->delete();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user->only('id', 'name', 'email', 'role'),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Login first!',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => ucfirst($user->role).' profile',
            'data' => $user,
        ], 200);
    }
}
