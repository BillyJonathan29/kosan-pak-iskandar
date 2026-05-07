<?php

class RoomFacility
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllRoomFacilities()
    {
        $query = "SELECT rf.id, rf.room_id, rf.facility_id,
                         r.room_number, k.name as kos_name,
                         f.facility_name, f.icon
                  FROM room_facilities rf
                  JOIN rooms r ON rf.room_id = r.id
                  JOIN kos k ON r.kos_id = k.id
                  JOIN facilities f ON rf.facility_id = f.id
                  ORDER BY k.name ASC, r.room_number ASC, f.facility_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomFacilityById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM room_facilities WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFacilitiesByRoom($room_id)
    {
        $query = "SELECT rf.id, rf.facility_id, f.facility_name, f.icon
                  FROM room_facilities rf
                  JOIN facilities f ON rf.facility_id = f.id
                  WHERE rf.room_id = :room_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addRoomFacility($data)
    {
        // Cek apakah sudah ada (hindari duplikasi)
        $check = $this->conn->prepare("SELECT id FROM room_facilities WHERE room_id = :room_id AND facility_id = :facility_id");
        $check->bindParam(':room_id', $data['room_id']);
        $check->bindParam(':facility_id', $data['facility_id']);
        $check->execute();
        if ($check->fetch()) {
            return false; // Sudah ada
        }

        $query = "INSERT INTO room_facilities (room_id, facility_id) VALUES (:room_id, :facility_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $data['room_id']);
        $stmt->bindParam(':facility_id', $data['facility_id']);
        return $stmt->execute();
    }

    /**
     * Tambah beberapa fasilitas sekaligus untuk satu kamar
     * @param int $room_id
     * @param array $facility_ids
     * @return int jumlah baris yang berhasil ditambahkan
     */
    public function addMultipleRoomFacilities($room_id, $facility_ids)
    {
        $inserted = 0;
        $insertQuery = "INSERT INTO room_facilities (room_id, facility_id) VALUES (:room_id, :facility_id)";
        foreach ($facility_ids as $fid) {
            // cek duplikasi
            $check = $this->conn->prepare("SELECT id FROM room_facilities WHERE room_id = :room_id AND facility_id = :facility_id");
            $check->execute([':room_id' => $room_id, ':facility_id' => $fid]);
            if ($check->fetch()) continue;

            $stmt = $this->conn->prepare($insertQuery);
            if ($stmt->execute([':room_id' => $room_id, ':facility_id' => $fid])) {
                $inserted++;
            }
        }

        return $inserted;
    }

    public function updateRoomFacility($data)
    {
        $query = "UPDATE room_facilities SET room_id = :room_id, facility_id = :facility_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $data['room_id']);
        $stmt->bindParam(':facility_id', $data['facility_id']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function deleteRoomFacility($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM room_facilities WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
