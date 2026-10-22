<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-tr from-slate-900 to-orange-600">
    @include('sweetalert::alert')


    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full mx-4">
            <h1 class="font-bold text-center text-white text-2xl mb-2 py-4">LAZISMU</h1>
            <!-- Tab Navigation -->
            {{-- <div class="flex mb-4">
                <button onclick="switchTab('login')" id="login-tab"
                    class="w-1/2 py-2 px-4 font-bold text-center border-b-2 text-md focus:outline-none transition-colors duration-200">
                    Login
                </button>
                <button onclick="switchTab('register')" id="register-tab"
                    class="w-1/2 py-2 px-4 text-center font-bold text-md border-b-2 text-sm focus:outline-none transition-colors duration-200">
                    Register
                </button>
            </div> --}}

            <div class="bg-white border-slate-200 border-2 rounded-lg shadow-lg">
                <!-- Login Form -->
                <div id="login-form" class="p-8">
                    <form action="{{ route('logins.index') }}" method="POST">
                        @csrf
                        <h1 class="text-center font-bold">Login</h1>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="login-name">
                                Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                id="login-name" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="login-password">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline pr-10"
                                    id="login-password" type="password" name="password" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePasswordVisibility('login-password', 'login-eye-icon')">
                                    <i id="login-eye-icon" class="fas fa-eye text-gray-500"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                {{-- <!-- Register Form -->
                <div id="register-form" class="hidden p-8">
                    <form action="{{ route('register.index') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                id="name" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="register-phone">
                                No Hp
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone_number') border-red-500 @enderror"
                                id="register-phone" type="number" name="phone_number" value="{{ old('phone_number') }}"
                                required>
                            @error('phone_number')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="register-password">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10"
                                    id="register-password" type="password" name="password" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePasswordVisibility('register-password', 'register-eye-icon')">
                                    <i id="register-eye-icon" class="fas fa-eye text-gray-500"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Register
                            </button>
                        </div>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>


    <!-- JavaScript for Tab Switching and Password Toggle -->
    <script>
        // Initialize tabs
        // document.addEventListener('DOMContentLoaded', function() {
        //     switchTab('login');
        // });

        // function switchTab(tab) {
        //     // Update tab styles
        //     document.getElementById('login-tab').classList.remove('border-blue-500', 'text-blue-500');
        //     document.getElementById('register-tab').classList.remove('border-blue-500', 'text-blue-600');
        //     document.getElementById(tab + '-tab').classList.add('border-blue-500', 'text-blue-600');

        //     // Show/hide forms
        //     document.getElementById('login-form').classList.add('hidden');
        //     document.getElementById('register-form').classList.add('hidden');
        //     document.getElementById(tab + '-form').classList.remove('hidden');
        // }

        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

</body>

</html>
