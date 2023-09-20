<x-guest-layout>
    <form method="POST" action="{{ route('change-password') }}">
        @csrf


        <!-- Email Address -->
        <div>
            <x-input-label for="old_password" :value="__('Old Password')" />
            <x-text-input id="email" class="block mt-1 w-full" type="password" name="old_password" :value="old('',)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="new_password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="confirm_password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Change Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
