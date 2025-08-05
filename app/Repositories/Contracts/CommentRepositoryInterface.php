<?php

namespace App\Repositories\Contracts;

use App\Models\Comment;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Comment;

    public function create(array $data): Comment;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
