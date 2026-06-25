<?php

namespace Tests\Feature\Api;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_properties_api_returns_published_properties(): void
    {
        $agent = User::factory()->create();
        $property = Property::factory()->create(['agent_id' => $agent->id, 'title' => 'API Visible Home']);
        Property::factory()->create(['agent_id' => $agent->id, 'status' => Property::STATUS_DRAFT, 'title' => 'Hidden Draft']);

        $this->getJson('/api/properties')
            ->assertOk()
            ->assertJsonPath('data.0.title', $property->title)
            ->assertJsonMissing(['title' => 'Hidden Draft']);
    }

    public function test_properties_api_shows_single_property(): void
    {
        $agent = User::factory()->create();
        $property = Property::factory()->create(['agent_id' => $agent->id]);

        $this->getJson('/api/properties/'.$property->slug)
            ->assertOk()
            ->assertJsonPath('data.slug', $property->slug);
    }
}
