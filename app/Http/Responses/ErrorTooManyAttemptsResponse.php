<?php

namespace App\Http\Responses;

class ErrorTooManyAttemptsResponse extends ApiErrorResponse
{
    protected function defaultResponseCode(): int
    {
        return 429;
    }

    protected function defaultErrorMessage(): string
    {
        return 'Слишком много запросов, пожалуйста, прекратите.';
    }
}
