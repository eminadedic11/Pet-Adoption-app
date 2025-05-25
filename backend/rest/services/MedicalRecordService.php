<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/MedicalRecordDao.php';
require_once __DIR__ . '/../dao/PetDao.php';

class MedicalRecordService extends BaseService {
    private $petDao;

    public function __construct() {
        $this->petDao = new PetDao();
        parent::__construct(new MedicalRecordDao());
    }

    public function createRecord($recordData) {
        try {
            $requiredFields = ['pet_id', 'vaccinations', 'medical_conditions', 'last_checkup_date'];

            foreach ($requiredFields as $field) {
                if (empty($recordData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            $pet = $this->petDao->getById($recordData['pet_id']);
            if (!$pet) {
                throw new Exception("Pet not found.");
            }

            return $this->add($recordData);
        } catch (Exception $e) {
            throw new Exception("Error creating record: " . $e->getMessage());
        }
    }

    public function updateRecord($recordData) {
        try {
            if (empty($recordData['medical_record_id'])) {
                throw new Exception("Medical record ID is required to update.");
            }

            $existing = $this->dao->getById($recordData['medical_record_id']);
            if (!$existing) {
                throw new Exception("No medical record found with ID {$recordData['medical_record_id']}.");
            }

            $updatedData = array_filter($recordData, fn($value) => !empty($value));

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->update($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating record: " . $e->getMessage());
        }
    }

    public function deleteRecord($id) {
        try {
            if (empty($id)) {
                throw new Exception("Medical record ID is required to delete.");
            }

            $existing = $this->dao->getById($id);
            if (!$existing) {
                throw new Exception("No medical record found with ID {$id}.");
            }

            return $this->delete($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }

    public function getRecordById($id) {
        return $this->getById($id);
    }

    public function getAllRecords() {
        return $this->getAll();
    }
}
