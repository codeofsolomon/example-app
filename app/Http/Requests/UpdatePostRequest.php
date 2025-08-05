<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     *     schema="updatePostRequest",
     *     required={"body"},
     *     description="Запрос на обновление поста",
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         example="Обновлённый текст поста",
     *         description="Новый текст поста"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="updatePostValidationErrorResponse",
     *     description="Ответ при ошибках валидации при обновлении поста",
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
            'user_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ];
    }
}
