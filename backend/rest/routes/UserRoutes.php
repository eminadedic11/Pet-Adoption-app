<?php

require_once __DIR__ . '/../services/UserService.php';

Flight::group('/users', function () {
    $service = new UserService();

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get all users (admin only)",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of users"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    Flight::route('GET /', function () use ($service) {
        // Flight::auth_middleware()->verifyToken();
        Flight::json($service->getAll());
    });
    

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User object"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) use ($service) {
        // Flight::auth_middleware()->verifyToken();
        Flight::json($service->getById($id));
    });

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "phone", "role"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="role", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        $data = Flight::request()->data->getData();
        $id = $service->add($data);
        Flight::json(["user_id" => $id], 201);
    });

    /**
     * @OA\Put(
     *     path="/users",
     *     summary="Update user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "name", "email", "password", "phone", "role"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="role", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated")
     * )
     */
    Flight::route('PUT /', function () use ($service) {
        $data = Flight::request()->data->getData();
        Flight::json($service->update($data));
    });

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User deleted")
     * )
     */
    Flight::route('DELETE /@id', function ($id) use ($service) {
        Flight::json($service->delete($id));
    });
});
