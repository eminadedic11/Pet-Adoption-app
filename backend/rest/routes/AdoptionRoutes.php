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
        Flight::json($service->getAll());
    });


    /**
     * @OA\Get(
     *     path="/adoptions/pending",
     *     summary="Get all pending adoption requests (admin only)",
     *     tags={"Adoptions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of pending adoption requests"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    Flight::route('GET /pending', function () use ($service) {
        Flight::auth_middleware()->authorizeRole('admin');

        $result = $service->getPendingRequestsWithUserAndPet();
        
        if (!$result) {
            Flight::json([], 200);
        }

        Flight::json($result);
    });

    /**
     * @OA\Get(
     *     path="/adoptions/approved",
     *     summary="Get all approved adoptions with pet info",
     *     tags={"Adoptions"},
     *     @OA\Response(response=200, description="List of approved adoptions")
     * )
     */
    Flight::route('GET /approved', function () use ($service) {
        Flight::json($service->getApprovedAdoptedPets());
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
        Flight::json($service->getById($id));
    });

    /**
     * @OA\Post(
     *     path="/adoptions",
     *     summary="Create new adoption request",
     *     tags={"Adoptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status", "user_id", "pet_id"},
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Adoption created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        $data = Flight::request()->data->getData();
        $data['request_date'] = date('Y-m-d');
        $id = $service->add($data);
        Flight::json(["adoption_id" => $id], 201);
    });

    /**
     * @OA\Put(
     *     path="/adoptions",
     *     summary="Update adoption",
     *     tags={"Adoptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adoption_id"},
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
        $data = Flight::request()->data->getData();
        Flight::json($service->update($data));
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
        Flight::json($service->delete($id));
    });

    /**
     * @OA\Post(
     *     path="/adoptions/adopt",
     *     summary="Adopt a pet",
     *     tags={"Adoptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "pet_id"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pet adopted")
     * )
     */
    Flight::route('POST /adopt', function () use ($service) {
        $data = Flight::request()->data->getData();
        $result = $service->adoptPet($data['user_id'], $data['pet_id']);
        Flight::json($result);

    });

    /**
     * @OA\Patch(
     *     path="/adoptions/{id}/approve",
     *     summary="Approve an adoption request (admin only)",
     *     tags={"Adoptions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Adoption approved"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Adoption not found")
     * )
     */
    Flight::route('PATCH /@id/approve', function ($id) use ($service) {
        Flight::auth_middleware()->authorizeRole('admin');

        try {
            $service->approveAdoption($id);
            Flight::json(['message' => 'Adoption approved.']);
        } catch (Exception $e) {
            Flight::halt(404, $e->getMessage());
        }
    });

    

    



    
});
