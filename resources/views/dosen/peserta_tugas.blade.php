<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 300px;
        }

        .form-container h3 {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="number"],
        .form-container input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #3de6e1;
            color: #222;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
            margin-right: 10px;
        }

        button:hover {
            background-color: #29bdb8;
        }

        button.cancel-btn {
            background-color: #f44336;
            color: #fff;
        }

        button.cancel-btn:hover {
            background-color: #d32f2f;
        }

        .back-button {
            margin-bottom: 20px;
            display: inline-block;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <button class="back-button" onclick="window.location.href='{{ route('dosen.nilai') }}'">Back</button>
    <h2>Peserta Tugas: {{ $tugas->judul }}</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kelompok</th>
                <th>File Tugas</th>
                <th>Nilai</th>
                <th>Bobot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tugas->kelompok as $index => $klp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $klp->mahasiswa1->nama ?? $klp->nim1 }} &
                        {{ $klp->mahasiswa2->nama ?? $klp->nim2 }}
                    </td>
                    <td>
                        @if ($klp->pivot->file_tugas_mhs)
                            <a href="{{ asset('storage/' . $klp->pivot->file_tugas_mhs) }}" target="_blank">Download</a>
                        @else
                            Belum upload
                        @endif
                    </td>
                    <td>{{ $klp->pivot->nilai ?? '-' }}</td>
                    <td>{{ $tugas->bobot ?? '-' }}</td>
                    <td>
                        <button onclick="showForm('{{ $klp->pivot->id }}', '{{ $klp->mahasiswa1->nama ?? $klp->nim1 }} & {{ $klp->mahasiswa2->nama ?? $klp->nim2 }}')">
                            Beri Nilai
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada yang mengumpulkan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="hideForm()"></div>

    <!-- Form Container -->
    <div class="form-container" id="form-container">
        <h3>Beri Nilai</h3>
        <form id="nilai-form" method="POST">
            @csrf
            <label for="kelompok">Kelompok</label>
            <input type="text" id="kelompok" readonly>

            <label for="nilai">Nilai</label>
            <input type="number" id="nilai" name="nilai" required>

            <button type="submit">Simpan</button>
            <button type="button" class="cancel-btn" onclick="hideForm()">Batal</button>
        </form>
    </div>

    <script>
        function showForm(idTugasKelompok, kelompokNama) {
            const form = document.getElementById('nilai-form');
            const tugasId = "{{ $tugas->id_tugas }}";
            const route = `/dosen/tugas/${tugasId}/nilai/${idTugasKelompok}/simpan`;

            form.action = route;
            document.getElementById('kelompok').value = kelompokNama;
            document.getElementById('nilai').value = '';

            document.getElementById('form-container').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>

</html>
