<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RatingController extends Controller
{
    public function index() : View {
        return view('ratings.index', [
            'ratings' => Rating::with('user')->latest()->get(),
        ]);
    }

    public function show(Rating $rating) : View {
        return view('ratings.view', [
            'rating' => $rating,
        ]);
    }

    public function store(Request $request) : RedirectResponse {
        $validated = $request->validate([
            'artist' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'stars' => 'required|integer|lte:5|gte:0',
        ]);

        $request->user()->ratings()->create($validated);

        return redirect(route('ratings.index'));
    }
    public function edit(Rating $rating): View
    {
        $this->authorize('update', $rating);

        return view('ratings.edit', [
            'rating' => $rating,
        ]);
    }

    public function update(Request $request, Rating $rating): RedirectResponse
    {
        $this->authorize('update', $rating);

        $validated = $request->validate([
            'artist' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'stars' => 'required|integer|lte:5|gte:0',
        ]);

        $rating->update($validated);

        return redirect(route('ratings.index'));
    }

    public function destroy(Rating $rating): RedirectResponse
    {
        $this->authorize('delete', $rating);

        $rating->delete();

        return redirect(route('ratings.index'));
    }
}
