<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminForcePasswordChangeRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AdminForcePasswordChangeController extends Controller
{
    public function __invoke(AdminForcePasswordChangeRequest $request): JsonResponse
    {
        if (! $request->user() instanceof Admin) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        if (! Hash::check($request->string('current_password')->toString(), $request->user()->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
                'errors' => [
                    'current_password' => ['The current password is incorrect.'],
                ],
            ], 422);
        }

        $request->user()->update([
            'password' => $request->string('password')->toString(),
            'must_change_password' => false,
        ]);

        return response()->json([
            'data' => [
                'must_change_password' => false,
            ],
        ]);
    }
}
