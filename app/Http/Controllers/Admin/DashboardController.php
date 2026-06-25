<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\User;
use App\Models\ViewingRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = request()->user();

        $properties = Property::query()->visibleTo($user);

        return view('dashboard', [
            'propertyCount' => (clone $properties)->count(),
            'publishedCount' => (clone $properties)->where('status', Property::STATUS_PUBLISHED)->count(),
            'draftCount' => (clone $properties)->where('status', Property::STATUS_DRAFT)->count(),
            'agentCount' => $user->isAdmin() ? User::agents()->count() : 1,
            'leadCount' => PropertyInquiry::query()
                ->when(! $user->isAdmin(), fn ($query) => $query->where('assigned_agent_id', $user->id))
                ->where('status', 'new')
                ->count(),
            'viewingCount' => ViewingRequest::query()
                ->when(! $user->isAdmin(), fn ($query) => $query->where('agent_id', $user->id))
                ->where('status', 'pending')
                ->count(),
            'latestProperties' => Property::query()->visibleTo($user)->with('agent')->latest()->take(5)->get(),
        ]);
    }
}
