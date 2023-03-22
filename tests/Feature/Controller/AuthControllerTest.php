<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register function
     *
     * @return void
     */
    public function testRegister()
    {
        $data = [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $data);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'name' => 'test user',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test login function
     *
     * @return void
     */
    public function testLogin()
    {
        $user = User::create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $response = $this->post('/login', $data);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test logout function
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->actingAs($user);

        $response = $this->get('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
