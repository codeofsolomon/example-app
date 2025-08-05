<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::with('user')->get();
    }

    public function find(int $id): ?Post
    {
        return Post::with('user')->find($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Post::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Post::destroy($id);
    }

    public function getComments(int $postId): Collection
    {
        return Post::findOrFail($postId)->comments()->with('user')->get();
    }
}
