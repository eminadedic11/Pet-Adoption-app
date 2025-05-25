<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PetDao.php';

class PetService extends BaseService {

    public function __construct() {
        parent::__construct(new PetDao());
    }

    public function createPet($petData) {
        try {
            $requiredFields = ['name', 'species', 'breed', 'age', 'description', 'status', 'image'];
            
            foreach ($requiredFields as $field) {
                if (empty($petData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            if (!is_numeric($petData['age'])) {
                throw new Exception("Age must be a valid number.");
            }

            return $this->add($petData); 
        } catch (Exception $e) {
            throw new Exception("Error creating pet: " . $e->getMessage());
        }
    }

    public function updatePet($petData) {
        try {
            if (empty($petData['pet_id'])) {
                throw new Exception("Pet ID is required to update.");
            }

            $existingPet = $this->dao->getById($petData['pet_id']);
            if (!$existingPet) {
                throw new Exception("No pet found with ID {$petData['pet_id']}.");
            }

            $updatedData = array_filter($petData, fn($value) => !empty($value));

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->update($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating pet: " . $e->getMessage());
        }
    }

    public function deletePet($id) {
        try {
            if (empty($id)) {
                throw new Exception("Pet ID is required to delete.");
            }

            $existingPet = $this->dao->getById($id);
            if (!$existingPet) {
                throw new Exception("No pet found with ID {$id}.");
            }

            return $this->delete($id); 
        } catch (Exception $e) {
            throw new Exception("Error deleting pet: " . $e->getMessage());
        }
    }

    public function getPetById($id) {
        return $this->getById($id); 
    }

    public function getAllPets() {
        return $this->getAll();
    }

    public function markAsAdopted($petId) {
        if (empty($petId)) {
            throw new Exception("Pet ID is required to mark as adopted.");
        }
    
        $existingPet = $this->dao->getById($petId);
        if (!$existingPet) {
            throw new Exception("Pet not found with ID {$petId}.");
        }
    
        return $this->dao->update(['pet_id' => $petId, 'status' => 'adopted']);
    }
    
}
