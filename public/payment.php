<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'penyewa') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: history.php');
    exit();
}

$booking_id = $_POST['booking_id'];
$metode = $_POST['metode'];

if (!$booking_id || !$metode) {
    die("Data pembayaran tidak lengkap");
}

try {
    $pdo->beginTransaction();

    // ambil booking
    $stmt = $pdo->prepare("
        SELECT * FROM bookings 
        WHERE id = ? AND user_id = ?
        FOR UPDATE
    ");
    $stmt->execute([$booking_id, $_SESSION['user_id']]);
    $booking = $stmt->fetch();

    if (!$booking) {
        throw new Exception("Booking tidak ditemukan");
    }

    if ($booking['status'] !== 'pending') {
        throw new Exception("Booking sudah dibayar");
    }

    // simpan payment
    $stmt = $pdo->prepare("
        INSERT INTO payments (booking_id, metode, jumlah, status, paid_at)
        VALUES (?, ?, ?, 'paid', NOW())
    ");
    $stmt->execute([
        $booking_id,
        $metode,
        $booking['total_harga']
    ]);

    // update booking
    $stmt = $pdo->prepare("
        UPDATE bookings SET status = 'confirmed' WHERE id = ?
    ");
    $stmt->execute([$booking_id]);

    $pdo->commit();

    header("Location: history.php?success=Pembayaran berhasil");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>