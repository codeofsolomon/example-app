<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
     *     schema="updateCommentRequest",
     *     required={"body"},
     *     description="Запрос на обновление комментария",
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Обновлённый текст комментария",
     *         description="Новый текст комментария"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="updateCommentValidationErrorResponse",
     *     description="Ответ при ошибках валидации при обновлении комментария",
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
