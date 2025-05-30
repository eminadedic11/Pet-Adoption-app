<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $authDao;

    public function __construct() {
        $this->authDao = new UserDao();
        parent::__construct($this->authDao);

    }

    public function getUserByEmail($email) {
        return $this->authDao->getUserByEmail($email);

    }

    public function register($entity) {

        if (empty($entity['name'])) {
            return ['success' => false, 'error' => 'Name is required.'];
        }
        if (empty($entity['email'])) {
            return ['success' => false, 'error' => 'Email is required.'];
        }
        if (empty($entity['phone'])) {
            return ['success' => false, 'error' => 'Phone number is required.'];
        }
        if (empty($entity['password'])) {
            return ['success' => false, 'error' => 'Password is required.'];
        }
    
        if (!filter_var($entity['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }
    
        $phone = $entity['phone'];
        if (!preg_match('/^\d{9,10}$/', $phone)) {
            return ['success' => false, 'error' => 'Phone number must contain only digits and be 9 or 10 characters long.'];
        }
    
        $email_exists = $this->authDao->getUserByEmail($entity['email']);
        if ($email_exists) {
            return ['success' => false, 'error' => 'Email already registered.'];
        }
    
        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
    
        $entity['role'] = $entity['role'] ?? 'user';
    
        try {
            $user_id = $this->add($entity);
            $user = $this->getById($user_id);
            unset($user['password']);  
            return ['success' => true, 'data' => $user];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }
    
    
    public function login($entity) {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->authDao->getUserByEmail($entity['email']);
        if (!$user || !password_verify($entity['password'], $user['password'])) {
            return ['success' => false, 'error' => 'Invalid username or password.'];
        }

        unset($user['password']);

        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24)
        ];

        $token = JWT::encode(
            $jwt_payload,
            JWT_SECRET,
            'HS256'
        );

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];
    }
    
}
