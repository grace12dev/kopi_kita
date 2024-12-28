<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $gambar = $_FILES['gambar']['name'];
    $target_file = basename($gambar); // Simpan gambar di direktori yang sama

    // Upload file dan simpan ke database
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $query = "INSERT INTO menu (nama_menu, deskripsi, harga, gambar) VALUES ('$nama_menu', '$deskripsi', '$harga', '$target_file')";
        if (mysqli_query($conn, $query)) {
            header("Location: kasir_dashboard.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .btn-secondary {
            background-color: #f39c12;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #e67e22;
        }
        .btn {
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }
        .back-btn {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #f39c12;
            color: white;
            border-radius: 5px;
            margin-top: 15px;
        }
        .back-btn:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Tambah Menu Baru</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Menu</button>
            <a href="kasir_dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
