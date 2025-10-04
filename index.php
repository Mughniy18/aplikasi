<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-item.active {
            background-color: #1d4ed8;
            color: white;
        }
        .sidebar-item.active i, .sidebar-item.active span {
            color: white;
        }
        .sidebar-item {
            transition: all 0.2s ease-in-out;
            border-radius: 0.5rem;
        }
        .sidebar-item:hover {
            background-color: #2563eb;
            color: white;
        }
        .sidebar-item:hover i, .sidebar-item:hover span {
            color: white;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .calendar-day {
            min-height: 100px;
        }
        .calendar-day.admin-view:hover {
            background-color: #eff6ff;
            cursor: pointer;
        }
         /* Custom Modal Styling */
        .modal {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- LOGIN PAGE -->
    <div id="login-page" class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Aplikasi Absensi</h2>
            <form id="login-form">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="admin">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="password">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline w-full">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN APP -->
    <div id="main-app" class="hidden">
        <div class="flex h-screen bg-gray-100">
            <!-- SIDEBAR -->
            <aside id="sidebar" class="w-64 bg-white shadow-md flex-shrink-0 flex flex-col">
                <div class="p-6 flex items-center space-x-3">
                    <i class="fas fa-fingerprint text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-blue-600">Absensi</h1>
                </div>
                <nav id="main-nav" class="flex-grow p-4 space-y-2">
                    <!-- Menu items will be generated here -->
                </nav>
                <div class="p-4">
                    <a href="#" id="logout-btn" class="sidebar-item flex items-center space-x-3 text-gray-600 p-3">
                        <i class="fas fa-sign-out-alt w-6 text-center text-xl"></i>
                        <span class="font-semibold">Logout</span>
                    </a>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="flex-1 overflow-y-auto no-scrollbar">
                <header class="bg-white p-4 shadow-sm flex justify-end items-center sticky top-0 z-10">
                    <div class="flex items-center space-x-3">
                        <span id="user-name" class="font-semibold text-gray-700"></span>
                        <i class="fas fa-user-circle text-3xl text-gray-500"></i>
                    </div>
                </header>
                <div class="p-6 space-y-6">
                    <div id="page-content">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- MODALS CONTAINER -->
    <div id="modal-container">
        <!-- Add/Edit Employee Modal -->
        <div id="employee-modal" class="hidden modal fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-md transform scale-95">
                <h3 class="text-xl font-bold mb-4" id="employee-modal-title"></h3>
                <form id="employee-form" class="space-y-4">
                    <input type="hidden" id="employee-id">
                    <div><label class="block font-semibold">Nama Lengkap</label><input type="text" id="employee-name" class="w-full border rounded-lg p-2 mt-1" required></div>
                    <div><label class="block font-semibold">Jabatan</label><select id="employee-position" class="w-full border rounded-lg p-2 mt-1" required></select></div>
                    <div><label class="block font-semibold">Email</label><input type="email" id="employee-email" class="w-full border rounded-lg p-2 mt-1" required></div>
                    <div><label class="block font-semibold">Username</label><input type="text" id="employee-username" class="w-full border rounded-lg p-2 mt-1" required></div>
                    <div class="flex justify-end space-x-4"><button type="button" id="btn-cancel-employee" class="bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</button><button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Simpan</button></div>
                </form>
            </div>
        </div>
        <!-- Camera Modal -->
        <div id="camera-modal" class="hidden modal fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-2xl text-center transform scale-95">
                <h3 class="text-xl font-bold mb-4" id="camera-title">Ambil Foto Presensi</h3>
                <div class="relative">
                    <video id="camera-feed" class="w-full h-auto rounded-md bg-gray-200" autoplay></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>
                </div>
                <p id="location-info" class="mt-4 text-gray-600 font-semibold">Mendeteksi lokasi...</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button id="capture-btn" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 disabled:bg-gray-400" disabled>Ambil Foto</button>
                    <button id="cancel-capture-btn" class="bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-400">Batal</button>
                </div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="hidden modal fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-sm text-center transform scale-95">
                <h3 class="text-xl font-bold mb-4" id="confirm-title">Konfirmasi</h3>
                <p id="confirm-message" class="mb-6"></p>
                <div class="flex justify-center space-x-4">
                    <button id="confirm-cancel-btn" class="bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg">Batal</button>
                    <button id="confirm-ok-btn" class="bg-red-600 text-white font-bold py-2 px-6 rounded-lg">Hapus</button>
                </div>
            </div>
        </div>
        <!-- Event Modal -->
        <div id="event-modal" class="hidden modal fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-md transform scale-95">
                <h3 class="text-xl font-bold mb-4" id="event-modal-title">Tambah Agenda/Libur</h3>
                <form id="event-form" class="space-y-4">
                    <input type="hidden" id="event-date">
                    <div><label class="block font-semibold">Judul</label><input type="text" id="event-title" class="w-full border rounded-lg p-2 mt-1" required></div>
                    <div><label class="block font-semibold">Jenis</label><select id="event-type" class="w-full border rounded-lg p-2 mt-1" required><option value="event">Agenda Kantor</option><option value="holiday">Libur Nasional</option></select></div>
                    <div class="flex justify-end space-x-4"><button type="button" id="btn-cancel-event" class="bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</button><button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- DOM Elements ---
        const loginPage = document.getElementById('login-page');
        const mainApp = document.getElementById('main-app');
        const loginForm = document.getElementById('login-form');
        const mainNav = document.getElementById('main-nav');
        const pageContent = document.getElementById('page-content');
        const userNameDisplay = document.getElementById('user-name');
        const logoutBtn = document.getElementById('logout-btn');
        
        // --- App State ---
        let currentUser = null;
        let mockData = {};
        let cameraStream = null;
        let currentLocation = null;
        let isLocationValid = false;
        let currentCalendarDate = new Date();

        // --- Mock Data Initialization ---
        function initializeMockData() {
            return {
                users: [
                    { id: 1, name: 'Admin User', position_id: 1, email: 'admin@example.com', username: 'admin', role: 'admin' },
                    { id: 2, name: 'Ahmad Fauzi', position_id: 3, email: 'ahmad.fauzi@example.com', username: 'ahmad', role: 'employee' },
                    { id: 3, name: 'Budi Santoso', position_id: 1, email: 'budi.s@example.com', username: 'budi', role: 'employee' },
                    { id: 4, name: 'Siti Aminah', position_id: 2, email: 'siti.a@example.com', username: 'siti', role: 'employee' },
                ],
                positions: [ { id: 1, name: 'Manager' }, { id: 2, name: 'Staff Administrasi' }, { id: 3, name: 'Developer' }, { id: 4, name: 'Analis' } ],
                locations: [{ id: 1, name: 'Kantor Pusat', latitude: -6.1754, longitude: 106.8272, radius: 200 }], // Monas, radius 200m
                leaveRequests: [
                    { id: 1, employee_id: 4, type: 'Sakit', startDate: '2025-10-05', endDate: '2025-10-05', reason: 'Demam dan flu', status: 'Pending' },
                    { id: 2, employee_id: 2, type: 'Izin', startDate: '2025-09-15', endDate: '2025-09-16', reason: 'Acara keluarga mendadak', status: 'Approved' },
                    { id: 3, employee_id: 3, type: 'Sakit', startDate: '2025-10-01', endDate: '2025-10-01', reason: 'Sakit gigi', status: 'Rejected' },
                ],
                attendance: {
                    '2025-10-03': [ { employee_id: 2, name: 'Ahmad Fauzi', check_in: '07:55', check_out: '17:02', status: 'Hadir' }, { employee_id: 3, name: 'Budi Santoso', check_in: '08:05', check_out: '17:00', status: 'Terlambat' } ],
                    '2025-10-02': [ { employee_id: 2, name: 'Ahmad Fauzi', check_in: '07:58', check_out: '17:05', status: 'Hadir' }, { employee_id: 3, name: 'Budi Santoso', check_in: '07:59', check_out: '17:01', status: 'Hadir' }, { employee_id: 4, name: 'Siti Aminah', status: 'Sakit' } ]
                },
                events: [
                    { date: '2025-10-10', title: 'Rapat Bulanan', type: 'event' },
                    { date: '2025-10-25', title: 'Cuti Bersama', type: 'holiday' }
                ]
            };
        }

        // --- Page Templates ---
        const pageTemplates = {
            dashboardAdmin: () => {
                const pendingRequests = mockData.leaveRequests.filter(r => r.status === 'Pending').length;
                const today = new Date().toISOString().slice(0,10);
                const attendanceToday = mockData.attendance[today]?.length || 0;
                 return `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4"><div class="bg-blue-100 p-3 rounded-full"><i class="fas fa-users text-2xl text-blue-600"></i></div><div><p class="text-gray-500">Total Karyawan</p><p class="text-2xl font-bold">${mockData.users.filter(u=>u.role==='employee').length}</p></div></div>
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4"><div class="bg-green-100 p-3 rounded-full"><i class="fas fa-check-circle text-2xl text-green-600"></i></div><div><p class="text-gray-500">Absen Hari Ini</p><p class="text-2xl font-bold">${attendanceToday}</p></div></div>
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4"><div class="bg-yellow-100 p-3 rounded-full"><i class="fas fa-file-alt text-2xl text-yellow-600"></i></div><div><p class="text-gray-500">Pengajuan Izin</p><p class="text-2xl font-bold">${pendingRequests}</p></div></div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md mt-6"><h3 class="text-xl font-bold mb-4">Aktivitas Terbaru</h3><div class="text-gray-500">Belum ada aktivitas.</div></div>`
            },
            dashboardEmployee: () => {
                const myAttendance = Object.values(mockData.attendance).flat().filter(a => a.employee_id === currentUser.id);
                const hadir = myAttendance.filter(a => a.status === 'Hadir' || a.status === 'Terlambat').length;
                const izin = mockData.leaveRequests.filter(l => l.employee_id === currentUser.id && l.status === 'Approved').length;
                 return `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4"><div class="bg-green-100 p-3 rounded-full"><i class="fas fa-check-circle text-2xl text-green-600"></i></div><div><p class="text-gray-500">Total Kehadiran</p><p class="text-2xl font-bold">${hadir} Hari</p></div></div>
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4"><div class="bg-yellow-100 p-3 rounded-full"><i class="fas fa-file-alt text-2xl text-yellow-600"></i></div><div><p class="text-gray-500">Total Izin Disetujui</p><p class="text-2xl font-bold">${izin} Hari</p></div></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="bg-white p-6 rounded-lg shadow-md"><h3 class="text-xl font-bold mb-4">Riwayat Absensi Terbaru</h3>${generateMyRecentAttendance()}</div>
                        <div class="bg-white p-6 rounded-lg shadow-md"><h3 class="text-xl font-bold mb-4">Agenda & Hari Libur</h3>${generateUpcomingEvents()}</div>
                    </div>`
            },
            dataKaryawan: () => `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4"><h3 class="text-xl font-bold">Manajemen Data Karyawan</h3><button onclick="app.openEmployeeModal()" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 flex items-center"><i class="fas fa-plus mr-2"></i>Tambah Karyawan</button></div>
                    <div class="overflow-x-auto" id="employee-table-container">${generateEmployeeTable()}</div>
                </div>`,
            masterData: () => `
                 <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4">Master Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="font-semibold mb-3 text-lg">Daftar Jabatan</h4>
                            <ul class="space-y-2 mb-4" id="positions-list">${generatePositionsList()}</ul>
                            <div class="flex"><input type="text" id="new-position-input" placeholder="Nama Jabatan Baru" class="border rounded-l-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"><button onclick="app.addPosition()" class="bg-blue-600 text-white px-4 rounded-r-lg hover:bg-blue-700">Tambah</button></div>
                        </div>
                        <div><h4 class="font-semibold mb-3 text-lg">Daftar Lokasi Absensi</h4><div id="locations-list">${generateLocationsList()}</div></div>
                    </div>
                </div>`,
            pengajuanIzin: () => `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4">Manajemen Pengajuan Izin</h3>
                    <div class="overflow-x-auto" id="leave-request-table-container">${generateLeaveRequestTable()}</div>
                </div>`,
            absen: () => `
                <div class="bg-white p-6 rounded-lg shadow-md text-center max-w-lg mx-auto">
                    <h3 class="text-2xl font-bold mb-2">Presensi Kehadiran</h3>
                    <p class="text-gray-600 mb-6">Waktu saat ini di lokasi Anda.</p>
                    <div id="clock" class="text-5xl font-bold mb-2 text-gray-800"></div>
                    <div id="date" class="text-lg text-gray-500 mb-8"></div>
                    <div class="flex justify-center space-x-4"><button id="check-in-btn" class="bg-green-500 text-white font-bold py-3 px-8 rounded-lg text-lg hover:bg-green-600 transition-transform transform hover:scale-105"><i class="fas fa-sign-in-alt mr-2"></i> Check In</button><button id="check-out-btn" class="bg-red-500 text-white font-bold py-3 px-8 rounded-lg text-lg hover:bg-red-600 transition-transform transform hover:scale-105"><i class="fas fa-sign-out-alt mr-2"></i> Check Out</button></div>
                </div>`,
            izinSakit: () => `
                 <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
                    <h3 class="text-xl font-bold mb-4">Pengajuan Izin / Sakit</h3>
                    <form id="leave-request-form" class="space-y-4">
                        <div><label class="block font-semibold">Jenis Pengajuan</label><select id="leave-type" class="w-full border rounded-lg p-2 mt-1" required><option value="">Pilih Jenis</option><option value="Izin">Izin</option><option value="Sakit">Sakit</option></select></div>
                        <div><label class="block font-semibold">Tanggal Mulai</label><input type="date" id="leave-start-date" class="w-full border rounded-lg p-2 mt-1" required></div>
                        <div><label class="block font-semibold">Tanggal Selesai</label><input type="date" id="leave-end-date" class="w-full border rounded-lg p-2 mt-1" required></div>
                        <div><label class="block font-semibold">Alasan</label><textarea id="leave-reason" rows="4" placeholder="Jelaskan alasan Anda" class="w-full border rounded-lg p-2 mt-1" required></textarea></div>
                        <div><label class="block font-semibold">Lampiran (Opsional)</label><input type="file" class="w-full border rounded-lg p-1 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"></div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700">Kirim Pengajuan</button>
                    </form>
                    <h3 class="text-xl font-bold mt-8 mb-4">Riwayat Pengajuan Anda</h3>
                    <div id="leave-history">${generateMyLeaveHistory()}</div>
                </div>`,
            kalender: () => `<div class="bg-white p-6 rounded-lg shadow-md"><h3 class="text-xl font-bold mb-4">Kalender</h3><div id="calendar-container">${generateCalendar(currentCalendarDate.getFullYear(), currentCalendarDate.getMonth())}</div></div>`,
            rekapAbsen: () => `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4">Rekap Presensi Harian</h3>
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-end">
                        <div><label class="block font-semibold text-sm mb-1">Filter Karyawan</label><select class="w-full border rounded-lg p-2"><option value="">Semua Karyawan</option>${mockData.users.filter(u=>u.role==='employee').map(e => `<option value="${e.id}">${e.name}</option>`).join('')}</select></div>
                        <div><label class="block font-semibold text-sm mb-1">Pilih Tanggal</label><input type="date" value="${new Date().toISOString().slice(0,10)}" class="w-full border rounded-lg p-2"></div>
                        <div class="flex items-center space-x-2 pt-6"><button class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 w-full"><i class="fas fa-filter mr-2"></i>Terapkan</button><button class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700"><i class="fas fa-file-csv mr-2"></i></button></div>
                    </div>
                    <div class="overflow-x-auto mt-6"><table class="w-full text-left"><thead><tr class="bg-gray-100"><th class="p-3">NAMA</th><th class="p-3">JAM MASUK</th><th class="p-3">JAM PULANG</th><th class="p-3">STATUS</th></tr></thead>
                    <tbody>${generateAttendanceRecap()}</tbody></table></div>
                </div>`
        };
        
        // --- Navigation Items ---
        const navItems = {
            admin: [ { id: 'dashboardAdmin', icon: 'fa-tachometer-alt', label: 'Dashboard' }, { id: 'dataKaryawan', icon: 'fa-users', label: 'Data Karyawan' }, { id: 'masterData', icon: 'fa-database', label: 'Master Data' }, { id: 'pengajuanIzin', icon: 'fa-file-alt', label: 'Pengajuan Izin' }, { id: 'kalender', icon: 'fa-calendar-alt', label: 'Kalender' }, { id: 'rekapAbsen', icon: 'fa-history', label: 'Rekap Absen' } ],
            employee: [ { id: 'dashboardEmployee', icon: 'fa-tachometer-alt', label: 'Dashboard' }, { id: 'absen', icon: 'fa-camera', label: 'Absensi' }, { id: 'izinSakit', icon: 'fa-file-alt', label: 'Izin / Sakit' }, { id: 'kalender', icon: 'fa-calendar-alt', label: 'Kalender' } ]
        };
        
        // --- GPS & Distance Calculation ---
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // metres
            const φ1 = lat1 * Math.PI/180;
            const φ2 = lat2 * Math.PI/180;
            const Δφ = (lat2-lat1) * Math.PI/180;
            const Δλ = (lon2-lon1) * Math.PI/180;

            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ/2) * Math.sin(Δλ/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

            return R * c; // in metres
        }

        // --- Core Functions ---
        function login(username, password) {
            mockData = initializeMockData();
            const user = mockData.users.find(u => u.username === username);
            if (!user) { alert('Username atau password salah!'); return; }
            
            currentUser = user;
            loginPage.classList.add('hidden');
            mainApp.classList.remove('hidden');
            userNameDisplay.textContent = currentUser.name;
            renderNav(currentUser.role);
            setupNavListeners();
            navigateTo(currentUser.role === 'admin' ? 'dashboardAdmin' : 'dashboardEmployee');
        }

        function logout() {
            currentUser = null;
            loginPage.classList.remove('hidden');
            mainApp.classList.add('hidden');
            stopCamera();
        }

        function renderNav(role) { mainNav.innerHTML = navItems[role].map(item => `<a href="#" data-page="${item.id}" class="sidebar-item flex items-center space-x-3 text-gray-600 p-3"><i class="fas ${item.icon} w-6 text-center text-xl"></i><span class="font-semibold">${item.label}</span></a>`).join(''); }
        
        function navigateTo(pageId) { 
            if (pageTemplates[pageId]) { 
                pageContent.innerHTML = pageTemplates[pageId](); 
                document.querySelectorAll('.sidebar-item').forEach(item => { item.classList.toggle('active', item.dataset.page === pageId); }); 
                addPageEventListeners(pageId); 
            } 
        }
        
        function setupNavListeners() { mainNav.addEventListener('click', e => { e.preventDefault(); const link = e.target.closest('a.sidebar-item'); if (link && link.dataset.page) navigateTo(link.dataset.page); }); }

        // --- UI Generation Functions ---
        function generateUpcomingEvents() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const upcoming = mockData.events.filter(e => new Date(e.date) >= today).slice(0, 5);
            if (upcoming.length === 0) return '<div class="text-gray-500 text-center py-4">Tidak ada agenda mendatang.</div>';
            return `<div class="space-y-2">${upcoming.map(event => `
                <div class="border-b py-2 flex justify-between">
                    <span>${event.date}</span>
                    <span class="font-semibold">${event.title}</span>
                </div>`).join('')}</div>`;
        }
        
        function generateCalendar(year, month) {
             const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
             const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
             const firstDay = new Date(year, month).getDay();
             const daysInMonth = 32 - new Date(year, month, 32).getDate();
             const today = new Date();
             let tbl = `<div class="flex justify-between items-center mb-4"><button onclick="app.changeMonth(-1)" class="px-3 py-1 rounded hover:bg-gray-200">&lt;</button><h4 class="text-lg font-semibold">${monthNames[month]} ${year}</h4><button onclick="app.changeMonth(1)" class="px-3 py-1 rounded hover:bg-gray-200">&gt;</button></div><div class="grid grid-cols-7 gap-1 text-center">`;
             dayNames.forEach(day => tbl += `<div class="font-bold p-2 text-sm">${day}</div>`);
             for (let i = 0; i < firstDay; i++) { tbl += `<div></div>`; }
             for (let i = 1; i <= daysInMonth; i++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const attendanceRecord = currentUser.role === 'employee' ? Object.entries(mockData.attendance).find(([date, records]) => date === dateStr)?.[1].find(r => r.employee_id === currentUser.id) : null;
                const eventRecord = mockData.events.find(e => e.date === dateStr);
                const isToday = today.getDate() == i && today.getMonth() == month && today.getFullYear() == year;
                
                let statusClass = 'bg-gray-50'; let statusText = ''; let eventText = '';
                if(currentUser.role === 'admin') statusClass += ' admin-view';

                if (attendanceRecord) {
                    if (attendanceRecord.status === 'Hadir') { statusClass = 'bg-green-100 text-green-800'; statusText = 'Hadir'; }
                    else if (attendanceRecord.status === 'Terlambat') { statusClass = 'bg-yellow-100 text-yellow-800'; statusText = 'Terlambat'; }
                    else if (attendanceRecord.status === 'Sakit') { statusClass = 'bg-red-100 text-red-800'; statusText = 'Sakit'; }
                }
                if (eventRecord) {
                    if(eventRecord.type === 'holiday') {
                        statusClass = 'bg-red-100 text-red-800';
                        eventText = `<div class="text-xs mt-1 font-bold truncate">${eventRecord.title}</div>`;
                    } else {
                        eventText = `<div class="text-xs mt-1 font-semibold text-blue-600 truncate">${eventRecord.title}</div>`;
                    }
                }

                 tbl += `<div onclick="app.handleDayClick('${dateStr}')" class="border rounded-lg p-2 calendar-day ${statusClass} ${isToday ? 'border-2 border-blue-500' : ''}">
                            <div class="font-bold ${isToday ? 'text-blue-600' : ''}">${i}</div>
                            <div class="text-xs mt-1 font-semibold">${statusText}</div>
                            ${eventText}
                         </div>`;
             }
             tbl += `</div>`;
             return tbl;
        }

        function generateEmployeeTable() { const employees = mockData.users.filter(u => u.role === 'employee'); if(employees.length === 0) return '<p class="text-center text-gray-500 py-4">Tidak ada data karyawan.</p>'; return `<table class="w-full text-left"><thead><tr class="bg-gray-100"><th class="p-3">NAMA</th><th class="p-3">JABATAN</th><th class="p-3">EMAIL</th><th class="p-3">AKSI</th></tr></thead><tbody> ${employees.map(emp => { const position = mockData.positions.find(p => p.id === emp.position_id)?.name || 'N/A'; return `<tr class="border-b hover:bg-gray-50"><td class="p-3">${emp.name}</td><td class="p-3">${position}</td><td class="p-3">${emp.email}</td> <td class="p-3 space-x-3"><button onclick="app.openEmployeeModal(${emp.id})" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button><button onclick="app.deleteEmployee(${emp.id})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></td></tr>`; }).join('')} </tbody></table>`; }
        
        function generatePositionsList() { return mockData.positions.map(pos => `<li class="flex justify-between items-center p-2 border rounded-lg"><span>${pos.name}</span><button onclick="app.deletePosition(${pos.id})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></li>`).join(''); }
        
        function generateLocationsList() { return mockData.locations.map(loc => `<div class="p-3 border rounded-lg mb-2"><strong>${loc.name}</strong><br><small>${loc.latitude}, ${loc.longitude} (Radius: ${loc.radius}m)</small></div>`).join(''); }
        
        function generateAttendanceRecap() { const today = new Date().toISOString().slice(0,10); const attendanceToday = mockData.attendance[today] || []; if(attendanceToday.length === 0) return '<tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada data absensi untuk hari ini.</td></tr>'; return attendanceToday.map(att => `<tr class="border-b"><td class="p-3">${att.name}</td><td class="p-3">${att.check_in || '-'}</td><td class="p-3">${att.check_out || '-'}</td><td class="p-3"><span class="px-2 py-1 text-xs rounded-full ${att.status === 'Hadir' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">${att.status}</span></td></tr>`).join(''); }
        
        function generateMyRecentAttendance() { const myAttendance = Object.entries(mockData.attendance).map(([date, records]) => records.filter(r => r.employee_id === currentUser.id).map(r => ({ ...r, date }))).flat().slice(0, 5); if (myAttendance.length === 0) return '<div class="text-gray-500 text-center py-4">Belum ada riwayat absensi.</div>'; return `<div class="space-y-2">${myAttendance.map(att => `<div class="border-b py-2 flex justify-between"><span>${att.date}</span><span>${att.status} (${att.check_in || ''})</span></div>`).join('')}</div>`; }
        
        function generateMyLeaveHistory() { const myRequests = mockData.leaveRequests.filter(l => l.employee_id === currentUser.id); if (myRequests.length === 0) return '<div class="text-gray-500 text-center py-4">Belum ada riwayat pengajuan.</div>'; const statusColor = { Pending: 'yellow', Approved: 'green', Rejected: 'red' }; return `<div class="space-y-2">${myRequests.map(req => ` <div class="border-b py-2 flex justify-between items-center"> <div><strong>${req.type}</strong>: ${req.startDate} s/d ${req.endDate}</div> <span class="px-2 py-1 text-xs rounded-full bg-${statusColor[req.status]}-100 text-${statusColor[req.status]}-800">${req.status}</span> </div>`).join('')}</div>`; }
        
        function generateLeaveRequestTable() { if (mockData.leaveRequests.length === 0) return '<p class="text-center text-gray-500 py-4">Tidak ada pengajuan izin.</p>'; return `<table class="w-full text-left"><thead><tr class="bg-gray-100"><th class="p-3">NAMA</th><th class="p-3">JENIS</th><th class="p-3">TANGGAL</th><th class="p-3">STATUS</th><th class="p-3">AKSI</th></tr></thead><tbody> ${mockData.leaveRequests.map(req => { const user = mockData.users.find(u => u.id === req.employee_id); const statusColor = { Pending: 'yellow', Approved: 'green', Rejected: 'red' }; return `<tr class="border-b hover:bg-gray-50"><td class="p-3">${user.name}</td><td class="p-3">${req.type}</td><td class="p-3">${req.startDate}</td> <td class="p-3"><span class="px-2 py-1 text-xs rounded-full bg-${statusColor[req.status]}-100 text-${statusColor[req.status]}-800">${req.status}</span></td> <td class="p-3 space-x-2">${req.status === 'Pending' ? `<button onclick="app.approveRequest(${req.id})" class="text-green-600 hover:text-green-800"><i class="fas fa-check"></i></button><button onclick="app.rejectRequest(${req.id})" class="text-red-600 hover:text-red-800"><i class="fas fa-times"></i></button>` : '-'}</td></tr>`; }).join('')} </tbody></table>`; }

        // --- Camera & GPS ---
        async function openCamera(type) {
            document.getElementById('camera-title').textContent = `Ambil Foto untuk ${type === 'check-in' ? 'Check In' : 'Check Out'}`;
            showModal('camera-modal');
            const locationInfo = document.getElementById('location-info');
            const captureBtn = document.getElementById('capture-btn');
            isLocationValid = false;
            captureBtn.disabled = true;

            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
                document.getElementById('camera-feed').srcObject = cameraStream;

                navigator.geolocation.getCurrentPosition(pos => {
                    const { latitude, longitude } = pos.coords;
                    currentLocation = { latitude, longitude };
                    const office = mockData.locations[0];
                    const distance = getDistance(latitude, longitude, office.latitude, office.longitude);
                    
                    if (distance <= office.radius) {
                        locationInfo.textContent = `Anda berada dalam jangkauan (${Math.round(distance)}m dari kantor).`;
                        locationInfo.classList.remove('text-red-500');
                        locationInfo.classList.add('text-green-600');
                        isLocationValid = true;
                        captureBtn.disabled = false;
                    } else {
                        locationInfo.textContent = `Anda di luar jangkauan (${Math.round(distance)}m dari kantor).`;
                        locationInfo.classList.remove('text-green-600');
                        locationInfo.classList.add('text-red-500');
                        isLocationValid = false;
                        captureBtn.disabled = true;
                    }
                }, () => {
                    locationInfo.textContent = 'Gagal mendapatkan lokasi. Pastikan GPS dan izin lokasi aktif.';
                    locationInfo.classList.add('text-red-500');
                }, { enableHighAccuracy: true });
            } catch (err) {
                alert('Tidak bisa mengakses kamera. Pastikan Anda memberikan izin.');
                hideModal('camera-modal');
            }
        }
        
        function stopCamera() { 
            if (cameraStream) { 
                cameraStream.getTracks().forEach(track => track.stop()); 
                cameraStream = null; 
            } 
            hideModal('camera-modal'); 
        }

        // --- Modal & Confirmation ---
        function showModal(modalId) { 
            const modal = document.getElementById(modalId); 
            modal.classList.remove('hidden'); 
            setTimeout(() => modal.querySelector('.modal-content').classList.replace('scale-95', 'scale-100'), 10); 
        }
        
        function hideModal(modalId) { 
            const modal = document.getElementById(modalId); 
            modal.querySelector('.modal-content').classList.replace('scale-100', 'scale-95'); 
            setTimeout(() => modal.classList.add('hidden'), 300); 
        }
        
        function confirmAction(title, message, onConfirm) { 
            document.getElementById('confirm-title').textContent = title; 
            document.getElementById('confirm-message').textContent = message; 
            showModal('confirm-modal'); 
            const okBtn = document.getElementById('confirm-ok-btn'); 
            const newOkBtn = okBtn.cloneNode(true); 
            okBtn.parentNode.replaceChild(newOkBtn, okBtn); 
            newOkBtn.addEventListener('click', () => { onConfirm(); hideModal('confirm-modal'); }); 
        }

        // --- CRUD Handlers ---
        const app = {
            openEmployeeModal(id = null) {
                const form = document.getElementById('employee-form');
                form.reset();
                document.getElementById('employee-position').innerHTML = mockData.positions.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
                if (id) {
                    const emp = mockData.users.find(e => e.id === id);
                    document.getElementById('employee-modal-title').textContent = 'Edit Data Karyawan';
                    document.getElementById('employee-id').value = emp.id;
                    document.getElementById('employee-name').value = emp.name;
                    document.getElementById('employee-position').value = emp.position_id;
                    document.getElementById('employee-email').value = emp.email;
                    document.getElementById('employee-username').value = emp.username;
                } else {
                    document.getElementById('employee-modal-title').textContent = 'Tambah Karyawan Baru';
                    document.getElementById('employee-id').value = '';
                }
                showModal('employee-modal');
            },
            handleEmployeeSubmit(e) {
                e.preventDefault();
                const id = document.getElementById('employee-id').value ? parseInt(document.getElementById('employee-id').value) : null;
                const employeeData = {
                    name: document.getElementById('employee-name').value,
                    position_id: parseInt(document.getElementById('employee-position').value),
                    email: document.getElementById('employee-email').value,
                    username: document.getElementById('employee-username').value,
                    role: 'employee'
                };
                if (id) {
                    const index = mockData.users.findIndex(u => u.id === id);
                    mockData.users[index] = { ...mockData.users[index], ...employeeData };
                } else {
                    employeeData.id = Math.max(...mockData.users.map(u => u.id)) + 1;
                    mockData.users.push(employeeData);
                }
                hideModal('employee-modal');
                navigateTo('dataKaryawan');
            },
            deleteEmployee(id) {
                const emp = mockData.users.find(e => e.id === id);
                confirmAction('Hapus Karyawan', `Apakah Anda yakin ingin menghapus ${emp.name}?`, () => {
                    mockData.users = mockData.users.filter(e => e.id !== id);
                    navigateTo('dataKaryawan');
                });
            },
            addPosition() {
                const input = document.getElementById('new-position-input');
                if (input.value.trim()){
                    const newPosition = { id: Math.max(...mockData.positions.map(p => p.id)) + 1, name: input.value.trim() };
                    mockData.positions.push(newPosition);
                    input.value = '';
                    navigateTo('masterData');
                }
            },
            deletePosition(id) {
                const pos = mockData.positions.find(p => p.id === id);
                confirmAction('Hapus Jabatan', `Apakah Anda yakin ingin menghapus jabatan ${pos.name}?`, () => {
                    mockData.positions = mockData.positions.filter(p => p.id !== id);
                    navigateTo('masterData');
                });
            },
            handleLeaveSubmit(e) {
                e.preventDefault();
                const newRequest = {
                    id: Math.max(...mockData.leaveRequests.map(r => r.id)) + 1,
                    employee_id: currentUser.id,
                    type: document.getElementById('leave-type').value,
                    startDate: document.getElementById('leave-start-date').value,
                    endDate: document.getElementById('leave-end-date').value,
                    reason: document.getElementById('leave-reason').value,
                    status: 'Pending'
                };
                mockData.leaveRequests.push(newRequest);
                alert('Pengajuan berhasil dikirim!');
                navigateTo('izinSakit');
            },
            approveRequest(id) {
                const request = mockData.leaveRequests.find(r => r.id === id);
                const user = mockData.users.find(u => u.id === request.employee_id);
                confirmAction('Setujui Izin', `Setujui pengajuan dari ${user.name}?`, () => {
                    request.status = 'Approved';
                    navigateTo('pengajuanIzin');
                });
            },
            rejectRequest(id) {
                const request = mockData.leaveRequests.find(r => r.id === id);
                const user = mockData.users.find(u => u.id === request.employee_id);
                 confirmAction('Tolak Izin', `Tolak pengajuan dari ${user.name}?`, () => {
                    request.status = 'Rejected';
                    navigateTo('pengajuanIzin');
                });
            },
            handleDayClick(dateStr) {
                if (currentUser.role !== 'admin') return;
                const existingEvent = mockData.events.find(e => e.date === dateStr);
                document.getElementById('event-form').reset();
                document.getElementById('event-date').value = dateStr;
                if(existingEvent){
                    document.getElementById('event-title').value = existingEvent.title;
                    document.getElementById('event-type').value = existingEvent.type;
                }
                showModal('event-modal');
            },
            handleEventSubmit(e) {
                e.preventDefault();
                const date = document.getElementById('event-date').value;
                const title = document.getElementById('event-title').value;
                const type = document.getElementById('event-type').value;

                const existingEventIndex = mockData.events.findIndex(e => e.date === date);
                if (existingEventIndex > -1) {
                    mockData.events[existingEventIndex] = { date, title, type };
                } else {
                    mockData.events.push({ date, title, type });
                }
                hideModal('event-modal');
                navigateTo('kalender');
            },
            changeMonth(offset) {
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() + offset);
                navigateTo('kalender');
            }
        };
        window.app = app;

        // --- Event Listeners ---
        function addPageEventListeners(pageId) {
            if (pageId === 'absen') {
                document.getElementById('check-in-btn').addEventListener('click', () => openCamera('check-in'));
                document.getElementById('check-out-btn').addEventListener('click', () => openCamera('check-out'));
                updateClock(); 
                const clockInterval = setInterval(updateClock, 1000);
            }
             if (pageId === 'izinSakit') {
                document.getElementById('leave-request-form').addEventListener('submit', app.handleLeaveSubmit);
            }
        }
        function updateClock() { 
            const clockEl = document.getElementById('clock'), dateEl = document.getElementById('date'); 
            if(!clockEl) return; 
            const now = new Date(); 
            clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }); 
            dateEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }); 
        }
        
        // --- Initial Setup ---
        loginForm.addEventListener('submit', e => { e.preventDefault(); login(document.getElementById('username').value, document.getElementById('password').value); });
        logoutBtn.addEventListener('click', e => { e.preventDefault(); logout(); });
        document.getElementById('employee-form').addEventListener('submit', app.handleEmployeeSubmit);
        document.getElementById('btn-cancel-employee').addEventListener('click', () => hideModal('employee-modal'));
        document.getElementById('confirm-cancel-btn').addEventListener('click', () => hideModal('confirm-modal'));
        document.getElementById('cancel-capture-btn').addEventListener('click', stopCamera);
        document.getElementById('capture-btn').addEventListener('click', () => {
            if (isLocationValid) {
                alert('Absen berhasil direkam!');
                stopCamera();
            } else {
                alert('Absen gagal: Anda berada di luar jangkauan lokasi yang diizinkan.');
            }
        });
        document.getElementById('event-form').addEventListener('submit', app.handleEventSubmit);
        document.getElementById('btn-cancel-event').addEventListener('click', () => hideModal('event-modal'));
        
    });
    </script>
</body>

</html>

