<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class ApiBaseResponse extends Response implements Responsable
{
    protected array|string|object $dataOrMessage;

    protected ?int $code;

    private function __construct(array|string|object $dataOrMessage = [], ?int $code = null)
    {
        parent::__construct();

        $this->dataOrMessage = $dataOrMessage;
        $this->code = $code;
    }

    public static function make(array|string|object $dataOrMessage = [], ?int $code = null): static
    {
        return new static($dataOrMessage, $code);
    }

    public function toResponse($request): JsonResponse
    {
        $response = new JsonResponse([
            'result' => $this->dataOrMessage,
            'error' => null,
        ]);

        $response->setStatusCode($this->code ?? $this->defaultResponseCode());
        $response->headers->add(
            $this->headers->all(),
        );

        return $response;
    }

    protected function defaultResponseCode(): int
    {
        return 500;
    }
}
