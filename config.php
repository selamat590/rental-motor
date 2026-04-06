<?php
// config.php
session_start();

$host = 'localhost';
$dbname = 'rental_motor';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk cek login
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Fungsi untuk redirect jika belum login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Fungsi untuk redirect berdasarkan role
function redirectBasedOnRole() {
    if (isLoggedIn()) {
        header('Location: dashboard.php');
        exit();
    }
}

function redirectToDashboard() {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'pertugas') {
            header('Location: admin/dashboard_admin.php');
        } else {
            header('Location: dashboard.php');
        }
        exit();
    }
}
//
?>