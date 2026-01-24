<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kedai Bang Nana</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-4">
        <div class="bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-2xl font-bold text-slate-800 text-center mb-1">
                Kedai Bang <span class="text-amber-500">Nana</span>
            </h1>
            <p class="text-center text-slate-500 mb-6">Silakan masuk untuk melanjutkan</p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-slate-700 text-sm font-medium mb-2">Username</label>
                    <input type="text" name="username" id="username"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Masukan username" required autofocus>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-slate-700 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Masukan password" required>
                </div>
                <div class="d-grid">
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-2.5 px-4 rounded-lg transition duration-300 ease-in-out">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
        <div class="text-slate-500 text-center mt-6 text-sm">
            <small>Skripsi 2026 - Kedai Bang Nana</small>
        </div>
    </div>

</body>

</html>