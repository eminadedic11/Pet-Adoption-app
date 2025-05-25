<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public function verifyToken()
    {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        if (!$token) {
            Flight::halt(401, "Missing authorization header!");
        }

        if (str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        try {
            $decoded_token = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

            Flight::set('user', $decoded_token->user);
            Flight::set('jwt_token', $token);
            return true;
        } catch (Exception $e) {
            error_log("Invalid token: " . $e->getMessage());
            Flight::halt(401, "Token invalid");
        }
    }

    public function authorizeRole($requiredRole)
    {
        $user = Flight::get('user');
        if (!isset($user->role) || $user->role !== $requiredRole) {
            error_log("Access denied. Role required: $requiredRole, got: " . ($user->role ?? 'undefined'));
            Flight::halt(403, 'Access denied: insufficient privileges');
        }
    }
}

