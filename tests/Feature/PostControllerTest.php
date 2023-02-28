<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function testPostList()
    {
        $response = $this->get('/api/post');
        $response->assertStatus(200);
        $result = json_decode($response->getContent(), true);
        $this->assertIsArray($result);
    }

    public function testCreatePost()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $initCount = Post::query()->count();
        $response = $this->post('/api/post', ['title' => 'test', 'text' => 'test', 'user_id' => $user->id]);

        $response->assertStatus(201);
        $this->assertEquals($initCount + 1, Post::query()->count());
    }

    public function testDeletePost()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $response = $this->delete('/api/post/'.$post->id);
        $response->assertOk();
        $this->assertEquals('true', $response->getContent());

    }
}
