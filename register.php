<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #FFE53B, #FF2525); /* Gradien Kuning ke Merah */
            height: 100vh;
            color: white;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: white;
            color: black;
            padding: 30px;
        }
        .card h3 {
            color: #FF2525;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 50px;
        }
        .btn-primary {
            background-color: #FF2525;
            color: white;
            border: none;
            border-radius: 50px;
        }
        .btn-primary:hover {
            background-color: #e60000;
        }
        a {
            color: #FF2525;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .card {
                width: 100%; /* Full width pada perangkat kecil */
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Registrasi</h3>
            <form action="register_process.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrasi</button>
            </form>
            <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
