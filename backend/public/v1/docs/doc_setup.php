<?php

/**
 * @OA\Info(
 *     title="API",
 *     description="Web programming API",
 *     version="1.0",
 *     @OA\Contact(
 *         email="emina.dedic@stu.ibu.edu.ba",
 *         name="Emina Dedic"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:80/pet-adoption-app/backend",
 *     description="API server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
