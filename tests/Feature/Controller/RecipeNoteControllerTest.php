<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Myrecipe_Colection;
use App\Models\Post;

class RecipeNoteControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(action('RecipeNoteController@index'));
        $response->assertStatus(200);
        $response->assertViewIs('recipenotes.index');
    }

    public function test_showPremiumService()
    {
        $response = $this->get(action('RecipeNoteController@showPremiumService'));
        $response->assertStatus(200);
    }
}
