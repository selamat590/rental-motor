<?php
include 'config.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        
        session_regenerate_id(true);
        
        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard_admin.php');
        } elseif ($user['role'] === 'penyewa'){
header('Location: public/dashboard_penyewa.php');
        } else {
            header('Location: pemilik/dashboard_pemilik.php');
        }
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<html>
    <head>
           <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
<body class="bg-red-600">
    <!-- Navbar -->

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
</header>
<!-- Form Login -->
 <!-- Login Form -->


<div class="min-h-screen bg-gray-50 dark:bg-transparent position-absolute  flex px-30 item-top  justify-left  py-40" style="position: absolute; bottom: 5%;">
  <div class="max-w-md w-full">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">

      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
          Selamat Datang Kembali
        </h2>
        <p class="text-gray-600 dark:text-gray-400">Masuk ke akun anda</p>
      </div>

      <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        <?= $error ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="" class="space-y-6">

        <div>
          <label class="block text-sm text-gray-700 dark:text-gray-300 mb-2">
            Username
          </label>
          <input
            type="text"
            name="username"
            required
            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
          >
        </div>

        <div>
          <label class="block text-sm text-gray-700 dark:text-gray-300 mb-2">
            Sandi
          </label>
          <input
            type="password"
            name="password"
            required
            class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white outline-none"
          >
        </div>

        <button
          type="submit"
          class="w-full bg-lime-600 text-white py-3 rounded-lg hover:bg-lime-700 transition"
        >
          Masuk
        </button>

      </form>
                            <div class="text-center mt-3 text-white">
                        <a href="register.php">Belum punya akun? Daftar di sini</a>
                    </div>
    </div>
  </div>
</div>



<!-- footer -->
 <footer class="py-5 px-3 bg-red-600">

  <div class="max-w-6xl mx-auto mt-5 pt-5 border-t border-white-200 dark:border-white-800 text-center text-white dark:text-white">
    <p>© 2026 Wonder Moto. All rights reserved.</p>
  </div>
</footer>
</body>
</html>
