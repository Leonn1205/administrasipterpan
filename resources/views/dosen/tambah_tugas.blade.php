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
        input[type="file"] {
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
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Tugas</h2>
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (session()->has('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('debug'))
            <div class="alert-success">
                Debugging: {{ session('debug') }}
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
