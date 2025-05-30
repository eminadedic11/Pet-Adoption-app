<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService {
    public function __construct() {
        parent::__construct(new ReviewDao());
    }

    public function createReview($reviewData) {
        try {
            $requiredFields = ['rating', 'comment', 'user_id'];

            foreach ($requiredFields as $field) {
                if (empty($reviewData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            if ($reviewData['rating'] < 1 || $reviewData['rating'] > 5) {
                throw new Exception("Rating must be between 1 and 5.");
            }

            return $this->add($reviewData);
        } catch (Exception $e) {
            throw new Exception("Error creating review: " . $e->getMessage());
        }
    }

    public function updateReview($reviewData) {
        try {
            if (empty($reviewData['review_id'])) {
                throw new Exception("Review ID is required to update.");
            }

            $existing = $this->dao->getById($reviewData['review_id']);
            if (!$existing) {
                throw new Exception("No review found with ID {$reviewData['review_id']}.");
            }

            $updatedData = array_filter($reviewData, fn($value) => !empty($value));

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->update($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating review: " . $e->getMessage());
        }
    }

    public function deleteReview($id) {
        try {
            if (empty($id)) {
                throw new Exception("Review ID is required to delete.");
            }

            $existing = $this->dao->getById($id);
            if (!$existing) {
                throw new Exception("No review found with ID {$id}.");
            }

            return $this->delete($id); 
        } catch (Exception $e) {
            throw new Exception("Error deleting review: " . $e->getMessage());
        }
    }

    public function getReviewById($id) {
        return $this->getById($id); 
    }

    public function getAllReviews() {
        return $this->getAll();
    }
}
