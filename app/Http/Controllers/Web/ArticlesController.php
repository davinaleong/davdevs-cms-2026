<?php

namespace App\Http\Controllers\Web;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class ArticlesController extends Controller
{
    public function index(): View
    {
        $articles = Post::query()
            ->published()
            ->where('post_type', PostType::Project->value)
            ->latest('published_at')
            ->paginate(12);

        return view('site.articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show(Post $post): View
    {
        abort_if($post->status !== 'published', 404);

        return view('posts.show', [
            'post' => $post->load(['meta', 'blocks', 'tool'])->loadCount('likes'),
        ]);
    }
}
