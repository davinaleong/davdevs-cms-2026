<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joke;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JokeController extends Controller
{
    public function index(): View
    {
        return view('admin.jokes.index', [
            'jokes' => Joke::query()->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.jokes.form', [
            'joke' => new Joke,
            'method' => 'POST',
            'action' => route('admin.jokes.store'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Joke::query()->create($this->validatedData($request));

        return redirect()->route('admin.jokes.index')->with('status', 'Joke created.');
    }

    public function show(Joke $joke): RedirectResponse
    {
        return redirect()->route('admin.jokes.edit', $joke);
    }

    public function edit(Joke $joke): View
    {
        return view('admin.jokes.form', [
            'joke' => $joke,
            'method' => 'PUT',
            'action' => route('admin.jokes.update', $joke),
        ]);
    }

    public function update(Request $request, Joke $joke): RedirectResponse
    {
        $joke->update($this->validatedData($request));

        return redirect()->route('admin.jokes.edit', $joke)->with('status', 'Joke updated.');
    }

    public function destroy(Joke $joke): RedirectResponse
    {
        $joke->delete();

        return redirect()->route('admin.jokes.index')->with('status', 'Joke deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:statement,qa'],
            'question' => ['nullable', 'string', 'required_if:type,qa'],
            'answer' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
