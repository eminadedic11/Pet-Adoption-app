<?php
require_once 'BaseDao.php';


class AdoptionDao extends BaseDao {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM adoptions");
    }

    public function getById($id) {
        return $this->fetchOne("SELECT * FROM adoptions WHERE adoption_id = :id", [':id' => $id]);
    }

    public function add($adoption) {
        $this->execute("INSERT INTO adoptions (status, request_date, user_id, pet_id)
                        VALUES (:status, :request_date, :user_id, :pet_id)", $adoption);
        return $this->lastInsertId();
    }

    public function update($adoption) {
        return $this->execute("UPDATE adoptions SET status = :status, request_date = :request_date, 
                               user_id = :user_id, pet_id = :pet_id WHERE adoption_id = :adoption_id", $adoption);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM adoptions WHERE adoption_id = :id", [':id' => $id]);
    }

    public function adoptPet($userId, $petId) {
        return $this->execute(
            "INSERT INTO adoptions (user_id, pet_id, request_date, status) 
             VALUES (:user_id, :pet_id, NOW(), 'pending')",
            [':user_id' => $userId, ':pet_id' => $petId]
        );
    }

    public function getPendingRequestsWithUserAndPet() {
        $result = $this->fetchAll(
            "SELECT 
                a.adoption_id,
                a.status,
                u.name AS user_name,
                u.email AS user_email,
                p.name AS pet_name
             FROM adoptions a
             LEFT JOIN users u ON a.user_id = u.user_id
             LEFT JOIN pets p ON a.pet_id = p.pet_id
             WHERE a.status = 'pending'
             ORDER BY a.request_date DESC"
        );
        return $result;
    }

    public function getApprovedAdoptedPets() {
        return $this->fetchAll("
            SELECT p.name AS pet_name, p.species, p.breed, p.description, p.image AS image_url
            FROM adoptions a
            JOIN pets p ON a.pet_id = p.pet_id
            WHERE a.status = 'approved'
        ");
    }
    
    
}
