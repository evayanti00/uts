<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Produk</title>
</head>
<body>
    <p>
        <a href="index.php">Dashboard</a> |
        <a href="form_product.php">Produk</a> |
        <a href="transaksi.php">Transaksi</a>
    </p>

    <h2>Input Produk</h2>
    <form action="prosses_product.php" method="POST">
        <label for="nama_product">Nama Produk:</label>
        <input type="text" id="nama_product" name="nama_product" required><br>

        <label for="katagori">Kategori:</label>
        <input type="text" id="katagori" name="katagori" required><br>

        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" min="0" step="0.1" required><br>

        <label for="stok">Stok:</label>
        <input type="number" id="stok" name="stok" min="0" required><br><br>

        <input type="submit" value="Simpan">
    </form>

    <hr>
    <h2>Data Produk</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>
        <?php
        require_once 'classes/product.php';
        $product = new Product();
        $data = $product->read();
        while ($row = $data->fetch_assoc()) {
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
</body>
</html>