<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AgentProfileController extends Controller
{
    public function show(User $agent): View
    {
        abort_unless($agent->isAgent() && $agent->is_active, 404);

        return view('agents.show', [
            'agent' => $agent->load(['properties' => fn ($query) => $query->published()->with('primaryImage')->latest('published_at')]),
        ]);
    }
}
