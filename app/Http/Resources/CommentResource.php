<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="commentData",
     *     type="object",
     *     required={"id","post_id","user","body","created"},
     *     description="Данные комментария",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=42,
     *         description="Идентификатор комментария"
     *     ),
     *     @OA\Property(
     *         property="post_id",
     *         type="integer",
     *         example=10,
     *         description="Идентификатор поста"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         ref="#/components/schemas/userData",
     *         description="Автор комментария"
     *     ),
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Отличный пост!",
     *         description="Текст комментария"
     *     ),
     *     @OA\Property(
     *         property="created",
     *         type="string",
     *         format="date-time",
     *         example="2025-08-05T11:15:00Z",
     *         description="Дата и время создания"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'body' => $this->body,
            'created' => $this->created_at,
        ];
    }
}
