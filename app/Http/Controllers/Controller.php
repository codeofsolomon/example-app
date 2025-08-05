<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *    title="Example API",
 *    version="1.0.0",
 * ),
 *
 * @QA\PathItem(
 *    path='/api/'
 * ),
 *
 * @OA\PathItem(path="app"),
 * 
 * @OA\Schema(
 *        schema="500Error",
 *        type="object",
 *
 *        @OA\Property(property="result", type="array", @OA\Items(), example={}),
 *        @OA\Property(property="error", type="string", example="Error string")
 *    )
 * 
 * @OA\Schema(
 *        schema="404Error",
 *        type="object",
 *
 *        @OA\Property(property="result", type="array", @OA\Items(), example={}),
 *        @OA\Property(property="error", type="string", example="Not found")
 *    )
 */
abstract class Controller
{
    //
}
