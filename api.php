<?php
/*
 * File: api.php
 * Deskripsi: File untuk menangani permintaan API dari sisi klien (JavaScript).
 * Ini akan mengembalikan data dalam format JSON.
 */

header('Content-Type: application/json'); // Set header untuk respons JSON
require_once 'config.php'; // Memuat file konfigurasi database
session_start(); // Memulai sesi untuk memeriksa status login

// Contoh struktur dasar untuk menangani berbagai aksi (action)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Periksa apakah user sudah login (kecuali untuk aksi tertentu seperti login)
/*
if (!isset($_SESSION['is_logged_in']) && $action !== 'login') {
    echo json_encode(['status' => 'error', 'message' => 'Akses ditolak. Silakan login terlebih dahulu.']);
    exit();
}
*/

switch ($action) {
    case 'get_dashboard_summary':
        // TODO: Buat query untuk mengambil data summary dashboard (total karyawan, absen hari ini, dll.)
        // Contoh: SELECT COUNT(*) FROM users;
        // Kembalikan data dalam format JSON
        $data = [
            'total_karyawan' => 15,
            'absen_hari_ini' => 10,
            'izin_sakit_hari_ini' => 1,
            'pengajuan_izin' => 2
        ];
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;

    case 'get_employees':
        // TODO: Buat query untuk mengambil daftar semua karyawan dari tabel `users`
        // Contoh: SELECT u.id, u.name, p.name as position, u.email, u.username FROM users u JOIN positions p ON u.position_id = p.id;
        echo json_encode(['status' => 'success', 'data' => []]);
        break;

    case 'add_employee':
        // TODO: Ambil data dari $_POST, lakukan validasi, dan masukkan ke tabel `users`
        // Jangan lupa untuk hash password sebelum disimpan: password_hash($password, PASSWORD_DEFAULT)
        echo json_encode(['status' => 'success', 'message' => 'Karyawan berhasil ditambahkan.']);
        break;
        
    case 'check_in':
        // TODO: Ambil data dari $_POST (employee_id, photo_data, location)
        // Lakukan validasi lokasi (bandingkan dengan data di tabel `locations`)
        // Simpan data check-in ke tabel `attendance_records`
        echo json_encode(['status' => 'success', 'message' => 'Check-in berhasil.']);
        break;

    // Tambahkan case lain untuk semua fungsionalitas:
    // - check_out
    // - get_attendance_history
    // - submit_leave_request
    // - get_master_data (jabatan, lokasi)
    // - dll.

    default:
        // Aksi tidak valid
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
        break;
}

$conn->close();
?>
