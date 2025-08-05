<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

abstract class ApiErrorResponse extends ApiBaseResponse
{
    public function toResponse($request): JsonResponse
    {
        $response = parent::toResponse($request);

        $data = (array) $response->getData();

        $data['error'] = $data['result'];
        $data['result'] = [];

        if (empty($data['error'])) {
            $data['error'] = $this->defaultErrorMessage();
        }

        $response->setData($data);

        return $response;
    }

    protected function defaultErrorMessage(): string
    {
        return 'Ошибка. Повторите попытку позже.';
    }
}
