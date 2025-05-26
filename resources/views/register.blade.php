<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <style>
        /* ...style tetap seperti sebelumnya... */
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .register-box {
            width: 400px;
            padding: 40px 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 40px;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
        }

        label {
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 5px;
            margin-top: 15px;
            align-self: flex-start;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 8px 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 10px 0;
            background: #3de6e1;
            border: none;
            border-radius: 20px;
            color: #222;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #2ccfcf;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            width: 100%;
        }

        .login-link {
            margin-top: 15px;
            text-align: center;
            width: 100%;
        }

        .login-link a {
            color: #2ccfcf;
            text-decoration: none;
            font-size: 14px;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-box">
            <h1>Registrasi Mahasiswa</h1>
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="/register">
                @csrf
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required>

                <label for="username">USERNAME</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password" required minlength="8">

                <label for="nama">NAMA</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>

                <label for="no_telp">NO TELP</label>
                <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}">

                <div style="display: flex; align-items: flex-end; gap: 10px;">
                    <div style="flex:1;">
                        <label for="status_mengulang">STATUS MENGULANG</label>
                        <select id="status_mengulang" name="status_mengulang" required onchange="toggleDosenSebelum()">
                            <option value="tidak_mengulang"
                                {{ old('status_mengulang') == 'tidak_mengulang' ? 'selected' : '' }}>Tidak Mengulang
                            </option>
                            <option value="mengulang" {{ old('status_mengulang') == 'mengulang' ? 'selected' : '' }}>
                                Mengulang</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label for="dosen_sebelum">DOSEN SEBELUM</label>
                        <select id="dosen_sebelum" name="dosen_sebelum"
                            {{ old('status_mengulang') != 'mengulang' ? 'disabled' : '' }}>
                            <option value="" disabled {{ old('dosen_sebelum') ? '' : 'selected' }}>Pilih Dosen
                            </option>
                            <option value="Aloysius Airlangga Bajuadji, S.Kom., M.Eng."
                                {{ old('dosen_sebelum') == 'Aloysius Airlangga Bajuadji, S.Kom., M.Eng.' ? 'selected' : '' }}>
                                Aloysius Airlangga Bajuadji, S.Kom., M.Eng.</option>
                            <option value="Andhika Galuh Prabawati, S.Kom., M.Kom."
                                {{ old('dosen_sebelum') == 'Andhika Galuh Prabawati, S.Kom., M.Kom.' ? 'selected' : '' }}>
                                Andhika Galuh Prabawati, S.Kom., M.Kom.</option>
                            <option value="Andreas Satyo Aji Nugroho, S.Kom."
                                {{ old('dosen_sebelum') == 'Andreas Satyo Aji Nugroho, S.Kom.' ? 'selected' : '' }}>
                                Andreas Satyo Aji Nugroho, S.Kom.</option>
                            <option value="Argo Wibowo, S.T., M.T."
                                {{ old('dosen_sebelum') == 'Argo Wibowo, S.T., M.T.' ? 'selected' : '' }}>Argo Wibowo,
                                S.T., M.T.</option>
                            <option value="Lussy Ernawati, S.Kom., M.Acc"
                                {{ old('dosen_sebelum') == 'Lussy Ernawati, S.Kom., M.Acc' ? 'selected' : '' }}>Lussy
                                Ernawati, S.Kom., M.Acc</option>
                            <option value="Wilson Nasumi Mili, S.Kom., M.T."
                                {{ old('dosen_sebelum') == 'Wilson Nasumi Mili, S.Kom., M.T.' ? 'selected' : '' }}>
                                Wilson Nasumi Mili, S.Kom., M.T.</option>
                            <option value="Yetli Oslan, S.Kom, M.T."
                                {{ old('dosen_sebelum') == 'Yetli Oslan, S.Kom, M.T.' ? 'selected' : '' }}>Yetli Oslan,
                                S.Kom, M.T.</option>
                        </select>
                    </div>
                </div>

                <button type="submit">REGISTRASI</button>
            </form>
            <script>
                function toggleDosenSebelum() {
                    var status = document.getElementById('status_mengulang').value;
                    var dosenSebelum = document.getElementById('dosen_sebelum');
                    if (status === 'mengulang') {
                        dosenSebelum.disabled = false;
                    } else {
                        dosenSebelum.disabled = true;
                        dosenSebelum.selectedIndex = 0;
                    }
                }
                document.addEventListener('DOMContentLoaded', function() {
                    toggleDosenSebelum();
                });
            </script>
            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>
</body>

</html>
