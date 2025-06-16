<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .sidebar {
            width: 20%;
            height: 100vh;
            background-color: #3de6e1;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            color: #222;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #222;
            text-decoration: none;
            margin: 10px 0;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #ddd;
        }

        .main-content {
            margin-left: 20%;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 20px;
            color: #222;
        }

        .header button {
            background-color: #3de6e1;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            color: #222;
            font-weight: bold;
            cursor: pointer;
        }

        .header button:hover {
            background-color: #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3de6e1;
            color: #222;
        }

        .summary {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .summary p {
            margin: 5px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu-title">Menu</div>
        <a href="/mahasiswa/dashboard" class="{{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="/mahasiswa/logbook" class="{{ request()->is('mahasiswa/logbook') ? 'active' : '' }}">Logbook</a>
        <a href="/mahasiswa/tugas" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Tugas</a>
        <a href="/mahasiswa/nilai" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Nilai</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Selamat Datang {{ Auth::user()->mahasiswa->nama_mhs }}</h1>
            <button onclick="location.href='/logout'">Logout</button>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Nilai Anda</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugasKelompok as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tugas->judul }}</td>
                        <td>{{ $item->nilai ?? 'Belum ada Nilai' }}</td>
                        <td>{{ $item->bobot ?? '-' }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <p>Capaian Maksimal: {{ $capaianMaksimal ?? '-' }}</p>
            <p>Huruf: {{ $nilaiHuruf ?? '-' }}</p>
        </div>
    </div>
</body>
</html>
