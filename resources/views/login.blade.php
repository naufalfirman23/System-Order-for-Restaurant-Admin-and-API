<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/js/scripts.js', 'resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS -->
</head>
<body class="bg-warning d-flex justify-content-center align-items-center vh-100">
    <div class="container bg-white rounded shadow d-flex p-0" style="max-width: 800px; height: 400px;">
        <!-- Bagian Form Login -->
        <div class="col-6 bg-danger text-white d-flex flex-column justify-content-center align-items-center">
            <h2 class="mb-4 text-white">Login</h2>
            <form action="{{ route('login') }}" method="POST" class="w-75">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="email" required>
                </div>
                <div class="mb-3">
                    <input type="password" id="email" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-dark w-100 text-white">LOGIN</button>
            </form>
        </div>
        <!-- Bagian Gambar -->
        <div class="col-6 d-flex justify-content-center align-items-center">
            <img src="assets/img/logo-hanachik.png" alt="Logo Ayam" class="img-fluid" style="max-width: 200px;">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
