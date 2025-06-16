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

        .tambah-btn {
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

        .action-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            margin: 0 5px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Modal */
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
        .modal-content textarea {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 10px;
            border: 1px solid #222;
            border-radius: 4px;
        }

        .modal-content textarea {
            min-height: 60px;
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
            <div class="welcome">Selamat Datang {{ Auth::user()->username ?? '' }}</div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>
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

    <!-- Modal Tambah/Edit -->
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
