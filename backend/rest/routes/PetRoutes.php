<?php

require_once __DIR__ . '/../services/PetService.php';

Flight::group('/pets', function () {
    $service = new PetService();

    /**
     * @OA\Get(
     *     path="/pets",
     *     summary="Get all pets",
     *     tags={"Pets"},
     *     @OA\Response(response=200, description="List of pets")
     * )
     */
    Flight::route('GET /', function () use ($service) {
        try {
            Flight::json($service->getAllPets());
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Get(
     *     path="/pets/{id}",
     *     summary="Get pet by ID",
     *     tags={"Pets"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pet object")
     * )
     */
    Flight::route('GET /@id', function ($id) use ($service) {
        try {
            Flight::json($service->getPetById($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404); 
        }
    });

    /**
     * @OA\Post(
     *     path="/pets",
     *     summary="Create new pet",
     *     tags={"Pets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "species", "breed", "age", "description", "status", "image"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="species", type="string"),
     *             @OA\Property(property="breed", type="string"),
     *             @OA\Property(property="age", type="integer"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="image", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pet created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        try {
            // Create new pet
            $data = Flight::request()->data->getData();
            $id = $service->createPet($data);
            Flight::json(["pet_id" => $id], 201);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Put(
     *     path="/pets",
     *     summary="Update pet",
     *     tags={"Pets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pet_id", "name", "species", "breed", "age", "description", "status", "image"},
     *             @OA\Property(property="pet_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="species", type="string"),
     *             @OA\Property(property="breed", type="string"),
     *             @OA\Property(property="age", type="integer"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="image", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pet updated")
     * )
     */
    Flight::route('PUT /', function () use ($service) {
        try {
            $data = Flight::request()->data->getData();
            Flight::json($service->updatePet($data));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Delete(
     *     path="/pets/{id}",
     *     summary="Delete pet",
     *     tags={"Pets"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pet deleted")
     * )
     */
    Flight::route('DELETE /@id', function ($id) use ($service) {
        try {
            Flight::json($service->deletePet($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404); 
        }
    });
});
?>
