<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Tugas Mahasiswa</title>
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

        .btn {
            padding: 6px 12px;
            background: #3de6e1;
            color: #222;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #2bcac5;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu-title">Menu</div>
        <a href="/mahasiswa/dashboard" class="{{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="/mahasiswa/logbook" class="{{ request()->is('mahasiswa/logbook') ? 'active' : '' }}">Logbook</a>
        <a href="/mahasiswa/tugas" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Tugas</a>
        <a href="#">Nilai</a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="welcome">Selamat Datang {{ Auth::user()->username }}</div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>

        <h2 style="margin-bottom: 20px;">Daftar Tugas dari Dosen</h2>

        <table>
            <thead>
                <tr>
                    <th>Judul</th>

                    <th>Deadline</th>
                    <th>File Tugas</th>
                    <th>Upload Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugasList as $tugas)
                    <tr>
                        <td>{{ $tugas->judul }}</td>

                        <td>{{ $tugas->kumpul_sblm }}</td>
                        <td>
                            <a class="btn" href="{{ asset('storage/' . $tugas->file_tugas_dosen) }}"
                                download>Download</a>
                        </td>
                        <td>
                           <form action="{{ route('mahasiswa.tugas.upload', $tugas->id_tugas) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file_tugas_mhs" style="display: none;" onchange="this.form.submit()">
    <button type="button" onclick="this.previousElementSibling.click()">Upload</button>
</form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
