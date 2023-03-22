<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testGetIndexPosts()
    {
        $post1 = Post::factory()->create(['title' => 'post1', 'recipe' => 'recipe1']);
        $post2 = Post::factory()->create(['title' => 'post2', 'recipe' => 'recipe2']);

        $results = Post::getIndexPosts('post1', 'post')->get();

        $this->assertCount(1, $results);
        $this->assertEquals($post1->title, $results->first()->title);
    }

    /** @test */
        public function testGetPostRecipe()
    {
        $post1 = Post::factory()->create(['myrecipe__colection_id' => 1]);
        $post2 = Post::factory()->create(['myrecipe__colection_id' => 2]);
        $post3 = Post::factory()->create(['myrecipe__colection_id' => 1]);

        $result = $post1->getPostRecipe(1)->get();

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains($post1));
        $this->assertTrue($result->contains($post3));
        $this->assertFalse($result->contains($post2));
    }

    /** @test */
        public function testIsLikedBy()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $bookmark = Bookmark::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $result1 = $post->isLikedBy($user);
        $result2 = $post->isLikedBy(User::factory()->create());

        $this->assertTrue($result1);
        $this->assertFalse($result2);
    }

    /** @test */
    public function testGetBookmarkOrderPosts()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();
        $post3 = Post::factory()->create();
        $keyword = 'example';
        $bookmark1 = Bookmark::factory()->create(['post_id' => $post1->id]);
        $bookmark2 = Bookmark::factory()->create(['post_id' => $post2->id]);
        $bookmark3 = Bookmark::factory()->create(['post_id' => $post3->id]);

        $posts = Post::getBookmarkOrderPosts($keyword);

        $this->assertEquals($post2->id, $posts->first()->id);
        $this->assertEquals($post1->id, $posts[1]->id);
        $this->assertEquals($post3->id, $posts->last()->id);
    }

    /** @test */
    public function testGetPostRecipeRanking()
    {
        $post1 = Post::factory()->create(['title' => 'Recipe 1']);
        $post2 = Post::factory()->create(['title' => 'Recipe 2']);
        $post3 = Post::factory()->create(['title' => 'Recipe 3']);
        $post4 = Post::factory()->create(['title' => 'Recipe 4']);

        $results = [
            $post2->id => ['title' => 'Recipe 2', 'recipe' => 'This is recipe 2'],
            $post4->id => ['title' => 'Recipe 4', 'recipe' => 'This is recipe 4'],
            $post1->id => ['title' => 'Recipe 1', 'recipe' => 'This is recipe 1'],
        ];
        $keyword = 'recipe';
        $post_recipe_ranking = $post1->getPostRecipeRanking($results, $keyword);

        $this->assertEquals($post_recipe_ranking->first()->id, $post2->id);
        $this->assertEquals($post_recipe_ranking->get(1)->id, $post4->id);
        $this->assertEquals($post_recipe_ranking->get(2)->id, $post1->id);
    }
}
