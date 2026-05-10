<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center relative">

    {{-- Background Image + Blue Overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('image/bnn.jpg') }}" 
             alt="Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-blue-400 bg-opacity-50"></div>
    </div>

    {{-- Login Form --}}
    <div class="relative z-10 bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
       
         {{-- Gambar/logo di bawah judul --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('image/logo BNN.png') }}" alt="Logo" class="h-20 w-auto">
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            <button 
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Login
            </button>
        </form>
    </div>

</body>
</html>
