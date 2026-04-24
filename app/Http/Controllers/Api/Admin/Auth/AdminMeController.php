<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminMeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if (! $request->user() instanceof Admin) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        return response()->json([
            'data' => [
                'admin' => $request->user(),
                'must_change_password' => $request->user()->must_change_password,
            ],
        ]);
    }
}
