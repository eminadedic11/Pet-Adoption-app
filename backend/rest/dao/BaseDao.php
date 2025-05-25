<?php

require_once __DIR__ . '/../config.php';

class BaseDao {
    protected $connection;

    public function __construct() {
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $database = DB_NAME;
        $port = DB_PORT;

        try {
            $this->connection = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if (!$stmt) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if (!$stmt) return false;
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
