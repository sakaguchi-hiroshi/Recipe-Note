<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ManagementControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/managements/manage');
        $response->assertStatus(200);
    }

    public function testShowUser()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/managements/user_info?user_id=' . $user->id);
        $response->assertStatus(200);
    }

    public function testUserDelete()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/managements/user_delete', ['user_id' => $user->id]);
        $response->assertRedirect('/managements/manage');
        $this->assertDeleted($user);
    }

    public function testShowPost()
    {
        $user = User::factory()->create();
        $post = $user->posts()->create([
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ]);
        $response = $this->actingAs($user)->get('/managements/user_post?post_id=' . $post->id);
        $response->assertStatus(200);
    }

    public function testPostDelete()
    {
        $user = User::factory()->create();
        $post = $user->posts()->create([
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ]);
        $response = $this->actingAs($user)->post('/managements/post_delete', ['post_id' => $post->id]);
        $response->assertRedirect('/managements/manage');
        $this->assertDeleted($post);
    }
}
