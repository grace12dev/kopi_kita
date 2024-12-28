<?php
session_start();
require 'koneksi.php';

// Pastikan user yang login adalah customer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Ambil nama menu yang dipesan
if (isset($_GET['item'])) {
    $menuName = $_GET['item'];
    $query = "SELECT * FROM menu WHERE LOWER(nama_menu) = '$menuName'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "Menu not found.";
        exit();
    }
    $menuItem = mysqli_fetch_assoc($result);
} else {
    echo "No item selected.";
    exit();
}

// Proses pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah = $_POST['jumlah'];  // Mengambil jumlah pesanan
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']); // Keterangan order
    $username = $_SESSION['username'];

    // Dapatkan ID user
    $userQuery = "SELECT id_user FROM users WHERE username = '$username'";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);
    $id_user = $user['id_user'];

    // Dapatkan ID menu
    $menuId = $menuItem['id_menu'];  // Asumsi ada kolom id pada tabel menu

    // Hitung total harga
    $totalHarga = $jumlah * $menuItem['harga'];  // Mengalikan jumlah dengan harga menu

    // Masukkan data pesanan ke tabel orders
    $query = "INSERT INTO orders (id_user, id_menu, jumlah, total_harga, keterangan, tanggal_pesanan) 
              VALUES ('$id_user', '$menuId', '$jumlah', '$totalHarga', '$keterangan', CURRENT_TIMESTAMP)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: confirmation.php"); // Arahkan ke halaman konfirmasi atau menu setelah berhasil
        exit();
    } else {
        echo "Failed to place order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
        }

        .order-detail {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-detail h1 {
            text-align: center;
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .order-detail .img-fluid {
            border-radius: 8px;
        }

        .order-detail .form-label {
            font-size: 1.1rem;
            color: #34495e;
        }

        .order-detail input, .order-detail textarea, .order-detail button {
            font-size: 1rem;
        }

        .order-detail button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
        }

        .order-detail button:hover {
            background-color: #2980b9;
        }

        .back-btn {
            background-color: #95a5a6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background-color: #7f8c8d;
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <button class="back-btn" onclick="history.back()">Kembali</button>
        <div class="order-detail">
            <h1>Order Details: <?php echo $menuItem['nama_menu']; ?></h1>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <img src="<?php echo $menuItem['gambar']; ?>" alt="<?php echo $menuItem['nama_menu']; ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h4>Description</h4>
                    <p><?php echo $menuItem['deskripsi']; ?></p>
                    <h4>Price: <?php echo number_format($menuItem['harga'], 0, ',', '.'); ?></h4>
                    
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Quantity</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Order Notes</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="4"></textarea>
                        </div>
                        <button type="submit">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
