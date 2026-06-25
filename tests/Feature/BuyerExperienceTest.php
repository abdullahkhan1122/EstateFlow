<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyerExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_view_dashboard_with_favorites(): void
    {
        $buyer = User::factory()->create(['role' => User::ROLE_BUYER]);
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $property = Property::factory()->create(['agent_id' => $agent->id, 'title' => 'Saved Buyer Home']);
        Favorite::create(['user_id' => $buyer->id, 'property_id' => $property->id]);

        $this->actingAs($buyer)
            ->get(route('buyer.dashboard'))
            ->assertOk()
            ->assertSee('Saved Buyer Home');
    }

    public function test_buyer_can_request_viewing(): void
    {
        $buyer = User::factory()->create(['role' => User::ROLE_BUYER]);
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);
        $property = Property::factory()->create(['agent_id' => $agent->id]);

        $this->actingAs($buyer)->post(route('properties.viewings.store', $property), [
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '14:30',
            'viewing_type' => 'in_person',
            'name' => 'Taylor Visitor',
            'email' => 'taylor@example.test',
            'phone' => '(555) 444-1111',
            'message' => 'I would like to see this property in person.',
        ])->assertRedirect();

        $this->assertDatabaseHas('viewing_requests', [
            'property_id' => $property->id,
            'email' => 'taylor@example.test',
            'status' => 'pending',
        ]);
    }
}
