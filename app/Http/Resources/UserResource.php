<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="userData",
     *     type="object",
     *     required={"id","name"},
     *     description="Данные пользователя",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1,
     *         description="Идентификатор пользователя"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Alice",
     *         description="Имя пользователя"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
