<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="postData",
     *     type="object",
     *     required={"id","user","body","created"},
     *     description="Данные поста",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=10,
     *         description="Идентификатор поста"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         ref="#/components/schemas/userData",
     *         description="Автор поста"
     *     ),
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Hello, world!",
     *         description="Содержимое поста"
     *     ),
     *     @OA\Property(
     *         property="created",
     *         type="string",
     *         format="date-time",
     *         example="2025-08-05T10:00:00Z",
     *         description="Дата и время создания"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'body' => $this->body,
            'created' => $this->created_at,
        ];
    }
}
