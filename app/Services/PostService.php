<?php

namespace App\Services;

use App\Http\Requests\PostRequestCreate;
use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    /**
     * @return Collection
     */
    public function getAllPosts(): Collection
    {
        return Post::query()->get();
    }

    /**
     * @param PostRequestCreate $request
     * @return void
     */
    public function createPost(PostRequestCreate $request): void
    {
        Post::create($request->validated());
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getPostById(int $id): ?Model
    {
        return Post::query()->find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deletePostById(int $id): bool
    {
        try {
            $post = Post::query()->find($id);
            $post->delete();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
