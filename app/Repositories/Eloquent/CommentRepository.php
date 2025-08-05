<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Support\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function all(): Collection
    {
        return Comment::with('user')->get();
    }

    public function find(int $id): ?Comment
    {
        return Comment::with('user')->find($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Comment::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Comment::destroy($id);
    }
}
