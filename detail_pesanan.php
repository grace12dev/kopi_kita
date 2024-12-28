<?php
session_start();
// Pastikan user yang login adalah kasir
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit();
}

// Panggil file koneksi_db.php
include 'koneksi.php';

// Ambil ID pesanan dari URL
if (isset($_GET['id_order'])) {
    $id_order = $_GET['id_order'];

    // Ambil detail pesanan berdasarkan id_order
    $sql = "SELECT orders.id_order, users.username AS customer_name, menu.nama_menu, orders.jumlah, orders.total_harga, orders.tanggal_pesanan, orders.keterangan 
            FROM orders
            JOIN users ON orders.id_user = users.id_user
            JOIN menu ON orders.id_menu = menu.id_menu
            WHERE orders.id_order = '$id_order'";

    $result = mysqli_query($conn, $sql);

    // Jika pesanan tidak ditemukan
    if (mysqli_num_rows($result) == 0) {
        echo "Pesanan tidak ditemukan.";
        exit();
    }

    $orderDetails = mysqli_fetch_assoc($result);
} else {
    echo "ID Pesanan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
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
            max-width: 900px; 
        }

        .page-header { 
            margin-bottom: 30px; 
            text-align: center; 
        }

        .order-details { 
            background-color: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); 
            margin-bottom: 30px;
            transition: box-shadow 0.3s ease;
        }

        .order-details:hover { 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
        }

        .order-details h4 { 
            font-size: 1.5rem; 
            color: #2c3e50; 
            margin-bottom: 15px; 
        }

        .order-details p { 
            font-size: 1rem; 
            color: #7f8c8d; 
            margin-bottom: 12px; 
        }

        .order-details .total-price {
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #28a745;
        }

        .back-button { 
            background-color: #007bff; 
            color: white; 
            padding: 12px 24px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600; 
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .back-button:hover { 
            background-color: #0056b3; 
        }

        @media (max-width: 768px) {
            .order-details { 
                padding: 20px; 
            }

            .order-details h4 { 
                font-size: 1.3rem; 
            }

            .order-details p { 
                font-size: 0.95rem; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Detail Pesanan</h1>
        </div>

        <div class="order-details">
            <h4>Pesanan: <?php echo htmlspecialchars($orderDetails['nama_menu']); ?></h4>
            <p><strong>Nama Customer:</strong> <?php echo htmlspecialchars($orderDetails['customer_name']); ?></p>
            <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($orderDetails['jumlah']); ?></p>
            <p class="total-price"><strong>Total Harga:</strong> Rp <?php echo number_format($orderDetails['total_harga'], 0, ',', '.'); ?></p>
            <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d-m-Y H:i:s', strtotime($orderDetails['tanggal_pesanan'])); ?></p>
            <p><strong>Keterangan:</strong> <?php echo htmlspecialchars($orderDetails['keterangan']); ?></p>

            <a href="pesanan.php" class="back-button">Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</body>
</html>
