<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'penyewa') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard_penyewa.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$motor_id = $_POST['motor_id'];
$mulai = $_POST['mulai'];
$selesai = $_POST['selesai'];

// ================= VALIDASI DASAR =================
if (!$motor_id || !$mulai || !$selesai) {
    die("Data tidak lengkap");
}

if ($selesai <= $mulai) {
    die("Tanggal tidak valid");
}

try {
    // ================= START TRANSACTION =================
    $pdo->beginTransaction();

    // ================= LOCK DATA MOTOR =================
    $stmt = $pdo->prepare("SELECT * FROM motor WHERE id = ? FOR UPDATE");
    $stmt->execute([$motor_id]);
    $motor = $stmt->fetch();

    if (!$motor) {
        throw new Exception("Motor tidak ditemukan");
    }

    if ($motor['status'] !== 'tersedia') {
        throw new Exception("Motor tidak tersedia");
    }

    // ================= CEK BENTROK =================
    // kondisi bentrok:
    // booking lama mulai <= selesai baru
    // DAN booking lama selesai >= mulai baru
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM bookings
        WHERE motor_id = ?
        AND status IN ('pending', 'confirmed')
        AND (
            (mulai <= ? AND selesai >= ?)
        )
    ");
    $stmt->execute([$motor_id, $selesai, $mulai]);
    $bentrok = $stmt->fetchColumn();

    if ($bentrok > 0) {
        throw new Exception("Tanggal sudah dibooking orang lain");
    }

    // ================= HITUNG TOTAL =================
    $stmt = $pdo->prepare("SELECT tarif_harian FROM tarif_rental WHERE motor_id = ?");
    $stmt->execute([$motor_id]);
    $tarif = $stmt->fetchColumn();

    if (!$tarif) {
        throw new Exception("Tarif tidak ditemukan");
    }

    $hari = (strtotime($selesai) - strtotime($mulai)) / (60 * 60 * 24);
    $total = $hari * $tarif;

    // ================= INSERT BOOKING =================
    $stmt = $pdo->prepare("
        INSERT INTO bookings (user_id, motor_id, mulai, selesai, total_harga, status)
        VALUES (?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->execute([$user_id, $motor_id, $mulai, $selesai, $total]);

    // ================= UPDATE STATUS MOTOR =================
    $stmt = $pdo->prepare("UPDATE motor SET status = 'disewa' WHERE id = ?");
    $stmt->execute([$motor_id]);

    // ================= COMMIT =================
    $pdo->commit();

    header("Location: dashboard_penyewa.php?success=Booking berhasil");
    exit();

} catch (Exception $e) {

    // ================= ROLLBACK =================
    $pdo->rollBack();

    echo "Error: " . $e->getMessage();
}
?>