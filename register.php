<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $no_tlpn = $_POST['no_tlpn'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Validasi
    if ($password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username atau sudah digunakan!";
        } else {
            // Hash password dan simpan user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    "INSERT INTO users (username, email, no_tlpn, password, role) VALUES (?, ?, ?, ?, ?)"
);

if ($stmt->execute([$username, $email, $no_tlpn, $hashed_password, $role])) {
    $success = "Registrasi berhasil! Akun pelanggan siap dipakai.";
} else {
    $error = "Terjadi kesalahan saat registrasi.";
}

        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Minimarket</title>
    <style>

    </style>
</head>
<body>
        <head>
           <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
<body>
    <!-- Navbar -->

<div

>

 <header class="bg-black text-white ">

        <div class="container mx-auto px-6 mt-0 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <h1 class="text-5xl md:text-1xl font-black leading-tight uppercase">
                    
                </h1>
                <br>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0 relative">
                <div class="absolute inset-0 bg-red-600 rounded-full blur-3xl opacity-20 transform scale-75"></div>
                <img src="./assets/img/vario.png" alt="Main Bike" class="relative z-10 w-full object-contain">
            </div>
        </div>

  <!-- register form -->
<div class="min-h-screen bg-black dark:bg-transparent position-absolute  flex px-30 item-top  justify-left  py-3" style="position: absolute; top: 0.9%;">
  <div class="max-w-md w-full">
    <div class="bg-black dark:bg-gray-800 rounded-2xl shadow-lg p-8">

      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
          Selamat Datang Kembali
        </h2>
        <p class="text-gray-600 dark:text-gray-400">Masuk ke akun anda</p>
      </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div >
                            <label for="username" class="block text-l  text-white mb-2">username</label>
                            <input type="text" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
                             id="username" name="username" required>
                        </div>
                        <div >
                            <label for="no_tlpn" class="block text-l text-white mb-2">nomor telepon</label>
                            <input type="text" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
                             id="no_tlpn" name="no_tlpn" required>
                        </div>

                        <div >
                            <label for="email" class="block text-l text-white mb-2">email</label>
                            <input type="email" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
                             id="email" name="email" required>
                        </div>

                        <div >
                            <label for="password" class="block text-l text-white mb-2">Password</label>
                            <input type="password" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
                             id="password" name="password" required>
                        </div>
                        <div class="mb-3" >
                            <label for="confirm_password" class="block text-l text-white mb-2">Konfirmasi Password</label>
                            <input type="password" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
                             id="confirm_password" name="confirm_password" required
                             >
                        </div>
                        <div class="mb-3">

                          <label for="role" class="text-white">Pilih Role:</label>
                            <select name="role" id="role" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none">
                               <option value="penyewa">Penyewa</option>
                                <option value="pemilik">Pemilik</option>
                            </select>
                        <button type="submit" class="w-full bg-lime-600 text-white py-3 rounded-lg hover:bg-lime-700 transition">Daftar</button>
                        </div>
                    </form>
                    <div class="text-center mt-3 text-white">
                        <a href="login.php">Sudah punya akun? Login di sini</a>
                    </div>
                
            </div>
        </div>
    </div>

                     <footer class="py-5 px-3 bg-red-600">

  <div class="max-w-6xl mx-auto mt-5 pt-30 border-t border-white-200 dark:border-white-800 text-center text-white dark:text-white">
    <p>© 2026 Wonder Moto. All rights reserved.</p>
  </div>
</footer>
</body>
</html>
