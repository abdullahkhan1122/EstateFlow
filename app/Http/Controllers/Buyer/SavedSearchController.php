<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\SavedSearch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SavedSearchController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $filters = collect($request->except(['_token', 'name']))->filter(fn ($value) => filled($value))->all();

        SavedSearch::create([
            'user_id' => $request->user()->id,
            'name' => $request->input('name', 'Property search '.now()->format('M j')),
            'filters' => $filters,
            'notify_matches' => true,
        ]);

        return back()->with('status', 'Search saved to your buyer dashboard.');
    }
}
