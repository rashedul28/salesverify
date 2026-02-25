<x-guest-layout>
    <!-- Session Status -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
            <input id="email" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-[#4f46e5] hover:text-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <input id="password" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-[#4f46e5] focus:ring-[#4f46e5]" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#5a67d8] hover:bg-[#4c51bf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a67d8] transition-colors">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-400">or</span>
            </div>
        </div>

        <div>
            <a href="{{ route('register') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a67d8] transition-colors">
                {{ __('Sign Up') }}
            </a>
        </div>
    </form>
</x-guest-layout>
