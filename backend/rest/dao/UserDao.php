<?php

require_once 'BaseDao.php';

class UserDao extends BaseDao {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM users");
    }

    public function getById($id) {
        return $this->fetchOne("SELECT * FROM users WHERE user_id = :id", [':id' => $id]);
    }

    public function add($user) {
        $this->execute("INSERT INTO users (name, email, password, phone, role, created_at) 
                        VALUES (:name, :email, :password, :phone, :role, NOW())", $user);
        return $this->lastInsertId();
    }

    public function update($user) {
        return $this->execute("UPDATE users SET 
                                name = :name, 
                                email = :email, 
                                password = :password, 
                                phone = :phone, 
                                role = :role 
                                WHERE user_id = :user_id", $user);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM users WHERE user_id = :id", [':id' => $id]);
    }

    public function getUserByEmail($email) {
        return $this->fetchOne("SELECT * FROM users WHERE email = :email", [':email' => $email]);
    }
}
