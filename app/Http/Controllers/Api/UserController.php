<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiBaseResponse;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="CRUD для пользователей"
 * )
 */
class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $users
    ) {}

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Список всех пользователей",
     *     operationId="getUsersList",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/userData")
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
            return SuccessApiResponse::make(
                UserResource::collection($this->users->all()),
            );
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Создать пользователя",
     *     operationId="createUser",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/storeUserRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Пользователь создан",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/userData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации", @OA\JsonContent(ref="#/components/schemas/storeUserValidationErrorResponse")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function store(StoreUserRequest $req): ApiBaseResponse
    {
        try {
            $user = $this->users->create($req->validated());

            return SuccessApiResponse::make(new UserResource($user), 201);
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Получить пользователя по ID",
     *     operationId="getUserById",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID пользователя"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/userData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=404, description="Не найден", @OA\JsonContent(ref="#/components/schemas/404Error")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function show($id): ApiBaseResponse
    {
        try {
            return SuccessApiResponse::make(
                new UserResource($this->users->find($id)),
            );
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Обновить пользователя",
     *     operationId="updateUser",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID пользователя"
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/updateUserRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь обновлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", ref="#/components/schemas/userData"),
     *             @OA\Property(property="error", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации", @OA\JsonContent(ref="#/components/schemas/updateUserValidationErrorResponse")),
     *     @OA\Response(response=404, description="Не найден", @OA\JsonContent(ref="#/components/schemas/404Error")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function update(UpdateUserRequest $req, $id): ApiBaseResponse
    {
        try {
            $this->users->update($id, $req->validated());

            return SuccessApiResponse::make(new UserResource($this->users->find($id)));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Удалить пользователя",
     *     operationId="deleteUser",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID пользователя"
     *     ),
     *
     *     @OA\Response(response=204, description="Удалено без содержимого"),
     *     @OA\Response(response=404, description="Не найден", @OA\JsonContent(ref="#/components/schemas/404Error")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function destroy($id): ApiBaseResponse
    {
        try {
            $this->users->delete($id);

            return SuccessApiResponse::make();
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}/posts",
     *     tags={"Users"},
     *     summary="Посты пользователя",
     *     operationId="getUserPosts",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID пользователя"
     *     ),
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
     *     @OA\Response(response=404, description="Не найден", @OA\JsonContent(ref="#/components/schemas/404Error")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function posts($id): ApiBaseResponse
    {
        try {
            return SuccessApiResponse::make(PostResource::collection(
                $this->users->getPosts($id),
            ));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}/comments",
     *     tags={"Users"},
     *     summary="Комментарии пользователя",
     *     operationId="getUserComments",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID пользователя"
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
     *     @OA\Response(response=404, description="Не найден", @OA\JsonContent(ref="#/components/schemas/404Error")),
     *     @OA\Response(response=500, description="Внутренняя ошибка сервера", @OA\JsonContent(ref="#/components/schemas/500Error"))
     * )
     */
    public function comments($id): ApiBaseResponse
    {
        try {
            return SuccessApiResponse::make(CommentResource::collection(
                $this->users->getComments($id),
            ));
        } catch (\Exception $e) {
            return ErrorApiResponse::make($e->getMessage());
        }
    }
}
