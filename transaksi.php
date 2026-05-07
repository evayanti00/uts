<?php
require_once 'classes/product.php';
require_once 'classes/transaction.php';

$product = new Product();
$transaction = new Transaction();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_product = isset($_POST['id_product']) ? (int) $_POST['id_product'] : 0;
    $jumlah_beli = isset($_POST['jumlah_beli']) ? (int) $_POST['jumlah_beli'] : 0;

    if ($id_product <= 0 || $jumlah_beli <= 0) {
        $message = 'Produk dan jumlah beli harus diisi dengan benar.';
    } else {
        $dataProduct = $product->readByID($id_product);
        if ($dataProduct) {
            if ($jumlah_beli > $dataProduct['stok']) {
                $message = 'Stok tidak cukup.';
            } else {
                if ($product->reduceStock($id_product, $jumlah_beli)) {
                    if ($transaction->create($id_product, $jumlah_beli)) {
                        $message = 'Transaksi berhasil disimpan.';
                    } else {
                        $message = 'Gagal menyimpan transaksi.';
                    }
                } else {
                    $message = 'Gagal memperbarui stok.';
                }
            }
        } else {
            $message = 'Produk tidak ditemukan.';
        }
    }
}

$productList = $product->read();
$transaksiList = $transaction->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
</head>
<body>
    <p>
        <a href="index.php">Dashboard</a> |
        <a href="form_product.php">Produk</a> |
        <a href="transaksi.php">Transaksi</a>
    </p>

    <h2>Transaksi Pembelian</h2>
    <?php if ($message !== ''): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="transaksi.php" method="POST">
        <label for="id_product">Pilih Produk:</label>
        <select id="id_product" name="id_product" required>
            <option value="">-- Pilih Produk --</option>
            <?php while ($row = $productList->fetch_assoc()): ?>
                <option value="<?= $row['id_product'] ?>">
                    <?= $row['nama_product'] ?> - <?= $row['katagori'] ?> (Stok: <?= $row['stok'] ?>)
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="jumlah_beli">Jumlah Beli:</label>
        <input type="number" id="jumlah_beli" name="jumlah_beli" min="1" required><br><br>

        <button type="submit">Simpan Transaksi</button>
    </form>

    <hr>
    <h2>Daftar Transaksi</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($row = $transaksiList->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_transaksi'] ?></td>
                <td><?= $row['nama_product'] ?></td>
                <td><?= $row['katagori'] ?></td>
                <td><?= $row['jumlah_beli'] ?></td>
                <td><?= $row['tanggal_transaksi'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
