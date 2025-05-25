<?php

require_once __DIR__ . '/../services/ReviewService.php';

Flight::group('/reviews', function () {
    $service = new ReviewService();

    /**
     * @OA\Get(
     *     path="/reviews",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(response=200, description="List of reviews")
     * )
     */
    Flight::route('GET /', function () use ($service) {
        Flight::json($service->getAll());
    });

    /**
     * @OA\Get(
     *     path="/reviews/{id}",
     *     summary="Get review by ID",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Review object")
     * )
     */
    Flight::route('GET /@id', function ($id) use ($service) {
        Flight::json($service->getById($id));
    });

    /**
     * @OA\Post(
     *     path="/reviews",
     *     summary="Create new review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rating", "comment", "user_id"},
     *             @OA\Property(property="rating", type="number", format="float"),
     *             @OA\Property(property="comment", type="string"),
     *             @OA\Property(property="user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Review created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        $data = Flight::request()->data->getData();
        $id = $service->add($data);
        Flight::json(["review_id" => $id], 201);
    });

    /**
     * @OA\Put(
     *     path="/reviews",
     *     summary="Update review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"review_id", "rating", "comment"},
     *             @OA\Property(property="review_id", type="integer"),
     *             @OA\Property(property="rating", type="number", format="float"),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Review updated")
     * )
     */
    Flight::route('PUT /', function () use ($service) {
        $data = Flight::request()->data->getData();
        Flight::json($service->update($data));
    });

    /**
     * @OA\Delete(
     *     path="/reviews/{id}",
     *     summary="Delete review",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Review deleted")
     * )
     */
    Flight::route('DELETE /@id', function ($id) use ($service) {
        Flight::json($service->delete($id));
    });
});
