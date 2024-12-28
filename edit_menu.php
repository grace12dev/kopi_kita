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
$menu = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $query = "UPDATE menu SET nama_menu='$nama_menu', deskripsi='$deskripsi', harga='$harga' WHERE id_menu='$id_menu'";
    if (mysqli_query($conn, $query)) {
        header("Location: kasir_dashboard.php");
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
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            padding: 0;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 8px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Edit Menu</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?= $menu['nama_menu'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= $menu['deskripsi'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= $menu['harga'] ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Menu</button>
                <a href="kasir_dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
