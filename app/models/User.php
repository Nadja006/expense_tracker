<?php

class User{

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function registerUser($username, $password, $email){
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        if(!$stmt->execute()){
            die($stmt->error);
        }
        $stmt->close();
    }

    public function userExists($username, $email){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return true;
        }

        $stmt->close();

        return false;
    }

    public function getUserByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $result;
    }
}

?>