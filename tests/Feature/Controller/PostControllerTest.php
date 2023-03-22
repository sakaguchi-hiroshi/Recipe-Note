<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Myrecipe_Colection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->myrecipe = Myrecipe_Colection::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->post = Post::factory()->create([
            'user_id' => $this->user->id,
            'myrecipe__colection_id' => $this->myrecipe->id,
        ]);
        Auth::login($this->user);
    }

    /**
     * @test
     */
    public function testIndex()
    {
        $response = $this->get('/posts/1');
        $response->assertStatus(200);
        $response->assertViewIs('posts.post');
        $response->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function testConfirm()
    {
        $response = $this->get('/posts/confirm?recipe_id=' . $this->myrecipe->id);
        $response->assertStatus(200);
        $response->assertViewIs('posts.confirm');
        $response->assertViewHas('myrecipe');
    }

    /**
     * @test
     */
    public function testAdd()
    {
        $response = $this->post('/posts/add', [
            'recipe_id' => $this->myrecipe->id,
        ]);
        $response->assertRedirect('/myrecipes/myrecipe?value=post');
        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id,
            'myrecipe__colection_id' => $this->myrecipe->id,
        ]);
    }

    /**
     * @test
     */
    public function testDelete()
    {
        $response = $this->delete('/posts/delete', [
            'recipe_id' => $this->myrecipe->id,
        ]);
        $response->assertRedirect('/myrecipes/myrecipe?value=post');
        $this->assertDatabaseMissing('posts', [
            'user_id' => $this->user->id,
            'myrecipe__colection_id' => $this->myrecipe->id,
        ]);
    }

    /**
     * @test
     */
    public function testShowBookmarkOrder()
    {
        $response = $this->get('/posts/orders/bookmark');
        $response->assertStatus(200);
        $response->assertViewIs('posts.orders.bookmark');
        $response->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function testShowAccessOrder()
    {
        $response = $this->get('/posts/orders/access');
        $response->assertStatus(200);
        $response->assertViewIs('posts.orders.access');
        $response->assertViewHas('post_recipe_rankings');
    }
}
