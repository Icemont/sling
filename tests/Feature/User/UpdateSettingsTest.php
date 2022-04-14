<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Values\Address;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(RequirePassword::class);
        $this->user = User::factory()->createOne();
    }

    /**
     * @return void
     */
    public function test_user_can_view_settings_update_form()
    {
        $response = $this->actingAs($this->user)->get(route('user.settings.edit'));

        $address = new Address($this->user->address);

        $response->assertViewHasAll([
            'user' => $this->user,
            'address' => $address,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('user.settings');
    }

    /**
     * @return void
     */
    public function test_user_can_update_settings()
    {
        $response = $this->actingAs($this->user)->put(
            route('user.settings.update'),
            $this->getTestData()
        );

        $response->assertSessionHasNoErrors();
        $response->assertSessionHasAll([
            'status' => __('Profile settings successfully updated!'),
            'type' => 'success',
        ]);

        $response->assertRedirect(route('user.settings.edit'));
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_user_must_provide_required_data()
    {
        $response = $this->actingAs($this->user)->put(
            route('user.settings.update'),
            $this->getTestData(false)
        );

        $response->assertSessionHasErrors([
            "name", "business.name", "phone",
            "country", "city", "street1",
        ]);
    }

    /**
     * Get data for the test
     *
     * @return array
     */
    private function getTestData(bool $valid = true): array
    {
        return [
            'name' => $valid ? 'Test' : '',
            'business' => [
                'name' => $valid ? 'Test' : '',
                'code' => '',
            ],
            'phone' => $valid ? '995000000000' : '',
            'country' => $valid ? 'Georgia' : '',
            'state' => '',
            'city' => $valid ? 'Tbilisi' : '',
            'zip' => '',
            'street1' => $valid ? 'Test' : '',
            'street2' => '',
        ];
    }
}
