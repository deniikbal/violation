<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekap Pelanggaran Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-xl font-bold text-green-600">
        Rekap Pelanggaran
      </div>
      <div class="flex space-x-4 items-center">
        <div class="space-x-4">
          <a href="#" class="text-gray-700 hover:text-green-600 transition duration-300">Beranda</a>
          <a href="#" class="text-gray-700 hover:text-green-600 transition duration-300">Tentang</a>
          <a href="#" class="text-gray-700 hover:text-green-600 transition duration-300">Kontak</a>
        </div>
        <!-- Tombol Login -->
        <a href="https://rekapin.sman1bantarujeg.sch.id/admin/login"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full transition duration-300">
          Login
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-green-600 text-white py-20">
    <div class="container mx-auto px-6 text-center">
      <h1 class="text-4xl font-bold mb-4">Rekap Pelanggaran Siswa</h1>
      <p class="text-lg mb-8">Aplikasi ini membantu sekolah dalam merekap data pelanggaran siswa secara efisien.</p>
      <a href="#" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-6 rounded-full transition duration-300">
        Mulai Sekarang
      </a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-8">Fitur Utama</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-600 mb-4">Pelaporan Cepat</h3>
          <p class="text-gray-600">Laporkan pelanggaran siswa dengan cepat dan mudah melalui aplikasi ini.</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-600 mb-4">Analisis Data</h3>
          <p class="text-gray-600">Dapatkan analisis lengkap tentang pelanggaran siswa dalam bentuk grafik dan tabel.</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-600 mb-4">Notifikasi Otomatis</h3>
          <p class="text-gray-600">Kirim notifikasi otomatis kepada orang tua atau wali murid terkait pelanggaran.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="bg-green-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-6">Siap Menggunakan Aplikasi Ini?</h2>
      <p class="text-lg mb-8">Daftarkan akun Anda sekarang dan mulai kelola pelanggaran siswa dengan lebih baik.</p>
      <a href="#" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-6 rounded-full transition duration-300">
        Daftar Sekarang
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6 text-center">
      <p>&copy; 2023 Rekap Pelanggaran Siswa. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
