<?php
/*
 * File: config.php
 * Deskripsi: File konfigurasi untuk koneksi database.
 * Ganti nilai-nilai di bawah ini dengan kredensial database Anda.
 */

// Pengaturan Database
define('DB_HOST', 'localhost'); // Host database Anda, biasanya 'localhost'
define('DB_USERNAME', 'root');   // Username database Anda
define('DB_PASSWORD', '');       // Password database Anda
define('DB_NAME', 'presensi_db'); // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    // Menghentikan eksekusi dan menampilkan pesan error jika koneksi gagal
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur charset koneksi ke utf8mb4 untuk mendukung karakter internasional
$conn->set_charset("utf8mb4");

// Opsi lain yang mungkin berguna:
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

?>
