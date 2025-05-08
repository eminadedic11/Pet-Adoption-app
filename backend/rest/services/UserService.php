<?php

require_once __DIR__ . '/../dao/UserDao.php';

class UserService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function getAllUsers() {
        try {
            return $this->userDao->getAllUsers();
        } catch (Exception $e) {
            throw new Exception("Error retrieving users: " . $e->getMessage());
        }
    }

    public function getUserById($id) {
        try {
            $user = $this->userDao->getUserById($id);
            if (!$user) {
                throw new Exception("No user found with ID {$id}.");
            }

            return $user;
        } catch (Exception $e) {
            throw new Exception("Error retrieving user: " . $e->getMessage());
        }
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

            $existingUser = $this->userDao->getUserByEmail($userData['email']);
            if ($existingUser) {
                throw new Exception("Email already exists.");
            }

            return $this->userDao->addUser($userData);
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }

    public function updateUser($userData) {
        try {
            $existingUser = $this->userDao->getUserById($userData['user_id']);
            if (!$existingUser) {
                throw new Exception("No user found with ID {$userData['user_id']}.");
            }

            if (!empty($userData['email']) && !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $updatedData = array_filter($userData, function($value) {
                return !empty($value);  
            });

            if (empty($updatedData)) {
                throw new Exception("No data to update.");
            }

            return $this->userDao->updateUser($updatedData);
        } catch (Exception $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            if (empty($id)) {
                throw new Exception("User ID is required to delete.");
            }

            $existingUser = $this->userDao->getUserById($id);
            if (!$existingUser) {
                throw new Exception("No user found with ID {$id}.");
            }

            return $this->userDao->deleteUser($id);
        } catch (Exception $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }
}
?>
