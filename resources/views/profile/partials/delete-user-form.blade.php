<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button
        class="bg-red-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-700 transition-colors focus:ring-4 focus:ring-red-200 text-sm"
        onclick="document.getElementById('confirm-user-deletion').showModal()"
    >
        Hapus Akun
    </button>

    <dialog id="confirm-user-deletion" class="rounded-lg p-0 backdrop:bg-gray-900/50">
        <div class="p-6 bg-white max-w-md">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    Apakah Anda yakin ingin menghapus akun?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Setelah akun Anda dihapus, semua data akan hilang permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                </p>

                <div class="mt-6">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Kata Sandi"
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required
                    >
                    @if($errors->userDeletion->has('password'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button 
                        type="button"
                        class="px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-md"
                        onclick="this.closest('dialog').close()"
                    >
                        Batal
                    </button>

                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-700 transition-colors text-sm">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</section>