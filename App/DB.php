<?php

namespace App;

use PDO;

class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'internmatchv2';

    public function connect(): PDO
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    public function fetchAllRow($sql, array $params = []): bool|array
    {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        // Bind Parameters (if any)
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR); // Use appropriate data type
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteRow($sql, array $params = []): bool
    {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR); // Use appropriate data type
            }
        }

        try {
            $stmt->execute();
            return true; // Rows affected (may be 0)
        } catch (PDOException $e) {
            // Handle potential errors
            error_log("Error deleting row: " . $e->getMessage());
            return false;
        }
    }

    public function insertRow($sql, array $params = []): bool
    {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR); // Use appropriate data type
            }
        }

        try {
            $stmt->execute();
            return true; // Rows affected
        } catch (PDOException $e) {
            // Handle potential errors
            error_log("Error inserting row: " . $e->getMessage());
            return false;
        }
    }

    public function isDataExists($sql, array $params = []): bool
    {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR); // Use appropriate data type
            }
        }

        try {
            $stmt->execute();
            return $stmt->rowCount() > 0; // Data exists
        } catch (PDOException $e) {
            // Handle potential errors
            error_log("Error checking data existence: " . $e->getMessage());
            return false; // Assume data doesn't exist on error
        }
    }

    public function updateData($sql, array $params = []): bool
    {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR); // Use appropriate data type
            }
        }

        try {
            $stmt->execute();
            return true; // Rows affected (may be 0)
        } catch (PDOException $e) {
            // Handle potential errors
            error_log("Error updating data: " . $e->getMessage());
            return false;
        }
    }




}