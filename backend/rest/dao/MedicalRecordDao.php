<?php

require_once 'BaseDao.php';

class MedicalRecordDao extends BaseDao {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM medical_records");
    }

    public function getById($id) {
        return $this->fetchOne("SELECT * FROM medical_records WHERE medical_record_id = :id", [':id' => $id]);
    }

    public function add($record) {
        $this->execute("INSERT INTO medical_records (vaccinations, medical_conditions, last_checkup_date, pet_id)
                        VALUES (:vaccinations, :medical_conditions, :last_checkup_date, :pet_id)", $record);
        return $this->lastInsertId();
    }

    public function update($record) {
        return $this->execute("UPDATE medical_records SET 
                                vaccinations = :vaccinations, 
                                medical_conditions = :medical_conditions, 
                                last_checkup_date = :last_checkup_date, 
                                pet_id = :pet_id 
                                WHERE medical_record_id = :medical_record_id", $record);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM medical_records WHERE medical_record_id = :id", [':id' => $id]);
    }
}
