<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_send_property_inquiry(): void
    {
        $buyer = User::factory()->create(['role' => User::ROLE_BUYER]);
        $agent = User::factory()->create();
        $property = Property::factory()->create(['agent_id' => $agent->id]);

        $response = $this->actingAs($buyer)->post(route('properties.inquiries.store', $property), [
            'name' => 'Jordan Buyer',
            'email' => 'jordan@example.test',
            'phone' => '(555) 222-3333',
            'preferred_contact' => 'email',
            'message' => 'I would like to schedule a showing and learn more about this property.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('property_inquiries', [
            'property_id' => $property->id,
            'email' => 'jordan@example.test',
            'assigned_agent_id' => $property->agent_id,
            'status' => 'new',
        ]);
    }

    public function test_admin_can_see_property_inquiries_in_leads_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $buyer = User::factory()->create(['role' => User::ROLE_BUYER]);
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $property = Property::factory()->create(['agent_id' => $agent->id, 'title' => 'Lead Visible Home']);

        $this->actingAs($buyer)->post(route('properties.inquiries.store', $property), [
            'name' => 'Jordan Buyer',
            'email' => 'jordan@example.test',
            'preferred_contact' => 'email',
            'message' => 'I would like to schedule a showing and learn more about this property.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.leads.index'))
            ->assertOk()
            ->assertSee('Lead Visible Home')
            ->assertSee('jordan@example.test');
    }
}
