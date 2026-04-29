<?php

class Facility {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllFacilities() {
        $stmt = $this->conn->prepare("SELECT * FROM facilities ORDER BY facility_name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFacilityById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM facilities WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFacility($data) {
        $query = "INSERT INTO facilities (facility_name, icon) VALUES (:facility_name, :icon)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facility_name', $data['facility_name']);
        $stmt->bindParam(':icon', $data['icon']);
        return $stmt->execute();
    }

    public function updateFacility($data) {
        $query = "UPDATE facilities SET facility_name = :facility_name, icon = :icon WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facility_name', $data['facility_name']);
        $stmt->bindParam(':icon', $data['icon']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function deleteFacility($id) {
        $stmt = $this->conn->prepare("DELETE FROM facilities WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countFacilities() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM facilities");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
