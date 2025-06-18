<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logbook Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .sidebar {
            width: 220px;
            background: #4d6651;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
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
            border: none;
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
            margin-left: 240px;
            padding: 40px;
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

        h2 {
            margin-bottom: 20px;
        }

        .tambah-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .tambah-btn:hover {
            background: #2bcac5;
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

        .action-btn {
            padding: 6px 12px;
            background: #3de6e1;
            color: #222;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            margin: 2px;
            cursor: pointer;
        }

        .action-btn:hover {
            background: #2bcac5;
        }

        /* Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-content label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            font-weight: 600;
        }

        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .modal-content button {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 20px;
            padding: 10px;
            font-weight: bold;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .modal-content .close-btn {
            background: #ccc;
            color: #222;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu-title">Menu</div>
        <a href="/mahasiswa/dashboard" class="{{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="/mahasiswa/logbook" class="{{ request()->is('mahasiswa/logbook') ? 'active' : '' }}">Logbook</a>
        <a href="/mahasiswa/tugas" class="{{ request()->is('mahasiswa/tugas') ? 'active' : '' }}">Tugas</a>
        <a href="/mahasiswa/nilai" class="{{ request()->is('mahasiswa/nilai') ? 'active' : '' }}">Nilai</a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="welcome">Selamat Datang {{ Auth::user()->username ?? '' }}</div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>

        @if (session('success'))
            <div
                style="background: #d4edda; color: #155724; padding: 10px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background: #f8d7da; color: #721c24; padding: 10px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <h2>Logbook Mahasiswa</h2>
        <button class="tambah-btn" onclick="showModal('add')">Tambah</button>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Pelaksanaan</th>
                    <th>Uraian Kegiatan</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Yang Terlibat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logbooks as $i => $log)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $log->tanggal }}</td>
                        <td>{{ $log->uraian_kegiatan }}</td>
                        <td>{{ $log->waktu_mulai }}</td>
                        <td>{{ $log->waktu_selesai }}</td>
                        <td>{{ $log->yang_terlibat }}</td>
                        <td>
                            <button class="action-btn" onclick="editLogbook({{ $log }})">Edit</button>
                            <form method="POST" action="{{ route('logbook.destroy', $log->id_logbook) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="action-btn" type="submit"
                                    onclick="return confirm('Yakin hapus logbook ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data logbook.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal" id="modalLogbook">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal()">Tutup</button>
            <form id="logbookForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id_logbook" id="id_logbook">
                <label>Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal" id="tanggal" required>
                <label>Uraian Kegiatan</label>
                <textarea name="uraian_kegiatan" id="uraian_kegiatan" required></textarea>
                <label>Waktu Mulai</label>
                <input type="time" name="waktu_mulai" id="waktu_mulai" required>
                <label>Waktu Selesai</label>
                <input type="time" name="waktu_selesai" id="waktu_selesai" required>
                <label>Yang Terlibat</label>
                <input type="text" name="yang_terlibat" id="yang_terlibat" required>
                <button type="submit" id="submitBtn">SUBMIT</button>
            </form>
        </div>
    </div>

    <script>
        function showModal(mode) {
            document.getElementById('modalLogbook').style.display = 'flex';
            if (mode === 'add') {
                document.getElementById('logbookForm').action = "{{ route('logbook.store') }}";
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('id_logbook').value = '';
                document.getElementById('tanggal').value = '';
                document.getElementById('uraian_kegiatan').value = '';
                document.getElementById('waktu_mulai').value = '';
                document.getElementById('waktu_selesai').value = '';
                document.getElementById('yang_terlibat').value = '';
            }
        }

        function closeModal() {
            document.getElementById('modalLogbook').style.display = 'none';
        }

        function editLogbook(log) {
            showModal('edit');
            document.getElementById('logbookForm').action = "{{ url('/mahasiswa/logbook') }}/" + log.id_logbook;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('id_logbook').value = log.id_logbook;
            document.getElementById('tanggal').value = log.tanggal;
            document.getElementById('uraian_kegiatan').value = log.uraian_kegiatan;
            document.getElementById('waktu_mulai').value = log.waktu_mulai;
            document.getElementById('waktu_selesai').value = log.waktu_selesai;
            document.getElementById('yang_terlibat').value = log.yang_terlibat;
        }
    </script>
</body>

</html>
