<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Middleware\EnsureProfileIsFilled;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class EnsureProfileIsFilledMiddlewareTest extends TestCase
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
    public function test_users_without_address_are_redirected(): void
    {
        $request = Request::create('/');

        $this->user->address()->delete();

        $request->setUserResolver(fn() => $this->user);

        $middleware = new EnsureProfileIsFilled;

        $response = $middleware->handle($request, fn() => null);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(true, $response->isRedirect(route('user.settings.edit')));
    }

    /**
     * @return void
     */
    public function test_users_with_address_are_not_redirected(): void
    {
        $request = Request::create('/');

        $this->user->upsertAddress([
            'street1' => 'Test',
            'street2' => 'Test',
            'city' => 'Test',
            'state' => 'Test',
            'country' => 'Test',
            'zip' => 'Test',
        ]);

        $request->setUserResolver(fn() => $this->user);

        $middleware = new EnsureProfileIsFilled;

        $response = $middleware->handle($request, fn() => null);

        $this->assertEquals(null, $response);
    }
}
