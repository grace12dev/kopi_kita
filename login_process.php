<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "restoran_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data dari form login
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mengambil data berdasarkan username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debugging untuk menampilkan hash password dari database
        echo "Debugging: <br>";
        echo "Input Password: " . $password . "<br>";
        echo "Hash Password di Database: " . $user['password'] . "<br>";

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Mengarahkan ke halaman sesuai role
            if ($user['role'] == 'kasir') {
                header("Location: kasir_dashboard.php");
                exit();
            } elseif ($user['role'] == 'customer') {
                header("Location: customer_menu.php");
                exit();
            } else {
                echo "<script>alert('Role tidak dikenal!'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}

$conn->close();
?>
