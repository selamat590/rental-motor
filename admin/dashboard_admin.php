<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

//VERIFY MOTOR
if (isset($_POST['verify_motor'])) {
    $id = $_POST['motor_id'];

    $stmt = $pdo->prepare("
        UPDATE motor SET status = 'tersedia' WHERE id = ?
    ");
    $stmt->execute([$id]);
}

//CONFIRM BOOKING
if (isset($_POST['confirm_booking'])) {
    $id = $_POST['booking_id'];

    $stmt = $pdo->prepare("
        UPDATE bookings SET status = 'confirmed' WHERE id = ?
    ");
    $stmt->execute([$id]);
}

//SET TARIF
if (isset($_POST['set_tarif'])) {
    $motor_id = $_POST['motor_id'];
    $tarif = $_POST['tarif'];

    // cek apakah sudah ada
    $stmt = $pdo->prepare("SELECT id FROM tarif_rental WHERE motor_id = ?");
    $stmt->execute([$motor_id]);

    if ($stmt->fetch()) {
        // update
        $stmt = $pdo->prepare("
            UPDATE tarif_rental SET tarif_harian = ? WHERE motor_id = ?
        ");
        $stmt->execute([$tarif, $motor_id]);
    } else {
        // insert
        $stmt = $pdo->prepare("
            INSERT INTO tarif_rental (motor_id, tarif_harian)
            VALUES (?, ?)
        ");
        $stmt->execute([$motor_id, $tarif]);
    }
}
$stmt = $pdo->query("
    SELECT m.*, u.username, tr.tarif_harian
    FROM motor m
    JOIN users u ON m.pemilik_id = u.id
    LEFT JOIN tarif_rental tr ON m.id = tr.motor_id
");
$allMotors = $stmt->fetchAll();

//DATA MOTOR
$stmt = $pdo->query("
    SELECT m.*, u.username 
    FROM motor m
    JOIN users u ON m.pemilik_id = u.id
    WHERE m.status = 'pending'
");
$motors = $stmt->fetchAll();

//DATA BOOKING
$stmt = $pdo->query("
    SELECT b.*, u.username, m.no_plat
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN motor m ON b.motor_id = m.id
    WHERE b.status = 'pending'
");
$bookings = $stmt->fetchAll();

//REVENUE
$stmt = $pdo->query("
    SELECT b.*, m.pemilik_id
    FROM bookings b
    JOIN motor m ON b.motor_id = m.id
    WHERE b.status = 'confirmed'
");
$data = $stmt->fetchAll();

$total = 0;
foreach ($data as $d) {
    $total += $d['total_harga'];
}

$platform = $total * 0.3;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-black slate-900 text-white p-5">

<?php include '../assets/css/navbar-pemilik.php'; ?>
<br>

        <div class="container mx-auto px-6 mt-12 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <h1 class="text-5xl md:text-7xl font-black leading-tight uppercase">
                    Born to <br> Celebrate <br> Every Moment
                </h1>
                <br>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0 relative">
                <div class="absolute inset-0 bg-red-600 rounded-full blur-3xl opacity-20 transform scale-75"></div>
                <img src="../assets/img/vario.png" alt="Main Bike" class="relative z-10 w-full object-contain">
            </div>
        </div>
<br><br>
<!-- ================= VERIFY MOTOR ================= -->
<div class="bg-slate-800 p-4 rounded mb-5">
<h2 class="mb-3">Verifikasi Motor</h2>

<table class="w-full text-center">
<tr class="border-b border-slate-600">
    <th>Foto</th>
    <th>Pemilik</th>
    <th>No Plat</th>
    <th>Aksi</th>
</tr>

<?php foreach ($motors as $m): ?>
<tr class="border-b border-slate-700">
    <td>
        <img src="data:image/jpeg;base64,<?= base64_encode($m['photo']) ?>" width="100">
    </td>
    <td><?= $m['username'] ?></td>
    <td><?= $m['no_plat'] ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="motor_id" value="<?= $m['id'] ?>">
            <button name="verify_motor" class="bg-green-500 px-2 py-1 rounded">Approve</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>

<!-- ================= CONFIRM BOOKING ================= -->
<div class="bg-slate-800 p-4 rounded mb-5">
<h2 class="mb-3">Konfirmasi Booking</h2>

<table class="w-full text-center">
<tr class="border-b border-slate-600">
    <th>User</th>
    <th>Motor</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php foreach ($bookings as $b): ?>
<tr class="border-b border-slate-700">
    <td><?= $b['username'] ?></td>
    <td><?= $b['no_plat'] ?></td>
    <td><?= $b['mulai'] ?> - <?= $b['selesai'] ?></td>
    <td>Rp <?= number_format($b['total_harga']) ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
            <button name="confirm_booking" class="bg-blue-500 px-2 py-1 rounded">Confirm</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>

<!-- ================= REVENUE ================= -->
<div class="bg-slate-800 p-4 rounded">
<h2 class="mb-3">Laporan Pendapatan</h2>

<p>Total: Rp <?= number_format($total) ?></p>
<p>Bagian Platform (30%): Rp <?= number_format($platform) ?></p>

<table class="w-full mt-3 text-center">
<tr class="border-b border-slate-600">
    <th>Booking ID</th>
    <th>Total</th>
</tr>

<?php foreach ($data as $d): ?>
<tr class="border-b border-slate-700">
    <td><?= $d['id'] ?></td>
    <td>Rp <?= number_format($d['total_harga']) ?></td>
</tr>
<?php endforeach; ?>

</table>
</div>
<!-- ================= SET TARIF ================= -->
<div class="bg-slate-800 p-4 rounded mb-5">
<h2 class="mb-3">Setting Tarif Rental</h2>

<table class="w-full text-center">
<tr class="border-b border-slate-600">
    <th>merek</th>
    <th>No Plat</th>
    <th>Pemilik</th>
    <th>Tarif Saat Ini</th>
    <th>Set Tarif</th>
</tr>

<?php foreach ($allMotors as $m): ?>
<tr class="border-b border-slate-700">
    <td><?= $m['merk'] ?></td>
    <td><?= $m['no_plat'] ?></td>
    <td><?= $m['username'] ?></td>
    <td>
        Rp <?= $m['tarif_harian'] ? number_format($m['tarif_harian']) : 'Belum ada' ?>
    </td>
    <td>
        <form method="POST" class="flex justify-center gap-2">
            <input type="hidden" name="motor_id" value="<?= $m['id'] ?>">
            <input type="number" name="tarif" placeholder="Rp" required class="w-full px-1 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none">
            <button name="set_tarif" class="bg-yellow-500 px-2 py-1 rounded">
                Simpan
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>

</body>
</html>