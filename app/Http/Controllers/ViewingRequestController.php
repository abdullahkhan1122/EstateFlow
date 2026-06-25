<?php

namespace App\Http\Controllers;

use App\Models\InquiryActivity;
use App\Models\Property;
use App\Models\ViewingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewingRequestController extends Controller
{
    public function store(Request $request, Property $property): RedirectResponse
    {
        abort_unless($property->status === Property::STATUS_PUBLISHED, 404);

        $data = $request->validate([
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'viewing_type' => ['required', 'in:in_person,virtual'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:1500'],
        ]);

        $viewing = ViewingRequest::create($data + [
            'property_id' => $property->id,
            'agent_id' => $property->agent_id,
            'user_id' => $request->user()?->id,
        ]);

        foreach ($property->inquiries()->where('email', $data['email'])->get() as $inquiry) {
            InquiryActivity::create([
                'property_inquiry_id' => $inquiry->id,
                'type' => 'viewing_scheduled',
                'description' => 'Viewing requested for '.$viewing->preferred_date->format('M j, Y').' at '.substr($viewing->preferred_time, 0, 5).'.',
            ]);
        }

        return back()->with('status', 'Viewing request submitted.');
    }
}
