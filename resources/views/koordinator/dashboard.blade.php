<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Koordinator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            /* Adjust max-width if needed based on the new table width */
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            /* Added a subtle shadow */
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            /* Lighter border for better aesthetics */
            padding: 12px 10px;
            text-align: center;
            vertical-align: middle; /* Align content vertically in the middle */
        }

        th {
            background: #e9e9e9;
            /* Slightly darker background for headers */
            font-size: 1rem;
            color: #333;
            font-weight: bold;
        }

        td {
            font-size: 0.95rem; /* Slightly smaller font for table data */
            color: #555;
        }

        .logout-btn {
            float: right;
            margin-top: 10px;
            background: #007bff;
            /* Changed to a more standard blue */
            color: #fff;
            border: none;
            border-radius: 6px;
            /* Slightly smaller border-radius for modern look */
            padding: 8px 18px;
            font-weight: normal; /* Less bold for a softer look */
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Smooth transition on hover */
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }


        select {
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%; /* Make select fill the cell */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        .submit-btn {
            display: block; /* Make it a block element to center */
            margin: 20px auto 0; /* Center the button */
            background: #28a745;
            /* Changed to a standard green for submit */
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        /* Added new styles for better table header grouping */
        .header-group {
            background: #f0f0f0;
            font-weight: bold;
            padding: 8px 0;
            border-bottom: 1px solid #ccc;
            color: #444;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-align: center;
            opacity: 1; /* Ensure it's not transparent */
            transition: opacity 0.5s ease; /* Optional: for fading out */
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="/logout" style="text-align:right;">
            @csrf
            <button class="logout-btn" type="submit">Logout</button>
        </form>
        <h2>Selamat Datang Koordinator</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('koordinator.update-pembimbing') }}">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th colspan="4" class="header-group">Mahasiswa 1</th>
                        <th colspan="4" class="header-group">Mahasiswa 2</th>
                        <th rowspan="2">Pembimbing</th>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>Status</th>
                        <th>Dosen Sebelumnya</th>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>Status</th>
                        <th>Dosen Sebelumnya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelompok as $item)
                    <tr>
                        <td>
                            {{ $item->mahasiswa1->nim ?? '-' }}
                        </td>
                        <td>
                            {{ $item->mahasiswa1->nama_mhs ?? '-' }}
                        </td>
                        <td>
                            {{ ucfirst($item->mahasiswa1->status_mengulang ?? '-') }}
                        </td>
                        <td>
                            {{ $item->mahasiswa1->dosen_sebelum ?? '-' }}
                        </td>
                        <td>
                            {{ $item->mahasiswa2->nim ?? '-' }}
                        </td>
                        <td>
                            {{ $item->mahasiswa2->nama_mhs ?? '-' }}
                        </td>
                        <td>
                            {{ ucfirst($item->mahasiswa2->status_mengulang ?? '-') }}
                        </td>
                        <td>
                            {{ $item->mahasiswa2->dosen_sebelum ?? '-' }}
                        </td>
                        <td>
                            <select name="pembimbing[{{ $item->id_klp }}]">
                                <option value="">-- Pilih Dosen --</option>
                                @foreach ($dosenList as $dosen)
                                <option value="{{ $dosen->id_dosen }}" {{ $item->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                    {{ $dosen->nama_dosen }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="submit-btn" type="submit">KIRIM</button>
        </form>
    </div>
</body>

</html>
