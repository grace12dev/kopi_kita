<?php
session_start();
// Pastikan user yang login adalah kasir
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit();
}

// Panggil file koneksi_db.php
include 'koneksi.php';

// Ambil data pesanan dari tabel orders, menggabungkan tabel users dan menu untuk mendapatkan nama customer dan nama menu
$sql = "SELECT orders.id_order, users.username AS customer_name, menu.nama_menu, orders.jumlah, orders.total_harga, orders.tanggal_pesanan 
        FROM orders
        JOIN users ON orders.id_user = users.id_user
        JOIN menu ON orders.id_menu = menu.id_menu
        ORDER BY orders.tanggal_pesanan DESC"; // Menampilkan pesanan terbaru

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        .container { margin-top: 50px; }
        .transaction-item { background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        .transaction-item h4 { font-size: 1.3rem; color: #2c3e50; margin-bottom: 10px; }
        .transaction-item p { font-size: 1.1rem; color: #7f8c8d; margin-bottom: 10px; }
        .transaction-item .btn { background-color: #3498db; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; }
        .transaction-item .btn:hover { background-color: #2980b9; }
        .back-btn { background-color: #f39c12; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; }
        .back-btn:hover { background-color: #e67e22; }
        .print-btn { background-color: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; margin-top: 15px; text-decoration: none; display: inline-block; }
        .print-btn:hover { background-color: #27ae60; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Kembali -->
        <a href="kasir_dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1 class="text-center mb-4">Daftar Transaksi</h1>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="transaction-item">
                    <h4>Pesanan: <?php echo htmlspecialchars($row['nama_menu']); ?></h4>
                    <p><strong>Nama Customer:</strong> <?php echo htmlspecialchars($row['customer_name']); ?></p>
                    <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($row['jumlah']); ?></p>
                    <p><strong>Total Harga:</strong> <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></p>
                    <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d-m-Y H:i:s', strtotime($row['tanggal_pesanan'])); ?></p>
                    <!-- Tombol Print untuk Mencetak Transaksi -->
                    <a href="transaksi_print.php?id_order=<?php echo $row['id_order']; ?>" class="print-btn">Print</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada transaksi yang tersedia.</p>
        <?php endif; ?>

    </div>

    <!-- CDN untuk FontAwesome (Ikon Panah Kembali) -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
