<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Get(
 *     path="/api/v1/patients",
 *     summary="Get all patients",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PatientResource"))
 *     )
 * )
 * @OA\Post(
 *     path="/api/v1/patients",
 *     summary="Store a new patient",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PatientStoreRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/PatientResource"))
 * )
 */
class PatientController extends SwaggerController
{
    //
}
