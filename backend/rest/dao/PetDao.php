<?php

require_once 'BaseDao.php';

class PetDao extends BaseDao {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM pets");
    }

    public function getById($id) {
        return $this->fetchOne("SELECT * FROM pets WHERE pet_id = :id", [':id' => $id]);
    }

    public function add($pet) {
        $this->execute("INSERT INTO pets (name, species, breed, age, description, status, image, created_at)
                        VALUES (:name, :species, :breed, :age, :description, :status, :image, NOW())", $pet);
        return $this->lastInsertId();
    }

    public function update($pet) {
        return $this->execute("UPDATE pets SET 
                                name = :name, 
                                species = :species, 
                                breed = :breed, 
                                age = :age, 
                                description = :description, 
                                status = :status, 
                                image = :image 
                                WHERE pet_id = :pet_id", $pet);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM pets WHERE pet_id = :id", [':id' => $id]);
    }
}
