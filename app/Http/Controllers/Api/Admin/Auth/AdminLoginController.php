<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function __invoke(AdminLoginRequest $request): JsonResponse
    {
        $admin = Admin::query()->where('email', $request->string('email')->toString())->first();

        if (! $admin || ! Hash::check($request->string('password')->toString(), $admin->password)) {
            return response()->json([
                'message' => 'The provided admin credentials are invalid.',
                'errors' => [
                    'email' => ['The provided admin credentials are invalid.'],
                ],
            ], 422);
        }

        return response()->json([
            'data' => [
                'token' => $admin->createToken('admin-api-token')->plainTextToken,
                'admin' => $admin,
                'must_change_password' => $admin->must_change_password,
                'two_factor_enabled' => $admin->hasTwoFactorEnabled(),
            ],
        ]);
    }
}
