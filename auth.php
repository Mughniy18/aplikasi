<?php
/*
 * File: auth.php
 * Deskripsi: File untuk menangani logika autentikasi (login, logout).
 */

session_start(); // Memulai sesi
require_once 'config.php'; // Memuat file konfigurasi database

// Fungsi untuk memeriksa apakah permintaan adalah POST
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Fungsi untuk mengarahkan pengguna ke halaman lain
function redirect($url) {
    header('Location: ' . $url);
    exit();
}

// --- LOGIKA LOGIN ---
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input dasar
    if (empty($username) || empty($password)) {
        // Simpan pesan error di sesi dan arahkan kembali ke halaman login
        $_SESSION['error_message'] = "Username dan password tidak boleh kosong.";
        redirect('index.php'); // Ganti dengan halaman login Anda
    }

    // Ambil data user dari database
    $sql = "SELECT id, username, password, role, name FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password (gunakan password_verify untuk password yang di-hash)
        // Contoh: if (password_verify($password, $user['password'])) {
        if ($password === $user['password']) { // GANTIKAN DENGAN password_verify() di aplikasi production
            // Login berhasil, simpan informasi user di sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_logged_in'] = true;
            
            // Arahkan ke dashboard yang sesuai
            if ($user['role'] === 'admin') {
                redirect('dashboard_admin.php'); // Ganti dengan halaman dashboard admin
            } else {
                redirect('dashboard_employee.php'); // Ganti dengan halaman dashboard karyawan
            }
        } else {
            // Password salah
            $_SESSION['error_message'] = "Username atau password salah.";
            redirect('index.php');
        }
    } else {
        // User tidak ditemukan
        $_SESSION['error_message'] = "Username atau password salah.";
        redirect('index.php');
    }

    $stmt->close();
}

// --- LOGIKA LOGOUT ---
if (isset($_GET['logout'])) {
    session_destroy(); // Hancurkan semua data sesi
    redirect('index.php'); // Arahkan ke halaman login
}

$conn->close();
?>
