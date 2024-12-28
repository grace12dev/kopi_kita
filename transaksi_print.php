<?php
// Ambil data transaksi dari database
include 'koneksi.php';

$id_order = $_GET['id_order']; // Ambil ID order dari URL
$sql = "SELECT orders.id_order, users.username AS customer_name, menu.nama_menu, orders.jumlah, orders.total_harga, orders.keterangan, orders.tanggal_pesanan 
        FROM orders
        JOIN users ON orders.id_user = users.id_user
        JOIN menu ON orders.id_menu = menu.id_menu
        WHERE orders.id_order = '$id_order'";

$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { margin-top: 50px; width: 80%; }
        .order-detail { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .order-detail h1 { text-align: center; }
        .order-detail p { font-size: 1.2rem; }
        .order-detail .btn-print, .btn-back { background-color: #3498db; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; }
        .order-detail .btn-print:hover, .btn-back:hover { background-color: #2980b9; }
        @media print {
            body { background-color: white; }
            .btn-print { display: none; }
            .btn-back { display: none; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="order-detail">
            <h1>Detail Transaksi</h1>
            <p><strong>Order ID:</strong> <?php echo $order['id_order']; ?></p>
            <p><strong>Nama Customer:</strong> <?php echo $order['customer_name']; ?></p>
            <p><strong>Menu:</strong> <?php echo $order['nama_menu']; ?></p>
            <p><strong>Jumlah:</strong> <?php echo $order['jumlah']; ?></p>
            <p><strong>Total Harga:</strong> <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
            <p><strong>Keterangan:</strong> <?php echo $order['keterangan']; ?></p>
            <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d-m-Y H:i:s', strtotime($order['tanggal_pesanan'])); ?></p>
            
            <!-- Tombol Print -->
            <button class="btn-print" onclick="window.print()">Print</button>

            <!-- Tombol Kembali -->
            <a href="transaksi.php" class="btn-back">Kembali</a>
        </div>
    </div>

</body>
</html>
