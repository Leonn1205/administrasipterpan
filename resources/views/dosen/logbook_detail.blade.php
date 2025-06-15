<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Logbook Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header .title {
            font-size: 1.4rem;
            font-weight: bold;
        }

        .header .back-btn {
            background: #3de6e1;
            color: #222;
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1.5px solid #333;
            padding: 10px 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #e6f7f7;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">
            Logbook Mahasiswa: {{ $mahasiswa->nama_mhs }} ({{ $mahasiswa->nim }})
        </div>
        <a href="{{ route('dosen.logbook') }}" class="back-btn">Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pelaksanaan</th>
                <th>Uraian Kegiatan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Yang Terlibat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbook as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $log->tanggal }}</td>
                    <td>{{ $log->uraian_kegiatan }}</td>
                    <td>{{ $log->waktu_mulai }}</td>
                    <td>{{ $log->waktu_selesai }}</td>
                    <td>{{ $log->yang_terlibat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data logbook.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
