<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use App\Models\PropertyView;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = request()->user();
        NotificationPreference::firstOrCreate(['user_id' => $user->id]);

        return view('buyer.dashboard', [
            'favorites' => $user->favorites()->with('property.primaryImage')->latest()->get(),
            'savedSearches' => $user->savedSearches()->latest()->get(),
            'viewingRequests' => $user->viewingRequests()->with('property')->latest()->get(),
            'recentViews' => PropertyView::query()->where('user_id', $user->id)->with('property.primaryImage')->latest()->take(6)->get(),
            'notificationPreference' => $user->notificationPreference,
        ]);
    }
}
