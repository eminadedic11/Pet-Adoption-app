<?php

require_once __DIR__ . '/../services/MedicalRecordService.php';

Flight::group('/records', function () {
    $service = new MedicalRecordService();

    /**
     * @OA\Get(
     *     path="/records",
     *     summary="Get all medical records",
     *     tags={"Medical Records"},
     *     @OA\Response(response=200, description="List of medical records")
     * )
     */
    Flight::route('GET /', function () use ($service) {
        try {
            Flight::json($service->getAllRecords());
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Get(
     *     path="/records/{id}",
     *     summary="Get medical record by ID",
     *     tags={"Medical Records"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Medical record object")
     * )
     */
    Flight::route('GET /@id', function ($id) use ($service) {
        try {
            Flight::json($service->getRecordById($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });

    /**
     * @OA\Post(
     *     path="/records",
     *     summary="Create new medical record",
     *     tags={"Medical Records"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"vaccinations", "medical_conditions", "last_checkup_date", "pet_id"},
     *             @OA\Property(property="vaccinations", type="string"),
     *             @OA\Property(property="medical_conditions", type="string"),
     *             @OA\Property(property="last_checkup_date", type="string", format="date"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Medical record created")
     * )
     */
    Flight::route('POST /', function () use ($service) {
        try {
            $data = Flight::request()->data->getData();
            $id = $service->createRecord($data);
            Flight::json(["medical_record_id" => $id], 201);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Put(
     *     path="/records",
     *     summary="Update medical record",
     *     tags={"Medical Records"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"medical_record_id", "vaccinations", "medical_conditions", "last_checkup_date", "pet_id"},
     *             @OA\Property(property="medical_record_id", type="integer"),
     *             @OA\Property(property="vaccinations", type="string"),
     *             @OA\Property(property="medical_conditions", type="string"),
     *             @OA\Property(property="last_checkup_date", type="string", format="date"),
     *             @OA\Property(property="pet_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Medical record updated")
     * )
     */
    Flight::route('PUT /', function () use ($service) {
        try {
            $data = Flight::request()->data->getData();
            Flight::json($service->updateRecord($data));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    });

    /**
     * @OA\Delete(
     *     path="/records/{id}",
     *     summary="Delete medical record",
     *     tags={"Medical Records"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Medical record deleted")
     * )
     */
    Flight::route('DELETE /@id', function ($id) use ($service) {
        try {
            Flight::json($service->deleteRecord($id));
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });
});

?>