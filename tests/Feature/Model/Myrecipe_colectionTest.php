<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Myrecipe_Colection;

class Myrecipe_ColectionTest extends TestCase
{
    use RefreshDatabase;
    
    public function testGetMyrecipe()
    {
        $myrecipe = Myrecipe_Colection::factory()->create();

        $result = (new Myrecipe_Colection())->getMyrecipe($myrecipe->id);

        $this->assertEquals($myrecipe->id, $result->id);
    }

    public function testGetMyrecipes()
    {
        $myrecipe1 = Myrecipe_Colection::factory()->create([
            'title' => 'テストレシピ1',
            'recipe' => 'テストレシピの内容1'
        ]);
        $myrecipe2 = Myrecipe_Colection::factory()->create([
            'title' => 'テストレシピ2',
            'recipe' => 'テストレシピの内容2'
        ]);
        $myrecipe3 = Myrecipe_Colection::factory()->create([
            'title' => 'テストレシピ3',
            'recipe' => 'テストレシピの内容3'
        ]);
        
        $post1 = $myrecipe1->posts()->create(['user_id' => 1]);
        $post2 = $myrecipe2->posts()->create(['user_id' => 2]);
        
        $result1 = (new Myrecipe_Colection())->getMyrecipes('テスト', 'myrecipe')->get();
        $result2 = (new Myrecipe_Colection())->getMyrecipes('テスト', 'post')->get();

        $this->assertEquals([$myrecipe1->id], $result1->pluck('id')->toArray());
        $this->assertEquals([$myrecipe2->id], $result2->pluck('id')->toArray());
    }

    public function testGetShowMyrecipes()
    {
        $myrecipe = Myrecipe_Colection::factory()->create();
        $post = $myrecipe->posts()->create(['user_id' => 1]);

        $result = (new Myrecipe_Colection())->getShowMyrecipes($myrecipe->id);

        $this->assertEquals($myrecipe->id, $result['myrecipe']->id);
        $this->assertEquals($post->id, $result['post']->id);
    }
}
