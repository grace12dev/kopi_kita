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
    // Menangkap data dari form registrasi
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah terdaftar
    $sql_check = "SELECT * FROM users WHERE username = '$username'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
    } else {
        // Menyimpan data customer baru
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'customer')";
        
        if ($conn->query($sql) === TRUE) {
            echo "
                <div style='
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    height: 100vh; 
                    font-family: Arial, sans-serif; 
                    text-align: center;
                    background-color: #f0f8ff;'>
                    <div style='
                        padding: 20px; 
                        border: 1px solid #ddd; 
                        border-radius: 10px; 
                        background-color: white; 
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                        <h1 style='color: #28a745;'>Registrasi Berhasil!</h1>
                        <p style='color: #555;'>Selamat! Akun Anda berhasil dibuat.</p>
                        <a href='login.php' style='
                            display: inline-block; 
                            margin-top: 10px; 
                            padding: 10px 20px; 
                            background-color: #007bff; 
                            color: white; 
                            text-decoration: none; 
                            border-radius: 5px;'>Login Sekarang</a>
                    </div>
                </div>";
        } else {
            echo "<script>alert('Terjadi kesalahan: " . $conn->error . "'); window.history.back();</script>";
        }
    }
}

$conn->close();
?>
