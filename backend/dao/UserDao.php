<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function getAllUsers() {
        return $this->fetchAll("SELECT * FROM users");
    }

    public function getUserById($id) {
        return $this->fetchOne("SELECT * FROM users WHERE user_id = :id", [':id' => $id]);
    }

    public function addUser($user) {
        $this->execute("INSERT INTO users (name, email, password, phone, role, created_at) 
                        VALUES (:name, :email, :password, :phone, :role, NOW())", $user);
        return $this->lastInsertId();
    }

    public function updateUser($user) {
        return $this->execute("UPDATE users SET name = :name, email = :email, password = :password, 
                               phone = :phone, role = :role WHERE user_id = :user_id", $user);
    }

    public function deleteUser($id) {
        return $this->execute("DELETE FROM users WHERE user_id = :id", [':id' => $id]);
    }
}
?>
