<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_featured_properties(): void
    {
        $agent = User::factory()->create();
        $property = Property::factory()->create([
            'agent_id' => $agent->id,
            'title' => 'Cedar Ridge Family Home',
            'is_featured' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('EstateFlow')
            ->assertSee($property->title);
    }

    public function test_property_index_can_filter_published_properties(): void
    {
        $agent = User::factory()->create();
        Property::factory()->create(['agent_id' => $agent->id, 'city' => 'Austin', 'title' => 'Austin House']);
        Property::factory()->create(['agent_id' => $agent->id, 'city' => 'Denver', 'title' => 'Denver Condo']);

        $this->get('/properties?city=Austin')
            ->assertOk()
            ->assertSee('Austin House')
            ->assertDontSee('Denver Condo');
    }
}
