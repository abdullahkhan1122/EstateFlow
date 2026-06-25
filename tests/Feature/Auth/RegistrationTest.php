<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_is_not_available(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    public function test_buyer_registration_redirects_to_properties(): void
    {
        $response = $this->post(route('buyer.register.store'), [
            'name' => 'New Buyer',
            'email' => 'newbuyer@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('properties.index'));
        $this->assertAuthenticated();
    }
}
