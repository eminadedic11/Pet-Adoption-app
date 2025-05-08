<?php

require_once __DIR__ . '/../services/AdoptionService.php';

Flight::group('/adoptions', function () {
    $service = new AdoptionService();

    /**
     * @OA\Get(
     *     path="/adoptions",
     *     summary="Get all adoptions",
     *     tags={"Adoptions"},
     *     @OA\Response(response=200, description="List of adoptions")
     * )
     */
    Flight::route('GET /', function () use ($service) {
        try {
            Flight::json($service->getAllAdoptions());
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Get(
     *     path="/adoptions/{id}",
     *     summary="Get adoption by ID",
     *     tags={"Adoptions"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Adoption object")
     * )
     */
    Flight::route('GET /@id', function ($id) use ($service) {
        try {
            Flight::json($service->getAdoptionById($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });

    /**
     * @OA\Post(
     *     path="/adoptions",
     *     summary="Create new adoption request",
     *     tags={"Adoptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status", "request_date", "user_id", "pet_id"},
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="request_date", type="string", format="date"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Adoption created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        try {
            $data = Flight::request()->data->getData();
            $id = $service->createAdoption($data);
            Flight::json(["adoption_id" => $id], 201);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Put(
     *     path="/adoptions",
     *     summary="Update adoption",
     *     tags={"Adoptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adoption_id", "status", "request_date", "user_id", "pet_id"},
     *             @OA\Property(property="adoption_id", type="integer"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="request_date", type="string", format="date"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Adoption updated")
     * )
     */
    Flight::route('PUT /', function () use ($service) {
        try {
            $data = Flight::request()->data->getData();
            Flight::json($service->updateAdoption($data));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Delete(
     *     path="/adoptions/{id}",
     *     summary="Delete adoption",
     *     tags={"Adoptions"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Adoption deleted")
     * )
     */
    Flight::route('DELETE /@id', function ($id) use ($service) {
        try {
            Flight::json($service->deleteAdoption($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });
});

?>
