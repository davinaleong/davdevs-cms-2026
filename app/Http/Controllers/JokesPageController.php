<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Contracts\View\View;

class JokesPageController extends Controller
{
    public function __invoke(): View
    {
        $joke = Joke::query()->active()->inRandomOrder()->first();

        return view('jokes.index', [
            'joke' => $joke,
        ]);
    }
}
