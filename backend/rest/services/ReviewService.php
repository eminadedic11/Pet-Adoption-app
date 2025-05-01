<?php

require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService {
    private $reviewDao;

    public function __construct() {
        $this->reviewDao = new ReviewDao();
    }

    public function getAllReviews() {
        try {
            return $this->reviewDao->getAllReviews();
        } catch (Exception $e) {
            throw new Exception("Error retrieving reviews: " . $e->getMessage());
        }
    }

    public function getReviewById($id) {
        try {
            $review = $this->reviewDao->getReviewById($id);
            if (!$review) {
                throw new Exception("No review found with ID {$id}.");
            }

            return $review;
        } catch (Exception $e) {
            throw new Exception("Error retrieving review: " . $e->getMessage());
        }
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
    
            return $this->reviewDao->addReview($reviewData);
        } catch (Exception $e) {
            throw new Exception("Error creating review: " . $e->getMessage());
        }
    }
    

    public function updateReview($reviewData) {
        try {
            if (empty($reviewData['review_id'])) {
                throw new Exception("Review ID is required to update.");
            }

            $existingReview = $this->reviewDao->getReviewById($reviewData['review_id']);
            if (!$existingReview) {
                throw new Exception("No review found with ID {$reviewData['review_id']}.");
            }

            $updatedData = array_filter($reviewData, function($value) {
                return !empty($value);  
            });

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->reviewDao->updateReview($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating review: " . $e->getMessage());
        }
    }

    public function deleteReview($id) {
        try {
            if (empty($id)) {
                throw new Exception("Review ID is required to delete.");
            }

            $existingReview = $this->reviewDao->getReviewById($id);
            if (!$existingReview) {
                throw new Exception("No review found with ID {$id}.");
            }

            return $this->reviewDao->deleteReview($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting review: " . $e->getMessage());
        }
    }
}

?>
