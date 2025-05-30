<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AdoptionDao.php';
require_once __DIR__ . '/../dao/PetDao.php';

class AdoptionService extends BaseService {
    private $petDao;

    public function __construct() {
        $this->petDao = new PetDao();
        parent::__construct(new AdoptionDao());

    }

    public function createAdoption($adoptionData) {
        try {
            $requiredFields = ['status', 'user_id', 'pet_id'];

            foreach ($requiredFields as $field) {
                if (empty($adoptionData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            $pet = $this->petDao->getById($adoptionData['pet_id']);
            if (!$pet) {
                throw new Exception("Pet not found.");
            }

            return $this->add($adoptionData);
        } catch (Exception $e) {
            throw new Exception("Error creating adoption: " . $e->getMessage());
        }
    }

    public function updateAdoption($adoptionData) {
        try {
            if (empty($adoptionData['adoption_id'])) {
                throw new Exception("Adoption ID is required to update.");
            }

            $existingAdoption = $this->dao->getAdoptionById($adoptionData['adoption_id']);
            if (!$existingAdoption) {
                throw new Exception("No adoption found with ID {$adoptionData['adoption_id']}.");
            }

            $updatedData = array_filter($adoptionData, fn($value) => !empty($value));

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->dao->updateAdoption($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating adoption: " . $e->getMessage());
        }
    }

    public function deleteAdoption($id) {
        try {
            if (empty($id)) {
                throw new Exception("Adoption ID is required to delete.");
            }

            $existingAdoption = $this->dao->getAdoptionById($id);
            if (!$existingAdoption) {
                throw new Exception("No adoption found with ID {$id}.");
            }

            return $this->dao->deleteAdoption($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting adoption: " . $e->getMessage());
        }
    }

    public function getAdoptionById($id) {
        return $this->dao->getAdoptionById($id);
    }

    public function getAllAdoptions() {
        return $this->dao->getAllAdoptions();
    }

    public function adoptPet($userId, $petId) {
        if (empty($userId) || empty($petId)) {
            throw new Exception("User ID and Pet ID are required.");
        }
        return $this->dao->adoptPet($userId, $petId);
    }

    public function getPendingRequestsWithUserAndPet() {
        return $this->dao->getPendingRequestsWithUserAndPet();
    }

    public function getApprovedAdoptedPets() {
        return $this->dao->getApprovedAdoptedPets();
    }
    

    public function approveAdoption($id) {
        $adoption = $this->getById($id);
        if (!$adoption) {
            throw new Exception("Adoption not found");
        }
    
        $this->update([
            'adoption_id' => $id,
            'status' => 'approved',
            'request_date' => $adoption['request_date'],
            'user_id' => $adoption['user_id'],
            'pet_id' => $adoption['pet_id']
        ]);
    
        Flight::pet_service()->markAsAdopted($adoption['pet_id']);
    
        return true;
    }
    
    
}
