<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600 flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('Setelah akunmu dihapus, semua data (termasuk riwayat penjemputan dan poin) akan dihapus secara permanen. Harap cairkan saldo atau unduh data yang ingin kamu simpan sebelum melanjutkan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 rounded-xl px-6 py-3 transition transform hover:-translate-y-0.5"
    >
        <i class="fa-solid fa-trash-can mr-2"></i> {{ __('Hapus Akun Permanen') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-gray-900 mb-2">
                {{ __('Apakah kamu yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                {{ __('Tindakan ini tidak bisa dibatalkan. Masukkan kata sandimu untuk mengonfirmasi bahwa kamu ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring focus:ring-red-200"
                    placeholder="{{ __('Masukkan Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-5 py-2.5">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 rounded-xl px-5 py-2.5">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>