<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Tugas - Dosen Pembimbing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        input[type="file"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3de6e1;
            border: none;
            border-radius: 20px;
            color: #222;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            font-weight: bold;
        }

        ul.error-list {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Tugas</h2>

        {{-- ALERT ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="alert-error">
                <strong>Terjadi kesalahan:</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ALERT SUKSES --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR UMUM --}}
        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- ALERT DEBUG (opsional) --}}
        @if (session('debug'))
            <div class="alert-success">
                Debug: {{ session('debug') }}
            </div>
        @endif

        <form method="POST" action="{{ route('dosen.tugas.store') }}" enctype="multipart/form-data">
            @csrf

            <label for="judul">Judul Tugas</label>
            <input type="text" id="judul" name="judul" required>

            <label for="mulai">Tanggal Mulai</label>
            <input type="date" id="mulai" name="mulai" required>

            <label for="kumpul_sblm">Kumpul Sebelum</label>
            <input type="date" id="kumpul_sblm" name="kumpul_sblm" required>

            <label for="file_tugas_dosen">Aktivitas (Maksimal 2MB)</label>
            <input type="file" id="file_tugas_dosen" name="file_tugas_dosen"
                accept=".gif,.jpg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.odt,.zip,.pdf" required>

            <label for="bobot">Bobot</label>
            <input type="number" id="bobot" name="bobot" required>

            <button type="submit">Simpan Tugas</button>
        </form>

        <form method="GET" action="{{ route('dosen.tugas') }}">
            <button type="submit" class="back-button">Kembali</button>
        </form>
    </div>
</body>

</html>
