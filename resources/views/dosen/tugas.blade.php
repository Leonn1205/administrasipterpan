<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas - Dosen Pembimbing</title>
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
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .add-task-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
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
            <div class="welcome">Selamat Datang, {{ session('user')->username ?? 'Pembimbing' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>

        <div class="button-container">
            <button class="add-task-btn" onclick="window.location.href='{{ route('dosen.tugas.create') }}'">+ Tambah Tugas</button>
        </div>

        @if(session('debug'))
            <div class="alert-success">Debugging: {{ session('debug') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Tanggal Mulai</th>
                    <th>Kumpul Sebelum</th>
                    <th>File</th>
                    <th>Bobot (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugas as $tugasItem)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugasItem->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($tugasItem->mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($tugasItem->kumpul_sblm)->format('d M Y') }}</td>
                        <td>
                            @if($tugasItem->file_tugas_dosen)
                                <a href="{{ route('dosen.tugas.download', $tugasItem->id_tugas) }}" target="_blank">
                                    {{ basename($tugasItem->file_tugas_dosen) }}
                                </a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>{{ $tugasItem->bobot }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada tugas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
