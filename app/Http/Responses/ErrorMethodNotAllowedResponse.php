<?php

namespace App\Http\Responses;

class ErrorMethodNotAllowedResponse extends ApiErrorResponse
{
    protected function defaultResponseCode(): int
    {
        return 405;
    }

    protected function defaultErrorMessage(): string
    {
        return 'Метод ошибки не разрешен.';
    }
}
