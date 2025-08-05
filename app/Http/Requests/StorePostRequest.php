<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */

    /**
     * @OA\Schema(
     *     schema="storePostRequest",
     *     required={"user_id","body"},
     *     description="Запрос на создание поста",
     *
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example=1,
     *         description="Идентификатор пользователя"
     *     ),
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Это содержимое поста",
     *         description="Текст поста"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="storePostValidationErrorResponse",
     *     description="Ответ при ошибках валидации при создании поста",
     *
     *     @OA\Property(
     *         property="result",
     *         type="array",
     *         @OA\Items(),
     *         example={}
     *     ),
     *     @OA\Property(
     *         property="error",
     *         type="object",
     *         @OA\Property(
     *             property="user_id",
     *             type="array",
     *             @OA\Items(type="string", example="The user_id field is required.")
     *         ),
     *         @OA\Property(
     *             property="body",
     *             type="array",
     *             @OA\Items(type="string", example="The body field is required.")
     *         )
     *     )
     * )
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ];
    }
}
