<?php
include '../config.php';
requireLogin();

// Hanya penyewa
if ($_SESSION['role'] !== 'penyewa') {
    header('Location: ../login.php');
    exit();
}

// Ambil data motor tersedia
$stmt = $pdo->prepare("
    SELECT motor.*, tarif_rental.tarif_harian 
    FROM motor
    JOIN tarif_rental ON motor.id = tarif_rental.motor_id
    WHERE motor.status = ?
");
$stmt->execute(['tersedia']);
$motors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
body {
    background: #0F172A;
    color: #E2E8F0;
    font-family: sans-serif;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    padding: 20px;
}

.card {
    background: #1E293B;
    padding: 15px;
    border-radius: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.card:hover {
    transform: scale(1.05);
    background: #334155;
}

.card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
}
</style>
</head>

<body>

<?php include '../assets/css/navbar-penyewa.php'; ?>

<div class="container">
<?php foreach ($motors as $m): ?>
    <div class="card" onclick="showDetail(
        '<?= $m['id'] ?>',
        '<?= $m['merk'] ?>',
        '<?= $m['no_plat'] ?>',
        '<?= $m['tarif_harian'] ?>',
        '<?= base64_encode($m['photo']) ?>'
    )">

        <img src="data:image/jpeg;base64,<?= base64_encode($m['photo']) ?>">

        <h4><?= $m['merk'] ?></h4>
        <p><?= $m['no_plat'] ?></p>
        <p>Rp <?= number_format($m['tarif_harian']) ?>/hari</p>
    </div>
<?php endforeach; ?>
</div>

<!-- MODAL -->
<div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7);">
    <div style="background:#1E293B; padding:20px; margin:10% auto; width:320px; border-radius:10px;">

        <button onclick="closeModal()" style="float:right;">✖</button>

        <img id="imgMotor" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">

        <h3 id="namaMotor"></h3>
        <p id="platMotor"></p>
        <p id="tarifMotor"></p>

        <form method="POST" action="booking.php" onsubmit="return validasiTanggal()">
            <input type="hidden" name="motor_id" id="motorId">

            <label>Tanggal Mulai</label>
            <input type="date" name="mulai" id="mulai" required class="w-full text-black mb-2">

            <label>Tanggal Selesai</label>
            <input type="date" name="selesai" id="selesai" required class="w-full text-black mb-2">

            <p id="totalHarga" class="mb-2"></p>

            <button type="submit" class="bg-blue-500 px-3 py-2 rounded w-full">Sewa</button>
        </form>
    </div>
</div>

<script>
let tarif = 0;

function showDetail(id, merk, plat, t, photo) {
    tarif = parseInt(t);

    document.getElementById('modal').style.display = 'block';
    document.getElementById('motorId').value = id;
    document.getElementById('namaMotor').innerText = merk;
    document.getElementById('platMotor').innerText = plat;
    document.getElementById('tarifMotor').innerText = "Rp " + tarif + "/hari";
    document.getElementById('imgMotor').src = "data:image/jpeg;base64," + photo;

    document.getElementById('totalHarga').innerText = "";
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function validasiTanggal() {
    let mulai = new Date(document.getElementById('mulai').value);
    let selesai = new Date(document.getElementById('selesai').value);

    if (selesai <= mulai) {
        alert("Tanggal selesai harus lebih dari mulai");
        return false;
    }
    return true;
}

// Hitung total otomatis
document.getElementById('mulai').addEventListener('change', hitung);
document.getElementById('selesai').addEventListener('change', hitung);

function hitung() {
    let mulai = new Date(document.getElementById('mulai').value);
    let selesai = new Date(document.getElementById('selesai').value);

    let hari = (selesai - mulai) / (1000*60*60*24);

    if (hari > 0) {
        let total = hari * tarif;
        document.getElementById('totalHarga').innerText =
            "Total: Rp " + total.toLocaleString();
    }
}
</script>

</body>
</html>