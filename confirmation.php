<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .confirmation-message {
            text-align: center;
            padding: 50px;
            background-color: #f4f4f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .confirmation-message h1 {
            color: #28a745;
        }
        .btn-back {
            background-color: #ff5722;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="confirmation-message">
            <h1>Order Successful!</h1>
            <p>Your order has been placed successfully. Thank you for choosing our service!</p>
            <a href="customer_menu.php" class="btn-back">Back to Homepage</a>
        </div>
    </div>
</body>
</html>
