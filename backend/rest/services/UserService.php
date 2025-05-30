<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }

    public function createUser($userData) {
        try {
            $requiredFields = ['name', 'email', 'password', 'phone', 'role'];

            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
                    throw new Exception("Missing required field: {$field}.");
                }
            }

            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $existingUser = $this->dao->getUserByEmail($userData['email']);
            if ($existingUser) {
                throw new Exception("Email already exists.");
            }

            return $this->add($userData);
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }

    public function updateUser($userData) {
        try {
            if (empty($userData['user_id'])) {
                throw new Exception("User ID is required to update.");
            }

            $existingUser = $this->dao->getById($userData['user_id']);
            if (!$existingUser) {
                throw new Exception("No user found with ID {$userData['user_id']}.");
            }

            if (!empty($userData['email']) && !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $updatedData = array_filter($userData, fn($value) => !empty($value));

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->update($updatedData); 
        } catch (Exception $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            if (empty($id)) {
                throw new Exception("User ID is required to delete.");
            }

            $existingUser = $this->dao->getById($id);
            if (!$existingUser) {
                throw new Exception("No user found with ID {$id}.");
            }

            return $this->delete($id); 
        } catch (Exception $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    public function getUserById($id) {
        return $this->getById($id); 
    }

    public function getAllUsers() {
        return $this->getAll(); 
    }
}
