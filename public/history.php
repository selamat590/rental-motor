<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'penyewa') {
    header('Location: ../login.php');
    exit();
}

$stmt = $pdo->prepare("
    SELECT b.*, m.merk, m.no_plat,
           p.status AS payment_status
    FROM bookings b
    JOIN motor m ON b.motor_id = m.id
    LEFT JOIN payments p ON b.id = p.booking_id
    WHERE b.user_id = ?
    ORDER BY b.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$data = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-900 text-white p-5">

<?php include '../assets/css/navbar-penyewa.php'; ?>

<table class="w-full bg-slate-800 rounded">
<tr>
    <th>Motor</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Pembayaran</th>
    <th>Aksi</th>
</tr>

<?php foreach ($data as $d): ?>
<tr class="border-t border-slate-700 text-center">
    <td><?= $d['merk'] ?> (<?= $d['no_plat'] ?>)</td>
    <td><?= $d['mulai'] ?> - <?= $d['selesai'] ?></td>
    <td>Rp <?= number_format($d['total_harga']) ?></td>
    <td><?= $d['status'] ?></td>
    <td><?= $d['payment_status'] ?? 'belum' ?></td>
    <td>
        <?php if ($d['status'] === 'pending'): ?>
        <form method="POST" action="payment.php">
            <input type="hidden" name="booking_id" value="<?= $d['id'] ?>">
            <select name="metode" class="text-black">
                <option>Transfer</option>
                <option>Cash</option>
                <option>E-Wallet</option>
            </select>
            <button class="bg-green-500 px-2 py-1 rounded">Bayar</button>
        </form>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>