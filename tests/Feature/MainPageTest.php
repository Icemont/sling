<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
    }

    /**
     * @return void
     */
    public function test_guest_redirected_to_login_page()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * @return void
     */
    public function test_user_with_empty_profile_redirected_to_settings_page()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard'));

        $response->assertRedirect(route('user.settings.edit'));
    }

    /**
     * @return void
     */
    public function test_verified_user_with_completed_profile_can_show_dashboard()
    {
        $this->user->upsertAddress([
            'street1' => 'Test',
            'street2' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'Test',
            'zip' => 'Test',
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

}
