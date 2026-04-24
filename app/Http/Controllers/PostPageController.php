<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostPageController extends Controller
{
    public function show(Post $post): View
    {
        abort_if($post->status !== 'published', 404);

        $post->load(['meta', 'blocks']);

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
