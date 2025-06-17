<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Piterpan</title>
    <style>
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

        .login-box {
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

        input,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 8px 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #3de6e1;
            box-shadow: 0 0 5px rgba(61, 230, 225, 0.5);
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

        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Sistem Informasi Piterpan</h1>

            @if ($errors->has('login'))
                <div class="alert-danger">
                    <ul>
                        <li>{{ $errors->first('login') }}</li>
                    </ul>
                </div>
            @endif

            <form method="POST" action="/">
                @csrf

                <label for="username">USERNAME</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username"
                    value="{{ old('username') }}" required autofocus>

                <label for="password">PASSWORD</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required minlength="8"
                        style="width: 100%; padding-right: 70px;">
                    <div
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: flex; align-items: center;">
                        <input type="checkbox" id="showPassword" onclick="togglePassword()" style="margin:0;">
                        <label for="showPassword" style="font-size:12px; margin-left:5px; cursor:pointer;"></label>
                    </div>
                </div>

                <label for="role">ROLE</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected hidden>Pilih Role</option>
                    <option value="koordinator" {{ old('role') == 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>

                <button type="submit">LOGIN</button>

                <div style="width: 100%; margin-top: 20px; text-align: center;">
                    <a href="/register"
                        style="color: #2ccfcf; font-size: 18px; text-decoration: none; font-weight: bold;">
                        Belum punya akun? Registrasi
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>
