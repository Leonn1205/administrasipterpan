<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Tugas</title>
</head>
<body>
    <h2>Peserta Tugas: {{ $tugas->judul }}</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kelompok</th>
                <th>File Tugas</th>
                <th>Nilai</th>
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
                        @if($klp->pivot->file_tugas_mhs)
                            <a href="{{ asset('storage/' . $klp->pivot->file_tugas_mhs) }}" target="_blank">Download</a>
                        @else
                            Belum upload
                        @endif
                    </td>
                    <td>{{ $klp->pivot->nilai ?? '-' }}</td>
                    <td>
                        <a href="{{ route('dosen.tugas.nilai.form', [$tugas->id_tugas, $klp->pivot->id]) }}">Beri Nilai</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada kelompok</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
