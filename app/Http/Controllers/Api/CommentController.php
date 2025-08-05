<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Responses\ApiBaseResponse;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Repositories\Contracts\CommentRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Comments",
 *     description="CRUD для комментариев"
 * )
 */
class CommentController extends Controller
{
    public function __construct(
        protected CommentRepositoryInterface $comments
    ) {}

    /**
     * @OA\Get(
     *     path="/api/comments",
     *     tags={"Comments"},
     *     summary="Список всех комментариев",
     *     operationId="getCommentsList",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/commentData")
     *             ),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function index(): ApiBaseResponse
    {
        try {
            return SuccessApiResponse::make(CommentResource::collection(
                $this->comments->all(),
            ));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     tags={"Comments"},
     *     summary="Создать новый комментарий",
     *     operationId="createComment",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/storeCommentRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Комментарий создан",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/commentData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/storeCommentValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function store(StoreCommentRequest $request): ApiBaseResponse
    {
        try {
            $comment = $this->comments->create($request->validated());

            return SuccessApiResponse::make(
                new CommentResource($comment), 201,
            );
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Получить комментарий по ID",
     *     operationId="getCommentById",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор комментария"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/commentData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/404Error")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function show(int $id): ApiBaseResponse
    {
        try {
            $comment = $this->comments->find($id);

            return SuccessApiResponse::make(new CommentResource($comment));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Обновить комментарий",
     *     operationId="updateComment",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор комментария"
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/updateCommentRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Комментарий обновлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/commentData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/updateCommentValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/404Error")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function update(UpdateCommentRequest $request, int $id): ApiBaseResponse
    {
        try {
            $this->comments->update($id, $request->validated());

            return SuccessApiResponse::make(
                new CommentResource($this->comments->find($id)));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Удалить комментарий",
     *     operationId="deleteComment",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор комментария"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/404Error")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function destroy(int $id): ApiBaseResponse
    {
        try {
            $this->comments->delete($id);

            return SuccessApiResponse::make();
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }
}
