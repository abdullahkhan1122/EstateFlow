<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyInquiryRequest;
use App\Models\InquiryActivity;
use App\Models\LeadSource;
use App\Models\Property;
use App\Models\PropertyInquiry;
use Illuminate\Http\RedirectResponse;

class PropertyInquiryController extends Controller
{
    public function store(PropertyInquiryRequest $request, Property $property): RedirectResponse
    {
        abort_unless($property->status === Property::STATUS_PUBLISHED, 404);

        $leadSource = LeadSource::firstOrCreate(['name' => 'Website']);
        $inquiry = PropertyInquiry::create($request->validated() + [
            'property_id' => $property->id,
            'assigned_agent_id' => $property->agent_id,
            'lead_source_id' => $leadSource->id,
            'status' => 'new',
            'priority' => 'normal',
            'next_action' => 'Contact buyer',
        ]);

        InquiryActivity::create([
            'property_inquiry_id' => $inquiry->id,
            'type' => 'inquiry_created',
            'description' => 'Inquiry created from public property page.',
        ]);

        return back()->with('status', 'Your inquiry was sent to the listing team.');
    }
}
