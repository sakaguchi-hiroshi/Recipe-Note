<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\MyrecipeController;
use App\Models\Myrecipe_Colection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MyrecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Myrecipe_Colection::factory()->create();

        $response = $this->get(route('myrecipes.index', ['value' => 'myrecipe']));

        $response->assertOk();
        $response->assertViewIs('myrecipes.myrecipe');
        $response->assertViewHas('myrecipes');
    }

    public function testShowForm()
    {
        $response = $this->get(route('myrecipes.showForm'));

        $response->assertOk();
        $response->assertViewIs('myrecipes.form');
    }

    public function testAdd()
    {
        $image = UploadedFile::fake()->image('test.jpg');
        $movie = UploadedFile::fake()->create('test.mp4');

        Storage::fake('s3');

        $response = $this->post(route('myrecipes.add'), [
            'user_id' => 1,
            'title' => 'テストレシピ',
            'image' => $image,
            'movie' => $movie,
            'recipe' => 'テストレシピの作り方',
            'url' => 'https://example.com/test',
        ]);

        $response->assertRedirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
        $this->assertDatabaseHas('myrecipe__colections', [
            'title' => 'テストレシピ',
            'recipe' => 'テストレシピの作り方',
            'url' => 'https://example.com/test',
        ]);
        $this->assertDatabaseHas('images', [
            'name' => 'テストレシピ',
        ]);
        $this->assertDatabaseHas('movies', [
            'name' => 'テストレシピ',
        ]);
        Storage::disk('s3')->assertExists('images/test.jpg');
        Storage::disk('s3')->assertExists('movies/test.mp4');
    }
}
