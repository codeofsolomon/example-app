<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
     *     schema="storeCommentRequest",
     *     required={"post_id","user_id","body"},
     *     description="Запрос на создание комментария",
     *     @OA\Property(
     *         property="post_id",
     *         type="integer",
     *         example=10,
     *         description="Идентификатор поста"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example=1,
     *         description="Идентификатор пользователя"
     *     ),
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Отличный пост!",
     *         description="Текст комментария"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="storeCommentValidationErrorResponse",
     *     description="Ответ при ошибках валидации при создании комментария",
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
     *             property="post_id",
     *             type="array",
     *             @OA\Items(type="string", example="The post_id field is required.")
     *         ),
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
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ];
    }
}
