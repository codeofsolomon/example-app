<?php

namespace App\Http\Responses;

class ErrorInternalServerErrorResponse extends ApiErrorResponse
{
    protected function defaultResponseCode(): int
    {
        return 500;
    }

    protected function defaultErrorMessage(): string
    {
        return 'Ошибка запроса. Повторите попытку позже.';
    }
}
