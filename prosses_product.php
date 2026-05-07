<?php
require_once 'classes/product.php';
$product = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_product = trim($_POST['nama_product']);
    $katagori    = trim($_POST['katagori']);
    $harga        = (float) $_POST['harga'];
    $stok         = (int) $_POST['stok'];

    if ($harga < 0 || $stok < 0) {
        die('Harga dan stok tidak boleh negatif.');
    }

    if ($product->create($nama_product, $katagori, $harga, $stok)) {
        echo "<script>alert('Produk berhasil disimpan'); window.location='form_product.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan produk'); window.location='form_product.php';</script>";
    }
} else {
    echo 'Tidak valid';
}
?>