<?php

namespace App\Http\Controllers\Web;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredPosts = Post::query()
            ->published()
            ->whereIn('post_type', [PostType::Project->value, PostType::Tool->value])
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('site.home', [
            'featuredPosts' => $featuredPosts,
        ]);
    }
}
