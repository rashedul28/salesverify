<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- custom favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}">

        

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-slate-50 flex">
        
        <!-- Left Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 bg-blue-50 items-center justify-center p-12 relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-50 opacity-80 z-0"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            
            <div class="relative z-10 w-full max-w-lg">
                <img src="{{ asset('CPA Sales verification Platforms .png') }}" alt="CPA Sales Verification Platforms" class="w-full h-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
            </div>
        </div>

        <!-- Right Side - Form Container -->
        <div class="w-full lg:w-1/2 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50 relative">
            <div class="absolute top-0 left-0 w-full p-6 lg:hidden">
                <a href="/" class="flex items-center text-indigo-600 text-xl font-bold tracking-tight">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    CPA Sales Verification Platforms
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white/90 backdrop-blur-md shadow-2xl border border-slate-100 rounded-3xl relative z-10">
                <div class="mb-8 text-center lg:hidden lg:mb-0">
                   <!-- Only show logo string if needed, otherwise handled by header -->
                </div>
                <div class="mb-8 text-center hidden lg:block">
                    <a href="/" class="inline-flex items-center text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 text-2xl font-bold tracking-tight">
                        <svg class="w-8 h-8 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Welcome Back
                    </a>
                    <p class="text-slate-500 text-sm mt-2">Sign in to continue to your dashboard.</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
