<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Input Nilai Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #a64ca6;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #222;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3de6e1;
            border: none;
            border-radius: 20px;
            color: #222;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #ddd;
        }

        .alert-success {
            background-color: #d4edda;
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
        <h2>Input Nilai Mahasiswa</h2>
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('dosen.nilai.update', $tugasKelompok->id) }}">
            @csrf

            <label for="bobot">Bobot</label>
            <input type="number" id="bobot" name="bobot" value="{{ $tugasKelompok->bobot }}" required>

            <label for="nilai">Nilai</label>
            <input type="number" id="nilai" name="nilai" value="{{ $tugasKelompok->nilai }}" required>

            <label for="capaian_maksimal">Capaian Maksimal</label>
            <input type="number" id="capaian_maksimal" name="capaian_maksimal" value="{{ $tugasKelompok->capaian_maksimal }}" required>

            <label for="nilai_huruf">Nilai Huruf</label>
            <input type="text" id="nilai_huruf" name="nilai_huruf" value="{{ $tugasKelompok->nilai_huruf }}" required>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>

</html>
