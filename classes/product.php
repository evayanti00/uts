<?php
require_once __DIR__ . '/../config/database.php';

class Product extends Database {
    private $table = 'product';

    public function create($nama_product, $katagori, $harga, $stok) {
        if ($harga < 0 || $stok < 0) {
            return false;
        }

        $qry = "INSERT INTO $this->table (nama_product, katagori, harga, stok) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ssdi", $nama_product, $katagori, $harga, $stok);
        return $stmt->execute();
    }

    public function read() {
        $qry = "SELECT * FROM $this->table ORDER BY id_product DESC";
        return $this->conn->query($qry);
    }

    public function readByID($id_product) {
        $qry = "SELECT * FROM $this->table WHERE id_product = ?";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id_product, $nama_product, $katagori, $harga, $stok) {
        if ($harga < 0 || $stok < 0) {
            return false;
        }

        $qry = "UPDATE $this->table SET nama_product = ?, katagori = ?, harga = ?, stok = ? WHERE id_product = ?";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ssdii", $nama_product, $katagori, $harga, $stok, $id_product);
        return $stmt->execute();
    }

    public function delete($id_product) {
        $qry = "DELETE FROM $this->table WHERE id_product = ?";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_product);
        return $stmt->execute();
    }

    public function reduceStock($id_product, $jumlah_beli) {
        $qry = "UPDATE $this->table SET stok = stok - ? WHERE id_product = ? AND stok >= ?";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("iii", $jumlah_beli, $id_product, $jumlah_beli);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>

