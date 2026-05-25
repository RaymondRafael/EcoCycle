<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-gray-900 p-2 rounded-xl">
                <i class="fa-solid fa-hand-holding-dollar text-white"></i>
            </div>
            {{ __('Pencairan Saldo Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Daftar Antrean Penarikan Uang</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Periksa detail rekening sebelum melakukan transfer manual.</p>
                    </div>
                    <span class="text-xs font-bold text-gray-600 bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
                        Menunggu Proses: <strong class="text-yellow-600">{{ $withdrawals->where('status', 'pending')->count() }}</strong> Data
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-bold">Waktu & Pemohon</th>
                                <th class="p-4 font-bold">Metode & Tujuan Transfer</th>
                                <th class="p-4 font-bold">Nominal Cair</th>
                                <th class="p-4 font-bold">Status Antrean</th>
                                <th class="p-4 font-bold text-center">Tindakan Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($withdrawals as $wd)
                                <tr class="hover:bg-gray-50/80 transition duration-150">
                                    
                                    <td class="p-4">
                                        <div class="font-black text-gray-900">{{ $wd->user->name }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase border
                                                {{ $wd->user->role === 'b2b_user' ? 'bg-teal-50 text-teal-700 border-teal-100' : 'bg-green-50 text-green-700 border-green-100' }}
                                            ">
                                                {{ $wd->user->role === 'b2b_user' ? 'Bisnis' : 'Personal' }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-gray-400 mt-1.5"><i class="fa-regular fa-clock mr-1"></i>{{ $wd->created_at->format('d M Y, H:i') }} WIB</div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-100 font-black px-2.5 py-1 rounded-xl text-xs uppercase mb-1.5 shadow-sm">
                                            <i class="fa-solid fa-wallet text-[10px]"></i> {{ $wd->payment_method }}
                                        </div>
                                        <div class="font-mono font-bold text-gray-800 text-base tracking-wide select-all" title="Klik 2x untuk menyalin nomor">
                                            {{ $wd->account_number }}
                                        </div>
                                        <div class="text-xs text-gray-500 font-bold mt-0.5">a.n. <span class="text-gray-900">{{ $wd->account_name }}</span></div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-black text-gray-900 text-lg">
                                            Rp {{ number_format($wd->amount_points, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-400 font-medium mt-0.5">Potong: -{{ number_format($wd->amount_points, 0, ',', '.') }} Pts</div>
                                    </td>

                                    <td class="p-4">
                                        @if($wd->status === 'pending')
                                            <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 border border-yellow-200 px-3 py-1 rounded-full text-xs font-bold tracking-wide animate-pulse">
                                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500"></div> Perlu Ditransfer
                                            </span>
                                        @elseif($wd->status === 'success')
                                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                                <i class="fa-solid fa-check text-[10px]"></i> Berhasil Cair
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                                <i class="fa-solid fa-xmark text-[10px]"></i> Permintaan Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($wd->status === 'pending')
                                            <div class="flex items-center justify-center gap-2">
                                                
                                                <form action="{{ route('admin.withdrawals.update', $wd->id) }}" method="POST" onsubmit="return confirm('Apakah Anda benar-benar sudah mengirimkan dana kas ke rekening/e-wallet pengguna ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="success">
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2 rounded-xl text-xs transition shadow-md shadow-green-600/20 flex items-center gap-1.5 transform hover:-translate-y-0.5 duration-150">
                                                        <i class="fa-solid fa-paper-plane"></i> Selesai Transfer
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.withdrawals.update', $wd->id) }}" method="POST" onsubmit="return confirm('Tolak permintaan pencairan dana ini? Poin akan otomatis dikembalikan penuh ke saldo akun pengguna.');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="bg-white hover:bg-red-50 text-red-600 border border-gray-200 px-3 py-2 rounded-xl text-xs font-bold transition">
                                                        Tolak
                                                    </button>
                                                </form>
                                                
                                            </div>
                                        @else
                                            <div class="text-center text-xs font-bold text-gray-400">
                                                <i class="fa-solid fa-lock mr-1"></i> Selesai Diarsip
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-500">
                                        <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-money-bill-transfer text-3xl"></i>
                                        </div>
                                        <h4 class="text-base font-bold text-gray-900 mb-1">Tidak ada antrean penarikan</h4>
                                        <p class="text-sm text-gray-400 max-w-sm mx-auto">Saat ini belum ada pengguna yang melakukan penarikan saldo virtual.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-start">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Control Panel
                </a>
            </div>

        </div>
    </div>
</x-app-layout>