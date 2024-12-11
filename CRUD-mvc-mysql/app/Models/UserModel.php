<?php

namespace App\Models;

use App\Config\ConnectDB;
use Exception;
use PDO;

class UserModel
{

    private $conn;
    private $data;
    private $sql;
    private $pdo;
    private $modelData;
    private $primaryKey;


    public function __construct()
    {
        $this->data = [];
        $this->modelData = ['user_user', 'user_password', 'userStatus_fk', 'role_fk'];
        $this->primaryKey = 'user_id';
    }


    public function findAll()
    {
        try {
            $this->conn = new ConnectDB();
            $this->pdo = $this->conn->connect();
            $this->sql = "SELECT * FROM user";
            $result = $this->pdo->prepare($this->sql);
            $result->execute();
            $results = $result->fetchAll(PDO::FETCH_ASSOC);
            $this->data = $results;
        } catch (Exception $e) {
            $this->data = [];
            $this->data['status'] = 404;
            $this->data['message'] = $e->getMessage();
        }
        return $this->data;
    }


    public function findId(int $id): array
    {
        try {
            $this->conn = new ConnectDB();
            $this->pdo = $this->conn->connect();
            $this->sql = "SELECT * FROM user WHERE $this->primaryKey ={$id}";
            $result = $this->pdo->prepare($this->sql);
            $result->execute();
            $results = $result->fetchAll(PDO::FETCH_ASSOC);
            $this->data = $results;
        } catch (Exception $e) {
            $this->data['data'] = [];
            $this->data['status'] = 404;
            $this->data['message'] = $e->getMessage();
        }
        return $this->data;
    }


    public function create(array $user): array
    {
        try {
            if ($this->validateModel($user)) {
                $this->conn = new ConnectDB();
                $this->pdo = $this->conn->connect();
                $this->sql = "INSERT INTO user(user_user, user_password,userStatus_fk,role_fk) VALUES (?,?,?,?)";
                $stmt = $this->pdo->prepare($this->sql);
                $passwordHast = password_hash($user[$this->modelData[1]], PASSWORD_DEFAULT);
                $stmt->bindParam(1, $user[$this->modelData[0]]);
                $stmt->bindParam(2, $passwordHast);
                $stmt->bindParam(3, $user[$this->modelData[2]]);
                $stmt->bindParam(4, $user[$this->modelData[3]]);
                $stmt->execute();
                $last_id = $this->pdo->lastInsertId();
                $this->data['newId'] = $last_id;
            } else {
                $this->data['data'] = [];
                $this->data['status'] = 404;
                $this->data['message'] = 'Error';
            }
        } catch (Exception $e) {
            $this->data['data'] = [];
            $this->data['status'] = 404;
            $this->data['message'] = $e->getMessage();
        }
        return $this->data;
    }


    public function update(array $user, int $id): array
    {
        try {
            if ($this->validateModel($user)) {
                $this->conn = new ConnectDB();
                $this->pdo = $this->conn->connect();
                $this->sql = "UPDATE user SET userStatus_fk=?,role_fk=? WHERE $this->primaryKey=?";
                $stmt = $this->pdo->prepare($this->sql);
                $stmt->bindParam(1, $user[$this->modelData[2]]);
                $stmt->bindParam(2, $user[$this->modelData[3]]);
                $stmt->bindParam(3, $id);
                $stmt->execute();
                $this->data['updateId'] = $id;
            } else {
                $this->data['data'] = [];
                $this->data['status'] = 404;
                $this->data['message'] = 'Error';
            }
        } catch (Exception $e) {
            $this->data['data'] = [];
            $this->data['status'] = 404;
            $this->data['message'] = $e->getMessage();
        }
        return $this->data;
    }


    public function delete(int $id): array
    {
        try {
            $this->conn = new ConnectDB();
            $this->pdo = $this->conn->connect();
            $this->sql = "DELETE FROM user WHERE $this->primaryKey=?";
            $stmt = $this->pdo->prepare($this->sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $this->data['deleteId'] = $id;
        } catch (Exception $e) {
            $this->data['data'] = [];
            $this->data['status'] = 404;
            $this->data['message'] = $e->getMessage();
        }
        return $this->data;
    }

    private function validateModel($array): bool
    {
        $validate = true;
        for ($i = 0; $i < count($array); $i++) {
            if (!empty($user[$this->modelData[$i]])) {
                $validate = false;
                break;
            }
        }
        return $validate;
    }
}