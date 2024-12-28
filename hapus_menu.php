<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$id_menu = $_GET['id'];
$query = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Menu tidak ditemukan.";
    exit();
}

$menu = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hapus data dari database
    $query = "DELETE FROM menu WHERE id_menu='$id_menu'";
    if (mysqli_query($conn, $query)) {
        // Redirect ke dashboard setelah penghapusan berhasil
        header("Location: kasir_dashboard.php?status=success");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        p {
            color: #555;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-secondary {
            background-color: #bdc3c7;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #95a5a6;
        }
        .d-flex {
            display: flex;
            justify-content: space-between;
        }
        .d-flex a, .d-flex button {
            width: 48%;
        }
        .alert {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Konfirmasi Hapus Menu</h3>
        <p>Apakah Anda yakin ingin menghapus menu <strong><?= $menu['nama_menu'] ?></strong>? Penghapusan tidak bisa dibatalkan.</p>
        <form method="POST">
            <div class="d-flex">
                <button type="submit" class="btn btn-danger">Hapus Menu</button>
                <a href="kasir_dashboard.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
        <!-- Notifikasi pesan sukses -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success">
                Menu berhasil dihapus!
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
