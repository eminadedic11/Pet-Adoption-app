<?php
require_once 'BaseDao.php';

class AdoptionDao extends BaseDao {
    public function getAllAdoptions() {
        return $this->fetchAll("SELECT * FROM adoptions");
    }

    public function getAdoptionById($id) {
        return $this->fetchOne("SELECT * FROM adoptions WHERE adoption_id = :id", [':id' => $id]);
    }

    public function addAdoption($adoption) {
        $this->execute("INSERT INTO adoptions (status, request_date, user_id, pet_id)
                        VALUES (:status, :request_date, :user_id, :pet_id)", $adoption);
        return $this->lastInsertId();
    }

    public function updateAdoption($adoption) {
        return $this->execute("UPDATE adoptions SET status = :status, request_date = :request_date, 
                               user_id = :user_id, pet_id = :pet_id WHERE adoption_id = :adoption_id", $adoption);
    }

    public function deleteAdoption($id) {
        return $this->execute("DELETE FROM adoptions WHERE adoption_id = :id", [':id' => $id]);
    }
}
?>
