<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_agent(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.agents.store'), [
            'name' => 'Clara West',
            'email' => 'clara@example.test',
            'phone' => '(555) 100-2000',
            'bio' => 'Residential specialist.',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.agents.index'));
        $this->assertDatabaseHas('users', ['email' => 'clara@example.test', 'role' => User::ROLE_AGENT]);
    }

    public function test_agent_cannot_manage_agents(): void
    {
        $agent = User::factory()->create(['role' => User::ROLE_AGENT]);

        $this->actingAs($agent)->get(route('admin.agents.index'))->assertForbidden();
    }
}
