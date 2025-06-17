<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nilai Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 220px;
            background: #4d6651;
            color: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding-top: 30px;
        }

        .sidebar .menu-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            background: #6e8b75;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin: 10px 20px;
            padding: 12px 0;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #3de6e1;
            color: #222;
        }

        .main-content {
            margin-left: 220px;
            padding: 30px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar .welcome {
            font-size: 1.2rem;
        }

        .topbar .logout-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            border: 2px solid #222;
            padding: 12px 10px;
            text-align: center;
        }

        th {
            background: #f7f7f7;
            font-size: 1.1rem;
        }

        .summary {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
        }

        .summary p {
            font-weight: bold;
            font-size: 1rem;
            margin: 8px 0;
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
        <a href="/mahasiswa/nilai" class="{{ request()->is('mahasiswa/nilai') ? 'active' : '' }}">Nilai</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="welcome">Selamat Datang {{ Auth::user()->mahasiswa->nama_mhs ?? '' }}</div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>

        <!-- Tabel Nilai -->
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
                        <td>{{ $item->tugas ->bobot ?? '-' }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Ringkasan -->
        <div class="summary">
            <p>Capaian Maksimal: {{ $capaianMaksimal ?? '-' }}</p>
            <p>Nilai Huruf: {{ $nilaiHuruf ?? '-' }}</p>
        </div>
    </div>
</body>

</html>
