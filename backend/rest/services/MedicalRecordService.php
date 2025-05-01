<?php

require_once __DIR__ . '/../dao/MedicalRecordDao.php';
require_once __DIR__ . '/../dao/PetDao.php';

class MedicalRecordService {
    private $medicalRecordDao;
    private $petDao;

    public function __construct() {
        $this->medicalRecordDao = new MedicalRecordDao();
        $this->petDao = new PetDao();
    }

    public function getAllRecords() {
        try {
            return $this->medicalRecordDao->getAllRecords();
        } catch (Exception $e) {
            throw new Exception("Error retrieving records: " . $e->getMessage());
        }
    }

    public function getRecordById($id) {
        try {
            $record = $this->medicalRecordDao->getRecordById($id);
            if (!$record) {
                throw new Exception("No medical record found with ID {$id}.");
            }

            return $record;
        } catch (Exception $e) {
            throw new Exception("Error retrieving record: " . $e->getMessage());
        }
    }

    public function createRecord($recordData) {
        try {
            $requiredFields = ['pet_id', 'vaccinations', 'medical_conditions', 'last_checkup_date'];

            foreach ($requiredFields as $field) {
                if (empty($recordData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            $pet = $this->petDao->getPetById($recordData['pet_id']);
            if (!$pet) {
                throw new Exception("Pet not found.");
            }

            return $this->medicalRecordDao->addRecord($recordData);
        } catch (Exception $e) {
            throw new Exception("Error creating record: " . $e->getMessage());
        }
    }

    public function updateRecord($recordData) {
        try {
            if (empty($recordData['medical_record_id'])) {
                throw new Exception("Medical record ID is required to update.");
            }

            $existingRecord = $this->medicalRecordDao->getRecordById($recordData['medical_record_id']);
            if (!$existingRecord) {
                throw new Exception("No medical record found with ID {$recordData['medical_record_id']}.");
            }

            $updatedData = array_filter($recordData, function($value) {
                return !empty($value);
            });

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->medicalRecordDao->updateRecord($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating record: " . $e->getMessage());
        }
    }

    public function deleteRecord($id) {
        try {
            if (empty($id)) {
                throw new Exception("Medical record ID is required to delete.");
            }

            $existingRecord = $this->medicalRecordDao->getRecordById($id);
            if (!$existingRecord) {
                throw new Exception("No medical record found with ID {$id}.");
            }

            return $this->medicalRecordDao->deleteRecord($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }
}

?>
