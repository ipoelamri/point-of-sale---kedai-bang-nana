<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login - Kedai Bang Nana</title>
		@vite('resources/css/app.css')
		<style>
			.gradient-bg {
				background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);
			}
		</style>
	</head>

	<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-slate-50 via-amber-50 to-slate-50">

		<div class="w-full max-w-md p-4">
			<div class="rounded-xl bg-slate-900 p-8 shadow-lg">
				<!-- Logo and Title -->
				<div class="mb-8 text-center">
					<img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Bang Nana" class="mx-auto mb-4 h-16 w-16 object-contain">
					<h1 class="mb-1 text-center text-3xl font-bold text-white">
						Kedai Bang <span
							style="background: linear-gradient(135deg, #ff1493 0%, #d90b84 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Nana</span>
					</h1>
					<p class="mb-2 text-center text-slate-300">Café & Resto Terbaik</p>
					<p class="text-center text-sm text-slate-400">Silakan masuk untuk melanjutkan</p>
				</div>

				@if ($errors->any())
					<div class="relative mb-4 rounded-lg border border-red-400 bg-red-900 px-4 py-3 text-red-100" role="alert">
						<ul class="list-inside list-disc text-sm">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="/login" method="POST">
					@csrf
					<div class="mb-4">
						<label for="username" class="mb-2 block text-sm font-medium text-slate-300">Username</label>
						<input type="text" name="username" id="username"
							class="w-full rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500"
							placeholder="Masukan username" required autofocus>
					</div>
					<div class="mb-6">
						<label for="password" class="mb-2 block text-sm font-medium text-slate-300">Password</label>
						<input type="password" name="password" id="password"
							class="w-full rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500"
							placeholder="Masukan password" required>
					</div>
					<div class="d-grid">
						<button type="submit"
							class="w-full rounded-lg px-4 py-2.5 font-medium text-white transition duration-300 ease-in-out hover:shadow-lg active:scale-95"
							style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
							Masuk
						</button>
					</div>
				</form>
			</div>
			<div class="mt-6 text-center text-sm text-slate-500">
				<small>Skripsi 2026 - Kedai Bang Nana</small>
			</div>
		</div>

	</body>

</html>
