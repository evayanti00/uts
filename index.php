<?php
require_once 'classes/product.php';
require_once 'classes/transaction.php';

$product = new Product();
$transaction = new Transaction();

$allProducts = $product->read();
$allTransactions = $transaction->read();

$totalProduk = $allProducts->num_rows;
$totalStok = 0;
$lowStock = 0;

while ($row = $allProducts->fetch_assoc()) {
    $totalStok += $row['stok'];
    if ($row['stok'] < 5) {
        $lowStock++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris</title>
</head>
<body>
    <h2>Dashboard Inventaris</h2>
    <p>
        <a href="index.php">Dashboard</a> |
        <a href="form_product.php">Produk</a> |
        <a href="transaksi.php">Transaksi</a>
    </p>

    <h3>Ringkasan</h3>
    <ul>
        <li>Total produk: <?= $totalProduk ?></li>
        <li>Total stok: <?= $totalStok ?></li>
        <li>Produk stok menipis (&lt; 5): <?= $lowStock ?></li>
        <li>Total transaksi: <?= $allTransactions->num_rows ?></li>
    </ul>

    <h3>Daftar Produk</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>
        <?php
        $products = $product->read();
        while ($row = $products->fetch_assoc()) {
            $status = $row['stok'] < 5 ? 'Stok Menipis' : 'Aman';
            echo "
                <tr>
                    <td>{$row['id_product']}</td>
                    <td>{$row['nama_product']}</td>
                    <td>{$row['katagori']}</td>
                    <td>Rp {$row['harga']}</td>
                    <td>{$row['stok']}</td>
                    <td>{$status}</td>
                </tr>
            ";
        }
        ?>
    </table>

    <h3>Rekap Transaksi Terbaru</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $transactions = $transaction->read();
        while ($row = $transactions->fetch_assoc()) {
            echo "
                <tr>
                    <td>{$row['id_transaksi']}</td>
                    <td>{$row['nama_product']}</td>
                    <td>{$row['katagori']}</td>
                    <td>{$row['jumlah_beli']}</td>
                    <td>{$row['tanggal_transaksi']}</td>
                </tr>
            ";
        }
        ?>
    </table>
</body>
</html>