<?php

require_once __DIR__ . '/../dao/AdoptionDao.php';
require_once __DIR__ . '/../dao/PetDao.php';

class AdoptionService {
    private $adoptionDao;
    private $petDao;

    public function __construct() {
        $this->adoptionDao = new AdoptionDao();
        $this->petDao = new PetDao();
    }

    public function getAllAdoptions() {
        try {
            return $this->adoptionDao->getAllAdoptions();
        } catch (Exception $e) {
            throw new Exception("Error retrieving adoptions: " . $e->getMessage());
        }
    }

    public function getAdoptionById($id) {
        try {
            $adoption = $this->adoptionDao->getAdoptionById($id);
            if (!$adoption) {
                throw new Exception("No adoption found with ID {$id}.");
            }

            return $adoption;
        } catch (Exception $e) {
            throw new Exception("Error retrieving adoption: " . $e->getMessage());
        }
    }

    public function createAdoption($adoptionData) {
        try {
            $requiredFields = ['status', 'user_id', 'pet_id'];
            
            foreach ($requiredFields as $field) {
                if (empty($adoptionData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }
        
            $pet = $this->petDao->getPetById($adoptionData['pet_id']);
            if (!$pet) {
                throw new Exception("Pet not found.");
            }

            return $this->adoptionDao->addAdoption($adoptionData);
        } catch (Exception $e) {
            throw new Exception("Error creating adoption: " . $e->getMessage());
        }
    }

    public function updateAdoption($adoptionData) {
        try {
            $existingAdoption = $this->adoptionDao->getAdoptionById($adoptionData['adoption_id']);
            if (!$existingAdoption) {
                throw new Exception("No adoption found with ID {$adoptionData['adoption_id']}.");
            }

            $updatedData = array_filter($adoptionData, function($value) {
                return !empty($value); 
            });

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->adoptionDao->updateAdoption($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating adoption: " . $e->getMessage());
        }
    }

    public function deleteAdoption($id) {
        try {
            if (empty($id)) {
                throw new Exception("Adoption ID is required to delete.");
            }

            $existingAdoption = $this->adoptionDao->getAdoptionById($id);
            if (!$existingAdoption) {
                throw new Exception("No adoption found with ID {$id}.");
            }

            return $this->adoptionDao->deleteAdoption($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting adoption: " . $e->getMessage());
        }
    }
}

?>
