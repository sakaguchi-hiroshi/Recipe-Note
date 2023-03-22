<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Bookmark;

class BookmarkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBookmark()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Auth::login($user);

        // create a new bookmark
        $response = $this->postJson(route('bookmark'), ['post_id' => $post->id]);
        $response->assertOk();
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // delete the bookmark
        $response = $this->postJson(route('bookmark'), ['post_id' => $post->id]);
        $response->assertOk();
        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
