<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-gray-900 p-2 rounded-xl">
                <i class="fa-solid fa-users-gear text-white"></i>
            </div>
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-900">Basis Data Pengguna</h3>
                    <div class="bg-white px-4 py-2 border border-gray-200 rounded-lg text-sm font-bold text-gray-600 shadow-sm">
                        Total: {{ $users->count() }} Pengguna
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-bold">Profil & Kontak</th>
                                <th class="p-4 font-bold">Tipe Akun</th>
                                <th class="p-4 font-bold">Saldo / Poin</th>
                                <th class="p-4 font-bold">Kode Referal</th>
                                <th class="p-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="p-4">
                                        <div class="font-black text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 mt-1"><i class="fa-regular fa-envelope mr-1"></i> {{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-phone mr-1"></i> {{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4">
                                        @if($user->role === 'admin')
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-red-200 w-fit flex items-center gap-1"><i class="fa-solid fa-user-shield"></i> Admin</span>
                                        @elseif($user->role === 'driver')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-blue-200 w-fit flex items-center gap-1"><i class="fa-solid fa-motorcycle"></i> Mitra Kurir</span>
                                        @elseif($user->role === 'b2b_user')
                                            <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-teal-200 w-fit flex items-center gap-1"><i class="fa-solid fa-shop"></i> Bisnis / UMKM</span>
                                        @else
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-green-200 w-fit flex items-center gap-1"><i class="fa-solid fa-user"></i> Personal (B2C)</span>
                                        @endif
                                        <div class="text-xs text-gray-400 mt-2">Gabung: {{ $user->created_at->format('d M Y') }}</div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-black text-gray-800 text-lg">{{ number_format($user->point_balance, 0, ',', '.') }}</div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-lg inline-block tracking-wider text-sm border border-gray-200">
                                            {{ $user->referral_code ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="p-4 text-right">
                                        @if($user->role !== 'admin')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('APAKAH ANDA YAKIN? Menghapus pengguna ini akan menghapus akunnya secara permanen!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 px-3 py-2 rounded-lg font-bold text-sm transition shadow-sm flex items-center gap-2 ml-auto">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500">
                                        <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300 block"></i>
                                        Belum ada pengguna yang terdaftar di sistem.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>