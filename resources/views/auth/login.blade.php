<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMPELDIK</title>
    <link rel="icon" type="image/png" href="{{ asset('img/tut-wuri-2.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms,typography,aspect-ratio,container-queries"></script>
    <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#2e9e4e" data-border-radius="large"></script>
</head>

<body class="min-h-screen bg-gray-100 flex flex-col lg:flex-row font-['Inter']">

    <!-- Left Side -->
    <div class="lg:w-1/2 bg-[#2e9e4e] flex flex-col items-center justify-center p-10 text-white">
        <img src="{{ asset('images/bgbro.png') }}" alt="Logo SIMPELDIK" class="w-24 mb-4">
        <h1 class="text-2xl font-bold text-center">SISTEM INFORMASI PEMBELAJARAN PESERTA DIDIK</h1>
        <p class="text-center mt-2">TK TARUNA ISLAM AL QURAN</p>
        <img src="{{ asset('images/TK1.png') }}" alt="Ilustrasi" class="w-3/4 max-w-sm mt-8">
    </div>

    <!-- Right Side -->
    <div class="lg:w-1/2 flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-center text-green-700 mb-6">Masuk SIMPELDIK</h2>

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="identifier" class="block text-sm font-medium text-gray-700 mb-2">NIP/NIS</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="identifier" id="identifier" value="{{ old('identifier') }}"
                            placeholder="Masukkan NIS/NIP"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="password" name="password"
                            placeholder="Masukkan Password"
                            class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            required>
                        <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 toggle-password" data-target="password">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 h-4 w-4 border-gray-300 rounded text-green-600 focus:ring-green-500">
                        Ingat saya
                    </label>
                    <a href="#" class="text-green-600 hover:text-green-700">Lupa kata sandi?</a>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>

                <div class="text-center mt-4 text-sm">
                    Belum punya akun? <a href="#" class="text-green-600 hover:text-green-700">Daftar Gratis</a>
                </div>
            </form>

            <div class="flex justify-center gap-4 mt-6">
                <button class="border border-green-600 px-4 py-2 rounded-lg text-green-600 hover:bg-green-100"><i class="fab fa-facebook-f"></i></button>
                <button class="border border-green-600 px-4 py-2 rounded-lg text-green-600 hover:bg-green-100"><i class="fab fa-google"></i></button>
                <button class="border border-green-600 px-4 py-2 rounded-lg text-green-600 hover:bg-green-100"><i class="fab fa-instagram"></i></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.dataset.target;
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    }
                });
            });
        });
    </script>

</body>
</html>
