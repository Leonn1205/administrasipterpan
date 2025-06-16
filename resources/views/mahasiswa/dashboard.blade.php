<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
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

        .sidebar a,
        .sidebar button {
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
        .sidebar a:hover,
        .sidebar button:hover {
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

        .buat-kelompok-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            float: right;
            margin-bottom: 20px;
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

        /* Modal CSS tanpa nested */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            align-items: center;
            justify-content: center;
            overflow: auto;
        }

        .modal-content {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            min-width: 350px;
            max-width: 500px;
            width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .modal-content label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal-content button {
            width: 100%;
            margin-top: 15px;
            padding: 10px 0;
            background: #3de6e1;
            border: none;
            border-radius: 20px;
            color: #222;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-content .close-btn {
            background: #eee;
            color: #222;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu-title">Menu</div>
        <a href="/mahasiswa/dashboard" class="{{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="/mahasiswa/logbook" class="{{ request()->is('mahasiswa/logbook') ? 'active' : '' }}">Logbook</a>
        <a href="/mahasiswa/tugas" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Tugas</a>
        <a href="/mahasiswa/nilai" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Nilai</a>
    </div>
    <div class="main-content">
        <div class="topbar">
            <div class="welcome">Selamat Datang {{ Auth::user()->username }}</div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>
        @if (!$sudahPunyaKelompok)
            <button class="buat-kelompok-btn" onclick="showModal()">Buat Kelompok</button>
        @endif
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Dosen Pembimbing</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelompokCollection as $item)
                    <tr>
                        <td>{{ $item->mahasiswa1->nim ?? '-' }}</td>
                        <td>{{ $item->mahasiswa1->nama_mhs ?? '-' }}</td>
                        <td>{{ $item->mahasiswa2->nim ?? '-' }}</td>
                        <td>{{ $item->mahasiswa2->nama_mhs ?? '-' }}</td>
                        <td>{{ $item->dosen->nama_dosen ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada anggota kelompok.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="modal" id="modalKelompok">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal()">Tutup</button>
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert-danger">{{ session('error') }}</div>
            @endif
            <form method="POST" action="/mahasiswa/kelompok">
                @csrf
                <label for="nim1">NIM Mahasiswa 1</label>
                <input type="text" id="nim1" name="nim1" required>

                <label for="nama1">Nama Mahasiswa 1</label>
                <input type="text" id="nama1" name="nama1" readonly required>

                <hr>
                <label for="nim2">NIM Mahasiswa 2</label>
                <input type="text" id="nim2" name="nim2" required>

                <label for="nama2">Nama Mahasiswa 2</label>
                <input type="text" id="nama2" name="nama2" readonly required>

                <button type="submit">SUBMIT</button>
            </form>
        </div>
    </div>
    <script>
        function showModal() {
            document.getElementById('modalKelompok').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalKelompok').style.display = 'none';
        }
        @if ($errors->any() || session('error'))
            window.onload = function() {
                showModal();
            }
        @endif

        document.getElementById('nim1').addEventListener('blur', function() {
            const nim = this.value.trim();
            if (nim !== '') {
                fetch(`/api/mahasiswa/${nim}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.nama) {
                            document.getElementById('nama1').value = data.nama;
                        } else {
                            document.getElementById('nama1').value = '';
                            alert('Mahasiswa dengan NIM tersebut tidak ditemukan.');
                        }
                    });
            }
        });
        document.getElementById('nim2').addEventListener('blur', function() {
            const nim = this.value.trim();
            if (nim !== '') {
                fetch(`/api/mahasiswa/${nim}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.nama) {
                            document.getElementById('nama2').value = data.nama;
                        } else {
                            document.getElementById('nama2').value = '';
                            alert('Mahasiswa dengan NIM tersebut tidak ditemukan.');
                        }
                    });
            }
        });
    </script>
</body>

</html>
