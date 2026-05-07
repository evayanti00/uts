<?php
require_once __DIR__ . '/../config/database.php';

class Transaction extends Database {
    private $table = 'transaksi';

    public function create($id_product, $jumlah_beli) {
        $qry = "INSERT INTO $this->table (id_product, jumlah_beli) VALUES (?, ?)";
        $stmt = $this->conn->prepare($qry);

        if ($stmt === false) {
            die("Error prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id_product, $jumlah_beli);
        return $stmt->execute();
    }

    public function read() {
        $qry = "SELECT t.id_transaksi, p.nama_product, p.katagori, t.jumlah_beli, t.tanggal_transaksi
                FROM $this->table t
                JOIN product p ON t.id_product = p.id_product
                ORDER BY t.id_transaksi DESC";
        return $this->conn->query($qry);
    }
}
?>