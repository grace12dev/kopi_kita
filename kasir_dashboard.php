<?php
session_start();
// Pastikan user yang login adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit();
}

// Panggil file koneksi_db.php
include 'koneksi.php';

// Ambil data menu dari database
$sql = "SELECT id_menu, nama_menu, deskripsi, gambar FROM menu";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling tetap seperti yang sudah kamu buat */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        body { font-family: 'Roboto', sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }

        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: -250px; width: 250px; height: 100%; background: #2c3e50; color: white; padding: 20px 10px; transition: left 0.3s; z-index: 1000; }
        .sidebar.active { left: 0; }
        .sidebar h3 { text-align: center; margin-bottom: 20px; font-weight: 500; }
        .sidebar a { display: block; color: white; padding: 10px; text-decoration: none; border-radius: 8px; margin-bottom: 10px; transition: background 0.3s; }
        .sidebar a:hover { background: #34495e; }

        /* Content */
        .content { margin-left: 0; padding: 20px; transition: margin-left 0.3s; }
        .content.sidebar-active { margin-left: 250px; }

        /* Top Bar */
        .top-bar { display: flex; justify-content: center; align-items: center; margin-bottom: 20px; }
        .top-bar h1 { font-size: 2rem; font-weight: 500; color: #2c3e50; }

        /* Button Tambah Menu */
        .add-menu-button { background-color: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500; transition: background 0.3s; }
        .add-menu-button:hover { background-color: #2980b9; }

        /* Menu Items */
        .menu-item { background: white; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; padding: 20px; margin: 15px; transition: transform 0.3s; }
        .menu-item:hover { transform: scale(1.05); }
        .menu-item img { width: 100%; height: 200px; object-fit: cover; border-radius: 15px; }
        .menu-item h4 { font-size: 1.3rem; color: #2c3e50; margin: 15px 0 10px; }
        .menu-item p { font-size: 1rem; color: #7f8c8d; margin-bottom: 15px; }
        .menu-item .actions { display: flex; justify-content: space-between; }
        .menu-item .btn { width: 48%; padding: 10px; border-radius: 8px; border: none; font-weight: 500; }
        .btn-edit { background-color: #2980b9; color: white; }
        .btn-delete { background-color: #c0392b; color: white; }

        /* Burger Menu */
        .burger-menu { position: fixed; top: 15px; left: 15px; background: #e74c3c; color: white; border: none; padding: 10px; border-radius: 50%; cursor: pointer; z-index: 1001; font-size: 20px; transition: transform 0.3s; }
        .burger-menu:hover { transform: scale(1.1); }

        /* Responsif */
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .menu-item { width: 100%; margin-bottom: 20px; }
        }
    </style>
</head>
<body>
    <!-- Burger Menu -->
    <button class="burger-menu" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h3>kopi kita</h3>
        <a href="#">MENU</a>
        <a href="pesanan.php">PESANAN</a>
        <a href="transaksi.php">TRANSAKSI</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        <div class="top-bar">
            <h1 class="text-center">Daftar Menu</h1>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <button class="add-menu-button" onclick="window.location.href='tambah_menu.php'">+ Tambah Menu Masakan</button>
        </div>

        <!-- List of Menus -->
        <div class="container">
            <div class="row justify-content-center">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-3 menu-item">
                            <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_menu']); ?>">
                            <h4><?php echo htmlspecialchars($row['nama_menu']); ?></h4>
                            <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                            <div class="actions">
                                <button class="btn btn-edit" onclick="window.location.href='edit_menu.php?id=<?php echo $row['id_menu']; ?>'">Edit</button>
                                <button class="btn btn-delete" onclick="confirmDelete(<?php echo $row['id_menu']; ?>)">Hapus</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada menu yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('active');
            content.classList.toggle('sidebar-active');
        }

        function confirmDelete(id_menu) {
            if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
                window.location.href = `hapus_menu.php?id=${id_menu}`;
            }
        }
    </script>
</body>
</html>
