<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite('resources/css/app.css')
	</head>

	<body class="flex min-h-screen items-center justify-center font-sans antialiased" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);">

		<!-- Background decoration -->
		<div class="pointer-events-none fixed inset-0 overflow-hidden">
			<div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-pink-500/10 blur-3xl"></div>
			<div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-violet-500/10 blur-3xl"></div>
			<div class="absolute left-1/2 top-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-pink-500/5 blur-3xl"></div>
		</div>

		<div class="relative z-10 w-full max-w-md p-4">
			<div class="glass-card rounded-2xl p-8">
				<!-- Logo and Title -->
				<div class="mb-8 text-center">
					<div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl gradient-primary shadow-lg shadow-pink-500/25">
						<span class="text-2xl font-bold text-white">N</span>
					</div>
					<h1 class="mb-1 text-center text-2xl font-bold text-white">
						Kedai Bang <span class="text-gradient-primary">Nana</span>
					</h1>
					<p class="text-sm text-slate-400">Masuk ke dashboard Anda</p>
				</div>

				@if ($errors->any())
					<div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3" role="alert">
						<ul class="list-inside list-disc text-sm text-red-300">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="/login" method="POST" class="space-y-5">
					@csrf
					<div>
						<label for="username" class="form-label">Username</label>
						<div class="relative">
							<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
								<svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
								</svg>
							</div>
							<input type="text" name="username" id="username"
								class="form-input pl-10"
								placeholder="Masukan username" required autofocus>
						</div>
					</div>
					<div>
						<label for="password" class="form-label">Password</label>
						<div class="relative">
							<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
								<svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
								</svg>
							</div>
							<input type="password" name="password" id="password"
								class="form-input pl-10"
								placeholder="Masukan password" required>
						</div>
					</div>
					<button type="submit" class="btn btn-primary w-full py-3 text-base">
						Masuk
					</button>
				</form>
			</div>
			<div class="mt-6 text-center text-xs text-slate-600">
				<small>&copy; 2026 Kedai Bang Nana — Skripsi Project</small>
			</div>
		</div>

	</body>

</html>
