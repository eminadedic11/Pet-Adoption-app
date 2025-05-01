<?php

require_once __DIR__ . '/../dao/PetDao.php';

class PetService {
    private $petDao;

    public function __construct() {
        $this->petDao = new PetDao();
    }

    public function getAllPets() {
        try {
            return $this->petDao->getAllPets();
        } catch (Exception $e) {
            throw new Exception("Error retrieving pets: " . $e->getMessage());
        }
    }

    public function getPetById($id) {
        try {
            $pet = $this->petDao->getPetById($id);
            if (!$pet) {
                throw new Exception("No pet found with ID {$id}.");
            }

            return $pet;
        } catch (Exception $e) {
            throw new Exception("Error retrieving pet: " . $e->getMessage());
        }
    }

    public function createPet($petData) {
        try {
            $requiredFields = ['name', 'species', 'breed', 'age', 'description', 'status', 'image'];
            
            foreach ($requiredFields as $field) {
                if (empty($petData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            if (empty($petData['age']) || !is_numeric($petData['age'])) {
                throw new Exception("Age must be provided and should be a valid number.");
            }

            return $this->petDao->addPet($petData);
        } catch (Exception $e) {
            throw new Exception("Error creating pet: " . $e->getMessage());
        }
    }

    public function updatePet($petData) {
        try {
            if (empty($petData['pet_id'])) {
                throw new Exception("Pet ID is required to update.");
            }

            $existingPet = $this->petDao->getPetById($petData['pet_id']);
            if (!$existingPet) {
                throw new Exception("No pet found with ID {$petData['pet_id']}.");
            }

            $updatedData = array_filter($petData, function($value) {
                return !empty($value);
            });

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->petDao->updatePet($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating pet: " . $e->getMessage());
        }
    }

    public function deletePet($id) {
        try {
            if (empty($id)) {
                throw new Exception("Pet ID is required to delete.");
            }

            $existingPet = $this->petDao->getPetById($id);
            if (!$existingPet) {
                throw new Exception("No pet found with ID {$id}.");
            }

            return $this->petDao->deletePet($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting pet: " . $e->getMessage());
        }
    }
}

?>
