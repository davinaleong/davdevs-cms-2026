<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LikedPostsController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('user.likes', [
            'likes' => $request->user()
                ->likes()
                ->with('post')
                ->latest()
                ->paginate(20),
        ]);
    }
}
