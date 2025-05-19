<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #c9b491;
        }
        
        /* Custom checkbox styling */
        input[type="checkbox"]:checked {
            background-color: #6b2b25 !important;
            border-color: #6b2b25 !important;
        }
        
        input[type="checkbox"]:checked::after {
            content: "✓";
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center p-4" style="background-color: #c9b491;">
        <div class="w-full max-w-6xl flex overflow-hidden rounded-lg shadow-xl">
            <!-- Image à gauche -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/imageLogin%5B1%5D.jpg-RfYGbPM0jci4duU4yBhQ50qT0X5uql.jpeg');">
            </div>
            
            <!-- Formulaire de connexion à droite -->
            <div class="w-full md:w-1/2 p-8 md:p-12" style="background-color: #e6d5b8; border-radius: 1.5rem;">
                <div class="flex flex-col items-center justify-center mb-8">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-center" viewBox="0 0 24 24" fill="#6b2b25">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20v-5.5A2.5 2.5 0 0 0 17.5 9H14V4.5A2.5 2.5 0 0 0 11.5 2h-7A2.5 2.5 0 0 0 2 4.5v15A2.5 2.5 0 0 0 4.5 22h7a2.5 2.5 0 0 0 2.5-2.5V19.5z"/>
                            <path d="M6 17h14a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2z"/>
                        </svg>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">MyBookSpace</h1>
                    </div>
                </div>
                
                <div class="rounded-3xl p-8 mx-auto max-w-md" style="background-color: #e9dcc7;">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Welcome Back</h2>
                    <p class="text-center text-gray-700 mb-8">Sign in to your account</p>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('Email') }}</label>
                            <input id="email" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username" 
                                   placeholder="Enter your email" />
                            @error('email')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-2">{{ __('Password') }}</label>
                            <input id="password" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="password"
                                   name="password"
                                   required 
                                   autocomplete="current-password" 
                                   placeholder="Enter your password" />
                            @error('password')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex justify-between items-center">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       class="w-5 h-5 rounded-full border-2 text-white focus:ring-0 focus:ring-offset-0"
                                       style="border-color: #6b2b25; background-color: transparent;"
                                       name="remember">
                                <span class="ml-2 text-gray-700">{{ __('Remember me') }}</span>
                            </label>
                            
                            @if (Route::has('password.request'))
                                <a class="text-gray-700 font-medium transition-all duration-200 ease-in-out" 
                                   style="color: #6b2b25;" 
                                   href="{{ route('password.request') }}"
                                   onmouseover="this.style.textDecoration='underline'" 
                                   onmouseout="this.style.textDecoration='none'">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full py-3 text-white font-medium rounded-full focus:outline-none transition-all duration-300 ease-in-out" 
                                    style="background-color: #6b2b25;" 
                                    onmouseover="this.style.backgroundColor='#5a241f'" 
                                    onmouseout="this.style.backgroundColor='#6b2b25'">
                                {{ __('LOGIN') }}
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-6">
                        <a class="text-gray-700 font-medium transition-all duration-200 ease-in-out" 
                           style="color: #6b2b25;" 
                           href="{{ route('register') }}"
                           onmouseover="this.style.textDecoration='underline'" 
                           onmouseout="this.style.textDecoration='none'">
                            {{ __('Don\'t have an account? Sign up') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>