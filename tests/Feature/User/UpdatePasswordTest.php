<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private string $new_password = 'newPass123';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
    }

    /**
     * @return void
     */
    public function test_user_can_view_password_update_form()
    {
        $response = $this->actingAs($this->user)->get(route('user.password.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('user.password');
    }

    /**
     * @return void
     */
    public function test_user_can_update_password()
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => 'password',
                'new_password' => $this->new_password,
                'new_password_confirmation' => $this->new_password,
            ]
        );

        $this->user->refresh();
        $this->assertTrue(\Hash::check($this->new_password, $this->user->password));

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
    public function test_new_password_must_be_confirmed()
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => 'password',
                'new_password' => $this->new_password,
                'new_password_confirmation' => '',
            ]
        );

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * @return void
     */
    public function test_user_must_enter_current_password()
    {
        $response = $this->actingAs($this->user)->put(
            route('user.password.update'),
            [
                'current_password' => '',
                'new_password' => $this->new_password,
                'new_password_confirmation' => $this->new_password,
            ]
        );

        $response->assertSessionHasErrors('current_password');
    }
}
