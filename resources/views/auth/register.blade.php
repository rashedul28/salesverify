<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }}</label>
            <input id="name" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
            <input id="email" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
            <input id="password" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="block w-full border border-gray-300 focus:border-[#4f46e5] focus:ring-[#4f46e5] rounded-lg shadow-sm sm:text-sm py-2 px-3 outline-none" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#5a67d8] hover:bg-[#4c51bf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a67d8] transition-colors">
                {{ __('Sign Up') }}
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
            <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a67d8] transition-colors">
                {{ __('Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
