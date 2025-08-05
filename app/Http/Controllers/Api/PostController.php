<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Responses\ApiBaseResponse;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Repositories\Contracts\PostRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="CRUD для постов"
 * )
 */
class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $posts
    ) {}

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     tags={"Posts"},
     *     summary="Список всех постов",
     *     operationId="getPostsList",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/postData")
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
            return SuccessApiResponse::make(PostResource::collection(
                $this->posts->all(),
            ));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


     /**
     * @OA\Post(
     *     path="/api/posts",
     *     tags={"Posts"},
     *     summary="Создать новый пост",
     *     operationId="createPost",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/storePostRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Пост создан",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/postData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/storePostValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *         @OA\JsonContent(ref="#/components/schemas/500Error")
     *     )
     * )
     */
    public function store(StorePostRequest $request): ApiBaseResponse
    {
        try {
            $post = $this->posts->create($request->validated());

            return SuccessApiResponse::make(new PostResource($post), 201);
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Получить пост по ID",
     *     operationId="getPostById",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор поста"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/postData"),
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
            $post = $this->posts->find($id);

            return SuccessApiResponse::make(new PostResource($post));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Обновить пост",
     *     operationId="updatePost",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор поста"
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/updatePostRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Пост обновлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/postData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/updatePostValidationErrorResponse")
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
    public function update(UpdatePostRequest $request, int $id): ApiBaseResponse
    {
        try {
            $this->posts->update($id, $request->validated());

            return SuccessApiResponse::make(
                new PostResource($this->posts->find($id)),
            );
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Удалить пост",
     *     operationId="deletePost",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор поста"
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
            $this->posts->delete($id);

            return SuccessApiResponse::make();
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }

     /**
     * @OA\Get(
     *     path="/api/posts/{id}/comments",
     *     tags={"Posts"},
     *     summary="Комментарии поста",
     *     operationId="getPostComments",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Идентификатор поста"
     *     ),
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
    public function comments(int $id): ApiBaseResponse
    {
        try {
            return SuccessApiResponse::make(CommentResource::collection(
                $this->posts->getComments($id),
            ));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }
}
