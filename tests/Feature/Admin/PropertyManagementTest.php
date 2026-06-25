<?php

namespace Tests\Feature\Admin;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_property(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);

        $response = $this->actingAs($admin)->post(route('admin.properties.store'), [
            'agent_id' => $agent->id,
            'title' => 'Maple Park Residence',
            'type' => 'House',
            'status' => 'published',
            'listing_type' => 'For Sale',
            'price' => 620000,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'area_sqft' => 2400,
            'address' => '120 Maple Park Drive',
            'city' => 'Austin',
            'state' => 'TX',
            'zip_code' => '78701',
            'description' => str_repeat('A polished property with clear spaces for daily living. ', 3),
            'features' => 'Garage, Patio',
            'image_path' => 'https://example.com/home.jpg',
        ]);

        $response->assertRedirect(route('admin.properties.index'));
        $this->assertDatabaseHas('properties', ['title' => 'Maple Park Residence', 'agent_id' => $agent->id]);
        $this->assertDatabaseHas('property_images', ['path' => 'https://example.com/home.jpg']);

        $property = Property::where('title', 'Maple Park Residence')->first();
        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee('Maple Park Residence');
    }

    public function test_agent_cannot_edit_another_agents_property(): void
    {
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $otherAgent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $property = Property::factory()->create(['agent_id' => $otherAgent->id]);

        $this->actingAs($agent)->get(route('admin.properties.edit', $property))->assertForbidden();
    }

    public function test_buyer_cannot_access_admin_property_management(): void
    {
        $buyer = User::factory()->create(['role' => User::ROLE_BUYER]);

        $this->actingAs($buyer)->get(route('admin.properties.index'))->assertForbidden();
    }

    public function test_admin_cannot_use_buyer_property_actions(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $property = Property::factory()->create(['agent_id' => $agent->id]);

        $this->actingAs($admin)->post(route('properties.favorite.toggle', $property))->assertForbidden();
        $this->actingAs($admin)->get(route('buyer.dashboard'))->assertForbidden();
    }
}
