<?php

namespace Tests\Unit;

use App\Http\Middleware\EnsureProfileIsFilled;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class EnsureProfileIsFilledMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @return void
     */
    public function test_users_without_address_are_redirected()
    {
        $request = Request::create('/');

        $this->user->address()->delete();

        $request->setUserResolver(fn() => $this->user);

        $middleware = new EnsureProfileIsFilled;

        $response = $middleware->handle($request, fn() => null);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals($response->isRedirect(route('user.settings.edit')), true);
    }

    /**
     * @return void
     */
    public function test_users_with_address_are_not_redirected()
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

        $this->assertEquals($response, null);
    }
}
