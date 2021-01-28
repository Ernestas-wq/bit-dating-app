<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_login()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response
            ->assertJsonStructure(['data', 'message', 'token'])
            ->assertJson([
                'data' => [
                    'email'      => $user->email,
                    'created_at' => $user->created_at->diffForHumans(),
                    'updated_at' => $user->updated_at->diffForHumans()
                ],
                'message' => 'Success'
            ])
            ->assertStatus(200);
    }
}
