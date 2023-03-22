<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\Models\Report;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowform()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Auth::login($user);

        $response = $this->get(route('reports.form', ['post_id' => $post->id]));
        $response->assertOk();
    }

    public function testAdd()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $post = Post::factory()->create();
        $image = UploadedFile::fake()->image('test.jpg');

        Auth::login($user);

        $data = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'coment' => 'test coment',
            'image' => $image,
        ];

        $response = $this->post(route('reports.add'), $data);
        $response->assertRedirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));

        $this->assertDatabaseHas('reports', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'coment' => 'test coment',
        ]);

        $report = Report::where('user_id', $user->id)->where('post_id', $post->id)->first();
        $this->assertNotNull($report->image_id);

        $image = Image::find($report->image_id);
        $this->assertNotNull($image);
        Storage::disk('s3')->assertExists($image->path);
    }
}
