<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $no_tlpn = $_POST['no_tlpn'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
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

if ($stmt->execute([$username, $email, $no_tlpn, $hashed_password, 'pelanggan'])) {
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
  class="relative min-h-screen bg-cover bg-center bg-no-repeat"
  style="background-image: url('kai-bg.jpg');"
>

  <header class="absolute inset-x-0 top-0 z-50">
    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
            <div class="flex items-center justify-between">
              <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="kai.png" alt="" class="w-auto" />
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-200">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-white/10">
                <div class="space-y-2 py-6">
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-black hover:bg-white/5 active:text-orange-400">Product</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-black hover:bg-white/5">Features</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-black hover:bg-white/5">Marketplace</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-black hover:bg-white/5">Company</a>
                </div>
                <div class="py-6">
                  <a href="login.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                </div>
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>
  </header>

  <!-- register form -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center px-4 py-12">
  <div class="max-w-md w-full">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">

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
                    </div>
                    </div>
</body>
</html>