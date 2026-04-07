<?php
include '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'pemilik') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_motor'])) {

    $pemilik_id = $_SESSION['user_id'];
    $merk = $_POST['merk'];
    $tipe_cc = $_POST['tipe_cc'];
    $no_plat = $_POST['no_plat'];

    $photo = file_get_contents($_FILES['photo']['tmp_name']);
    $dokumen_kepemilikan = file_get_contents($_FILES['dokumen_kepemilikan']['tmp_name']);

    $stmt = $pdo->prepare("
        INSERT INTO motor (pemilik_id, merk, tipe_cc, no_plat, status, photo, dokumen_kepemilikan)
        VALUES (?, ?, ?, ?, 'pending', ?, ?)
    ");

    $stmt->execute([
        $pemilik_id,
        $merk,
        $tipe_cc,
        $no_plat,
        $photo,
        $dokumen_kepemilikan
    ]);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>

        <body class="bg-black text-white p-5">


<!-- ================= TAMBAH MOTOR ================= -->
 <?php include '../assets/css/navbar-penyewa.php'; ?>
  <header class="bg-black text-white ">

        <div class="container mx-auto px-6 mt-0 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <h1 class="text-5xl md:text-1xl font-black leading-tight uppercase">
                    
                </h1>
                <br>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0 relative">
                <div class="absolute inset-0 bg-red-600 rounded-full blur-3xl opacity-20 transform scale-75"></div>
                <img src="../assets/img/vario.png" alt="Main Bike" class="relative z-10 w-full object-contain">
            </div>
        </div>
        <div class="min-h-screen bg-gray-50 dark:bg-transparent position-absolute  flex px-30 item-top  justify-left  py-40" style="position: absolute; top: 5%;">
                    <div class="bg-slate-800 p-4 rounded mb-5">
       
                       <form method="POST" enctype="multipart/form-data">
                   <input type="hidden" name="tambah_motor" value="1">
                   <h3>Merek</h3>
                   <input type="text" name="merk" placeholder="Merek" required class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"><br>
                   <h3>Nomor Plat Kendaraan</h3>
                   <input type="text" name="no_plat" placeholder="No Plat" required class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"><br>
                   <h3>Ukuran CC Motor</h3>
                     <select name="tipe_cc" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none">
                       <option value="100">100cc</option>
                 <option value="125">125cc</option>
                    <option value="150">150cc</option>
                   </select><br>
                   <h3>Foto Motor</h3>
                       <input type="file" name="photo" required class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"><br>
               <h3>Dokumen Kepemilikan</h3>
                   <input type="file" name="dokumen_kepemilikan" required class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"><br><br>
       
                        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition">Tambah Motor</button>
       </form>
       </div>
    </header>
</div>
</html>