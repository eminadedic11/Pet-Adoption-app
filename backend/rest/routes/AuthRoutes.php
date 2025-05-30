<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::group('/auth', function() {

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user.",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Emina"),
     *             @OA\Property(property="email", type="string", example="srna.amina24@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="password", type="string", example="amina")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User has been added."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    Flight::route('POST /register', function () {
        $data = Flight::request()->data->getData();

        $response = Flight::auth_service()->register($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User registered successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::json(['message' => $response['error']], 500);
        }
    });

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Login with email and password",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="srna.amina24@gmail.com"),
     *             @OA\Property(property="password", type="string", example="amina")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="JWT token returned on successful login"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    Flight::route('POST /login', function () {
        $data = Flight::request()->data->getData();

        $response = Flight::auth_service()->login($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::json(['message' => $response['error']], 500);
        }
    });


});
