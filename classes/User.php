<?php
require_once 'config/Database.php';

class User extends Database {

    private $table = "user";

    // CREATE
    public function create($nama, $email, $password) {
        $query = "INSERT INTO $this->table (nama, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $nama, $email, $password);
        return $stmt->execute();
    }

    // READ ALL
    public function readAll() {
        $query = "SELECT * FROM $this->table ORDER BY id_user DESC";
        return $this->conn->query($query);
    }

    // READ BY ID
    public function readById($id) {
        $query = "SELECT * FROM $this->table WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function update($id, $nama, $email) {
        $query = "UPDATE $this->table SET nama = ?, email = ? WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $nama, $email, $id);
        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
