<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen Pembimbing</title>
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
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            background: #6e8b75;
            color: #fff;
            border-radius: 4px;
            margin: 10px 20px;
            padding: 12px 0;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
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

        th, td {
            border: 2px solid #222;
            padding: 12px 10px;
            text-align: center;
        }

        th {
            background: #f7f7f7;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu-title">Menu</div>
            <a href="{{ route('dosen.dashboard') }}" class="{{ request()->is('dosen/dashboard') ? 'active' : '' }}">Daftar Kelompok</a>
            <a href="{{ route('dosen.tugas') }}" class="{{ request()->is('dosen/tugas') ? 'active' : '' }}">Tugas</a>
            <a href="{{ route('dosen.logbook') }}" class="{{ request()->is('dosen/logbook') ? 'active' : '' }}">Logbook Mahasiswa</a>
            <a href="{{ route('dosen.nilai') }}" class="{{ request()->is('dosen/nilai') ? 'active' : '' }}">Nilai</a>
        </div>
    <div class="main-content">
        <div class="topbar">
            <div class="welcome">Selamat Datang, {{ Auth::user()->username ?? 'Pembimbing' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelompok as $item)
                    <tr>
                        <td>{{ $item->mahasiswa1->nim ?? '-' }}</td>
                        <td>{{ $item->mahasiswa1->nama_mhs ?? '-' }}</td>
                        <td>{{ $item->mahasiswa2->nim ?? '-' }}</td>
                        <td>{{ $item->mahasiswa2->nama_mhs ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada kelompok mahasiswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
