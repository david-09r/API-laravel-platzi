<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
      //Este metodo nos srive para practicamente saltarnos el test de la linea 17 al 19
      $this->withoutExceptionHandling();
      $response = $this->json('POST', '/api/posts', [
        'title' => 'El post de prueba'
      ]);

      $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
      ->assertJson(['title' => 'El post de prueba'])
      ->assertStatus(201); //OK

      $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);
    }

    public function test_validate_title()
    {
      $response = $this->json('POST', '/api/posts', [
        'title' => ''
      ]);

      //Estatus HTTP 422
      $response->assertStatus(422) //Estatus HTTP 422
      ->assertJsonValidationErrors('title');
    }

  public function test_show()
  {
    $post = Post::factory()->create();

    $response = $this->json('GET', "/api/posts/$post->id");
    $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
      ->assertJson(['title' => $post->title])
      ->assertStatus(200); //OK
  }

  public function test_404_show()
  {
    $response = $this->json('GET', "/api/posts/1000");
    $response->assertStatus(404); //OK
  }

  public function test_update()
  {
    $this->withoutExceptionHandling();
    $post = Post::factory()->create();

    $response = $this->json('PUT', "/api/posts/$post->id", [
      'title' => 'nuevo'
    ]);

    $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
      ->assertJson(['title' => 'nuevo'])
      ->assertStatus(200); //OK

    $this->assertDatabaseHas('posts', ['title' => 'nuevo']);
  }
}
