<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use App\Models\ViewingRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $inquiries = PropertyInquiry::query()
            ->when(! $user->isAdmin(), fn ($query) => $query->where('assigned_agent_id', $user->id))
            ->with(['property.primaryImage', 'assignedAgent'])
            ->latest()
            ->paginate(10, ['*'], 'inquiries_page')
            ->withQueryString();

        $viewingRequests = ViewingRequest::query()
            ->when(! $user->isAdmin(), fn ($query) => $query->where('agent_id', $user->id))
            ->with(['property.primaryImage', 'agent'])
            ->latest()
            ->paginate(10, ['*'], 'viewings_page')
            ->withQueryString();

        return view('admin.leads.index', [
            'inquiries' => $inquiries,
            'viewingRequests' => $viewingRequests,
            'newInquiryCount' => PropertyInquiry::query()
                ->when(! $user->isAdmin(), fn ($query) => $query->where('assigned_agent_id', $user->id))
                ->where('status', 'new')
                ->count(),
            'pendingViewingCount' => ViewingRequest::query()
                ->when(! $user->isAdmin(), fn ($query) => $query->where('agent_id', $user->id))
                ->where('status', 'pending')
                ->count(),
        ]);
    }
}
