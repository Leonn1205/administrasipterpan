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
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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

        .logout-btn {
            float: right;
            margin-top: 10px;
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        select {
            padding: 6px 10px;
            border-radius: 4px;
        }

        .submit-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
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
        <form method="POST" action="{{ route('koordinator.update-pembimbing') }}">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>Status</th>
                        <th>Dosen Sebelumnya</th>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>Status</th>
                        <th>Dosen Sebelumnya</th>
                        <th>Pembimbing</th>
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
                                        <option value="{{ $dosen->id_dosen }}"
                                            {{ $item->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
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
