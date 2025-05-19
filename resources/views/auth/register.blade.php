<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

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
        
        /* Custom select styling */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 40px;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center p-4" style="background-color: #c9b491;">
        <div class="w-full max-w-6xl flex overflow-hidden rounded-lg shadow-xl">
            <!-- Image à gauche -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/imageLogin%5B1%5D.jpg-RfYGbPM0jci4duU4yBhQ50qT0X5uql.jpeg');">
            </div>
            
            <!-- Formulaire d'inscription à droite -->
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
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Create an Account</h2>
                    <p class="text-center text-gray-700 mb-8">Join our community of book lovers</p>
                    
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Last Name -->
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">{{ __('Last Name') }}</label>
                            <input id="name" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="family-name" />
                            @error('name')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- First Name -->
                        <div>
                            <label for="prenom" class="block text-gray-700 font-medium mb-2">{{ __('First Name') }}</label>
                            <input id="prenom" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="text" 
                                   name="prenom" 
                                   value="{{ old('prenom') }}" 
                                   required 
                                   autocomplete="given-name" />
                            @error('prenom')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

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
                                   autocomplete="username" />
                            @error('email')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="date_naissance" class="block text-gray-700 font-medium mb-2">{{ __('Birth Date') }}</label>
                            <div class="relative">
                                <input id="date_naissance" 
                                       class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                       style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                       type="date" 
                                       name="date_naissance" 
                                       value="{{ old('date_naissance') }}" 
                                       autocomplete="bday" />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @error('date_naissance')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="telephone" class="block text-gray-700 font-medium mb-2">{{ __('Phone Number') }}</label>
                            <input id="telephone" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="tel" 
                                   name="telephone" 
                                   value="{{ old('telephone') }}" 
                                   autocomplete="tel" />
                            @error('telephone')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="adresse" class="block text-gray-700 font-medium mb-2">{{ __('Address') }}</label>
                            <input id="adresse" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="text" 
                                   name="adresse" 
                                   value="{{ old('adresse') }}" 
                                   autocomplete="street-address" />
                            @error('adresse')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Role Selection -->
                        <div>
                            <label for="id_role" class="block text-gray-700 font-medium mb-2">{{ __('Role') }}</label>
                            <select id="id_role" 
                                    name="id_role" 
                                    class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                    style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                    required>
                                <option value="" selected disabled>Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id_role }}" {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                                    {{ $role->libelle ?? $role->code }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_role')
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
                                   autocomplete="new-password" />
                            @error('password')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" 
                                   class="w-full px-6 py-3 border-2 border-opacity-20 rounded-full focus:outline-none focus:ring-0 focus:border-opacity-50" 
                                   style="background-color: #e6d5b8; border-color: #6b2b25; color: #333;"
                                   type="password"
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password" />
                            @error('password_confirmation')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full py-3 text-white font-medium rounded-full focus:outline-none transition-all duration-300 ease-in-out" 
                                    style="background-color: #6b2b25;" 
                                    onmouseover="this.style.backgroundColor='#5a241f'" 
                                    onmouseout="this.style.backgroundColor='#6b2b25'">
                                {{ __('REGISTER') }}
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-6">
                        <a class="text-gray-700 font-medium transition-all duration-200 ease-in-out" 
                           style="color: #6b2b25;" 
                           href="{{ route('login') }}"
                           onmouseover="this.style.textDecoration='underline'" 
                           onmouseout="this.style.textDecoration='none'">
                            {{ __('Already registered? Login here') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>