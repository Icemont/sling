<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_guest_redirected_to_login_page()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }


    public function test_user_with_empty_profile_redirected_to_settings_page()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('user.settings.edit'));
    }

    public function test_verified_user_with_completed_profile_can_show_dashboard()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->upsertAddress([
            'street1' => 'Test',
            'street2' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'Test',
            'zip' => 'Test',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

}
