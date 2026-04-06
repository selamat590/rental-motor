<?php
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>

<div
  class="relative min-h-screen bg-cover bg-center bg-no-repeat"
  style="background-image: url('kai-bg.jpg');"
>

  <header class="absolute inset-x-0 top-0 z-50">
    <?php include './assets/css/navbar-admin.php'; ?>
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

  <div class="relative isolate px-6 pt-14 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
      <div class="hidden sm:mb-8 sm:flex sm:justify-center">
        <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-400 ring-1 ring-white/10 hover:ring-white/20">
          Announcing our next round of funding. <a href="#" class="font-semibold text-indigo-400"><span aria-hidden="true" class="absolute inset-0"></span>Read more <span aria-hidden="true">&rarr;</span></a>
        </div>
      </div>
      <div class="lg:flex lg:gap-x-7" class="text-align: center;">
        
        <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl " style="color: #2d2a70; text-shadow: 0 6px 10px rgba(0, 0, 0, 0.83);">Kereta</h1>
        <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl " style=" color: #ed6b23; text-shadow: 0 6px 10px rgba(0, 0, 0, 0.83);">Api</h1>
        <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl " style=" color: #2d2a70; text-shadow: 0 6px 10px rgba(0, 0, 0, 0.83);">Indonesia</h1>
      </div>
      <div>
        <p class="mt-5 text-md font-medium text-pretty text-white md:text-xl/10 " style="text-align: center; text-shadow: 0 6px 10px rgba(0, 0, 0, 0.83);">"Anda Adalah Prioritas Kami"</p>

      </div>
      <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="#" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Jadwal Kereta</a>
          <a href="#" class="text-sm/6 font-semibold text-white">Learn more <span aria-hidden="true">→</span></a>
      </div>
    </div>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>

<!-- footer -->
 <footer class="py-12 px-6 " style="background: #2d2a70;">
  <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8">
    <div>
      <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Product</h3>
      <ul class="space-y-2 text-gray-600 dark:text-gray-400">
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Features</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Pricing</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Changelog</a></li>
      </ul>
    </div>
    <div>
      <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Company</h3>
      <ul class="space-y-2 text-gray-600 dark:text-gray-400">
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">About</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Blog</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Careers</a></li>
      </ul>
    </div>
    <div>
      <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Resources</h3>
      <ul class="space-y-2 text-gray-600 dark:text-gray-400">
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Documentation</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Help Center</a></li>
        <li><a href="#" class="hover:text-gray-900 dark:hover:text-white transition-colors">Guides</a></li>
      </ul>
    </div>
    <div>
      <h3 class="text-gray-900 dark:text-white font-semibold mb-4">contact</h3>
      <ul class="space-y-2 text-gray-600 dark:text-gray-400">
        <li><button class="group w-12 hover:w-54 h-12 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 relative rounded text-white duration-700 font-bold flex justify-start gap-2 items-center p-2 pr-6 before:absolute before:-z-10 before:left-8 before:hover:left-40 before:w-6 before:h-6 before:bg-pink-600 before:hover:bg-pink-600 before:rotate-45 before:duration-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 shrink-0 fill-white">
                      <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/>
                </svg>
                  <span class="origin-left inline-flex duration-100 group-hover:duration-300 group-hover:delay-500 opacity-0 group-hover:opacity-100 border-l-2 px-1 transform scale-x-0 group-hover:scale-x-100 transition-all">@Kaysan_nawfal_a</span>
            </button>
        </li>
        <li><button class="group w-12 hover:w-44 h-12 bg-gradient-to-r from-blue-600 to-blue-700 relative rounded text-white duration-700 font-bold flex justify-start gap-2 items-center p-2 pr-6 before:absolute before:-z-10 before:left-8 before:hover:left-40 before:w-6 before:h-6 before:bg-blue-500 before:hover:bg-blue-400 before:rotate-45 before:duration-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 shrink-0 fill-white">
                 <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                    <span class="origin-left inline-flex duration-100 group-hover:duration-300 group-hover:delay-500 opacity-0 group-hover:opacity-100 border-l-2 px-1 transform scale-x-0 group-hover:scale-x-100 transition-all">Facebook</span>
            </button>
        </li>
      </ul>
    </div>
  </div>
  <div class="max-w-6xl mx-auto mt-12 pt-8 border-t border-gray-200 dark:border-gray-800 text-center text-gray-600 dark:text-gray-400">
    <p>© 2024 Your Company. All rights reserved.</p>
  </div>
</footer>
</body>
</html>


</body>
</html>