{{-- resources/views/profile/partials/update-password-form.blade.php --}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Perbarui Password') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('Ganti password akun Anda.') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="current_password" :value="__('Password Sekarang')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>
</section>
