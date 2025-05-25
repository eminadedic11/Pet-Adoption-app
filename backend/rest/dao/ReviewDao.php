<?php

require_once 'BaseDao.php';

class ReviewDao extends BaseDao {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM reviews");
    }

    public function getById($id) {
        return $this->fetchOne("SELECT * FROM reviews WHERE review_id = :id", [':id' => $id]);
    }

    public function add($review) {
        $this->execute("INSERT INTO reviews (rating, comment, created_at, user_id)
                        VALUES (:rating, :comment, NOW(), :user_id)", $review);
        return $this->lastInsertId();
    }

    public function update($review) {
        return $this->execute("UPDATE reviews SET 
                                rating = :rating, 
                                comment = :comment 
                                WHERE review_id = :review_id", $review);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM reviews WHERE review_id = :id", [':id' => $id]);
    }
}
