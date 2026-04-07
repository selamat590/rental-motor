<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'pemilik') {
    header('Location: ../login.php');
    exit();
}

// ================= TAMBAH MOTOR =================

// ================= DATA MOTOR =================
$stmt = $pdo->prepare("SELECT * FROM motor WHERE pemilik_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$motors = $stmt->fetchAll();

// ================= HAPUS MOTOR =================
if (isset($_POST['hapus_motor'])) {
    $motor_id = $_POST['motor_id'];

    // cek apakah motor punya booking aktif
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM bookings
        WHERE motor_id = ?
        AND status IN ('pending','confirmed')
    ");
    $stmt->execute([$motor_id]);
    $aktif = $stmt->fetchColumn();

    if ($aktif > 0) {
        echo "<script>alert('Motor tidak bisa dihapus karena sedang / pernah dibooking!')</script>";
    } else {
        $stmt = $pdo->prepare("
            DELETE FROM motor 
            WHERE id = ? AND pemilik_id = ?
        ");
        $stmt->execute([$motor_id, $_SESSION['user_id']]);
    }
}

// ================= DATA REVENUE =================
$stmt = $pdo->prepare("
    SELECT b.*, m.no_plat
    FROM bookings b
    JOIN motor m ON b.motor_id = m.id
    WHERE m.pemilik_id = ?
    AND b.status = 'confirmed'
");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

$total = 0;
foreach ($bookings as $b) {
    $total += $b['total_harga'];
}

$owner = $total * 0.7;
$platform = $total * 0.3;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-black text-white p-5">

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
<br>
<!-- ================= LIST MOTOR ================= -->
<div class="bg-slate-800 p-4 rounded mb-5">
<h2 class="mb-3">Motor Saya</h2>

<table class="w-full text-center">
<tr class="border-b border-slate-600">
    <th>Foto</th>
    <th>No Plat</th>
    <th>CC</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php foreach ($motors as $m): ?>
<tr class="border-b border-slate-700">
    <td><img src="data:image/jpeg;base64,<?= base64_encode($m['photo']) ?>" width="100"></td>
    <td><?= $m['no_plat'] ?></td>
    <td><?= $m['tipe_cc'] ?>cc</td>
    <td><?= $m['status'] ?></td>
    <td>
        <form method="POST" onsubmit="return confirm('Yakin mau hapus motor ini?')">
            <input type="hidden" name="motor_id" value="<?= $m['id'] ?>">
            <button name="hapus_motor" class="bg-red-500 px-2 py-1 rounded">
                Hapus
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>

<!-- ================= REVENUE ================= -->
<div class="bg-slate-800 p-4 rounded">
<h2 class="mb-3">Pendapatan</h2>

<p>Total: Rp <?= number_format($total) ?></p>
<p>Bagian Anda (70%): Rp <?= number_format($owner) ?></p>
<p>Bagian Sistem (30%): Rp <?= number_format($platform) ?></p>

<table class="w-full mt-3 text-center">
<tr class="border-b border-slate-600">
    <th>No Plat</th>
    <th>Tanggal</th>
    <th>Total</th>
</tr>

<?php foreach ($bookings as $b): ?>
<tr class="border-b border-slate-700">
    <td><?= $b['no_plat'] ?></td>
    <td><?= $b['mulai'] ?> - <?= $b['selesai'] ?></td>
    <td>Rp <?= number_format($b['total_harga']) ?></td>
</tr>
<?php endforeach; ?>

</table>
</div>

</body>
</html>