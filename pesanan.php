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
    <title>Pesanan - Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 0; 
        }

        .container { 
            margin-top: 50px; 
            max-width: 1200px; 
        }

        .page-header { 
            margin-bottom: 30px; 
        }

        .back-btn { 
            background-color: #007bff; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            margin-bottom: 30px; 
            font-weight: 600; 
            transition: background-color 0.3s ease; 
        }

        .back-btn:hover { 
            background-color: #0056b3; 
        }

        .order-item { 
            background-color: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px; 
            transition: box-shadow 0.3s ease; 
        }

        .order-item:hover { 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); 
        }

        .order-item h4 { 
            font-size: 1.3rem; 
            color: #343a40; 
            margin-bottom: 10px; 
        }

        .order-item p { 
            font-size: 1rem; 
            color: #6c757d; 
            margin-bottom: 8px; 
        }

        .order-item .btn { 
            background-color: #28a745; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            border: none; 
            cursor: pointer; 
            font-weight: 600; 
            text-decoration: none; 
            transition: background-color 0.3s ease; 
        }

        .order-item .btn:hover { 
            background-color: #218838; 
        }

        .order-item .total { 
            font-size: 1.1rem; 
            color: #495057; 
            font-weight: 600; 
        }

        /* Responsif */
        @media (max-width: 768px) {
            .order-item { 
                padding: 15px; 
            }

            .order-item h4 { 
                font-size: 1.1rem; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Kembali -->
        <a href="kasir_dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="page-header text-center">
            <h1>Daftar Pesanan</h1>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="order-item">
                    <h4>Pesanan: <?php echo htmlspecialchars($row['nama_menu']); ?></h4>
                    <p><strong>Nama Customer:</strong> <?php echo htmlspecialchars($row['customer_name']); ?></p>
                    <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($row['jumlah']); ?></p>
                    <p class="total"><strong>Total Harga:</strong> Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></p>
                    <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d-m-Y H:i:s', strtotime($row['tanggal_pesanan'])); ?></p>
                    <a href="detail_pesanan.php?id_order=<?php echo $row['id_order']; ?>" class="btn">Detail</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada pesanan yang tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- CDN untuk FontAwesome (Ikon Panah Kembali) -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
