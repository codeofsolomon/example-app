<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     *     schema="updateUserRequest",
     *     required={"name"},
     *     description="Запрос на обновление пользователя",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Bob",
     *         description="Новое имя пользователя"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="updateUserValidationErrorResponse",
     *     description="Ответ при ошибках валидации при обновлении пользователя",
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
     *             property="name",
     *             type="array",
     *             @OA\Items(type="string", example="The name field is required.")
     *         )
     *     )
     * )
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
