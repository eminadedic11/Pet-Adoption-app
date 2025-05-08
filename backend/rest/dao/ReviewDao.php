<?php

require_once 'BaseDao.php';

class ReviewDao extends BaseDao {
    public function getAllReviews() {
        return $this->fetchAll("SELECT * FROM reviews");
    }

    public function getReviewById($id) {
        return $this->fetchOne("SELECT * FROM reviews WHERE review_id = :id", [':id' => $id]);
    }

    public function addReview($review) {
        $this->execute("INSERT INTO reviews (rating, comment, created_at, user_id)
                        VALUES (:rating, :comment, NOW(), :user_id)", $review);
        return $this->lastInsertId();
    }

    public function updateReview($review) {
        return $this->execute("UPDATE reviews SET rating = :rating, comment = :comment 
                               WHERE review_id = :review_id", $review);
    }

    public function deleteReview($id) {
        return $this->execute("DELETE FROM reviews WHERE review_id = :id", [':id' => $id]);
    }
}
?>
