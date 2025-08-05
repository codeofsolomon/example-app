<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Post;

    public function create(array $data): Post;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getComments(int $postId): Collection;
}
