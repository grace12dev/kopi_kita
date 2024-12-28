<?php
session_start();

// Pastikan user yang login adalah customer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

// Daftar menu yang tersedia diambil dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);

// Cek jika ada pencarian yang dilakukan
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = strtolower(trim($_GET['search']));
    // Filter menu berdasarkan pencarian
    $query = "SELECT * FROM menu WHERE LOWER(nama_menu) LIKE '%$searchQuery%' OR LOWER(deskripsi) LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .hero-section {
            background: linear-gradient(135deg, #FFE53B, #FF2525);
            color: white;
            padding: 50px 20px;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .hero-section .search-bar {
            max-width: 500px;
            margin: 0 auto;
        }
        .hero-section input {
            border-radius: 50px;
            padding: 12px 20px;
            border: none;
            width: 100%;
            max-width: 75%;
        }
        .hero-section .btn-search {
            border-radius: 50px;
            padding: 12px 20px;
            background-color: white;
            color: #FF2525;
            font-weight: bold;
            border: none;
            cursor: pointer;
            width: 100%;
            max-width: 100px;
            margin-top: 10px;
        }
        .menu-container {
            padding: 40px 15px;
        }
        .menu-item {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .menu-item:hover {
            transform: scale(1.05);
        }
        .menu-item img {
            width: 100%;
            height: 200px; /* Ukuran tinggi konsisten */
            object-fit: cover; /* Memastikan gambar mengisi area dengan baik */
            border-radius: 15px;
        }
        .menu-item h4 {
            font-size: 1.3rem;
            color: #FF2525;
            margin: 15px 0 10px;
        }
        .menu-item p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
        }
        .btn-order {
            background-color: #FF2525;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-order:hover {
            background-color: #e60000;
        }
        .footer {
            text-align: center;
            margin: 40px 0 20px;
            font-size: 1rem;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .col-md-3 {
            flex: 0 0 23%;
            max-width: 23%;
            padding: 0 15px;
            margin-bottom: 30px;
        }
        @media (max-width: 992px) {
            .col-md-3 {
                flex: 0 0 48%;
                max-width: 48%;
            }
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1rem;
            }
        }
        @media (max-width: 768px) {
            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .hero-section h1 {
                font-size: 1.8rem;
            }
            .hero-section p {
                font-size: 0.9rem;
            }
        }
        /* Tombol logout */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            border-radius: 50px;
            background-color:rgb(255, 205, 77);
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button> <!-- Tombol logout -->

    <div class="hero-section">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Selamat datang di cafe kopi kita!</p>
        <div class="search-bar">
            <form action="" method="get">
                <input type="text" name="search" placeholder="Enter Your Food Name..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button class="btn-search" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="container menu-container">
        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-3">
                        <div class="menu-item">
                            <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama_menu']; ?>">
                            <h4><?php echo $item['nama_menu']; ?></h4>
                            <p><?php echo $item['deskripsi']; ?></p>
                            <a href="order.php?item=<?php echo strtolower($item['nama_menu']); ?>" class="btn-order">Order Now</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No menu found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
