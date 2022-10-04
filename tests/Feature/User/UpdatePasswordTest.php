<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    private const NEW_PASSWORD = 'newPass123';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
    }

    /**
     * @return void
     */
    public function test_user_can_view_password_update_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('user.password.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('user.password');
    }

    /**
     * @return void
     */
    public function test_user_can_update_password(): void
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => UserFactory::DEFAULT_PASSWORD,
                'new_password' => self::NEW_PASSWORD,
                'new_password_confirmation' => self::NEW_PASSWORD,
            ]
        );

        $this->user->refresh();
        $this->assertTrue(\Hash::check(self::NEW_PASSWORD, $this->user->password));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHasAll([
            'status' => __('Password successfully updated!'),
            'type' => 'success',
        ]);

        $response->assertRedirect(route('user.password.edit'));
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_new_password_must_be_confirmed(): void
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => UserFactory::DEFAULT_PASSWORD,
                'new_password' => self::NEW_PASSWORD,
                'new_password_confirmation' => '',
            ]
        );

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * @return void
     */
    public function test_user_must_enter_current_password(): void
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => '',
                'new_password' => self::NEW_PASSWORD,
                'new_password_confirmation' => self::NEW_PASSWORD,
            ]
        );

        $response->assertSessionHasErrors('current_password');
    }
}
