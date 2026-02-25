<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CallAnalytics</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col relative overflow-hidden">
        
        <!-- Navbar -->
        <header class="w-full flex justify-between items-center py-4 px-6 sm:px-10 absolute top-0 left-0 right-0 z-20">
            <a href="/" class="flex items-center text-[#5a67d8] text-xl font-bold tracking-tight">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <rect x="4" y="12" width="3" height="8" rx="1.5" />
                    <rect x="10" y="8" width="3" height="12" rx="1.5" />
                    <rect x="16" y="4" width="3" height="16" rx="1.5" />
                </svg>
                CallAnalytics
            </a>
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="py-2 px-6 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-6 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors shadow-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="py-2 px-6 text-sm font-medium text-white bg-[#5a67d8] border border-transparent rounded-full hover:bg-[#4c51bf] transition-colors shadow-sm">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col items-center justify-center relative z-10 px-4">
            
            <!-- Soft Center Glow behind the icon -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-[#5a67d8]/10 rounded-full blur-[80px] pointer-events-none"></div>

            <!-- Icon -->
            <div class="text-[#5a67d8] mb-8 z-10">
                <svg class="w-20 h-20" viewBox="0 0 24 24" fill="currentColor">
                    <rect x="5" y="13" width="3" height="8" rx="1.5" />
                    <rect x="10.5" y="8" width="3" height="13" rx="1.5" />
                    <rect x="16" y="3" width="3" height="18" rx="1.5" />
                </svg>
            </div>
            
            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-[#1e293b] mb-4 text-center z-10">
                Insightful <span class="text-[#5a67d8]">Analytics</span>
            </h1>
            
            <!-- Subheadline -->
            <p class="text-xl text-slate-500 font-medium text-center z-10">
                Listening to your data.
            </p>

        </main>
    </body>
</html>
