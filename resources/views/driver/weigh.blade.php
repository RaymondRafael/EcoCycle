<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('driver.dashboard') }}" class="bg-white p-2 rounded-xl text-slate-600 hover:bg-slate-50 border border-slate-200 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-black text-xl text-slate-900 leading-tight">
                {{ __('Input Timbangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-100 min-h-screen">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800">Detail Pelanggan</h3>
                    <span class="text-[10px] font-black uppercase tracking-wider {{ $task->user->role === 'b2b_user' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-green-50 text-green-700 border-green-200' }} border px-2.5 py-1 rounded-md">
                        {{ $task->user->role === 'b2b_user' ? 'Akun Bisnis' : 'Akun Personal' }}
                    </span>
                </div>
                <div class="text-sm text-slate-600 space-y-1">
                    <p><i class="fa-solid fa-user w-5"></i> {{ $task->user->name }}</p>
                    <p><i class="fa-solid fa-phone w-5"></i> {{ $task->user->phone ?? 'Tidak ada nomor' }}</p>
                </div>
            </div>

            <form action="{{ route('driver.pickup.processWeigh', $task->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <h3 class="font-black text-slate-800 ml-2">Hasil Timbangan (Kg)</h3>
                <p class="text-xs text-slate-500 ml-2 mb-4">Kosongkan kolom jika jenis sampah tidak ada.</p>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg"><i class="fa-solid fa-recycle"></i></div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Plastik</p>
                            <p class="text-[10px] text-slate-400">Botol, Kemasan</p>
                        </div>
                    </div>
                    <div class="relative w-24">
                        <input type="number" step="0.1" name="weight_plastic" class="block w-full pr-8 py-2 text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-center font-bold text-slate-700 bg-slate-50" placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><span class="text-slate-400 text-xs font-bold">Kg</span></div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg"><i class="fa-solid fa-box-open"></i></div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Kertas</p>
                            <p class="text-[10px] text-slate-400">Kardus, Buku</p>
                        </div>
                    </div>
                    <div class="relative w-24">
                        <input type="number" step="0.1" name="weight_paper" class="block w-full pr-8 py-2 text-sm border-slate-200 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 text-center font-bold text-slate-700 bg-slate-50" placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><span class="text-slate-400 text-xs font-bold">Kg</span></div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-lg"><i class="fa-solid fa-oil-can"></i></div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Logam</p>
                            <p class="text-[10px] text-slate-400">Kaleng, Besi</p>
                        </div>
                    </div>
                    <div class="relative w-24">
                        <input type="number" step="0.1" name="weight_metal" class="block w-full pr-8 py-2 text-sm border-slate-200 rounded-xl focus:ring-gray-500 focus:border-gray-500 text-center font-bold text-slate-700 bg-slate-50" placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><span class="text-slate-400 text-xs font-bold">Kg</span></div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center text-lg"><i class="fa-solid fa-wine-glass"></i></div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Kaca</p>
                            <p class="text-[10px] text-slate-400">Botol utuh</p>
                        </div>
                    </div>
                    <div class="relative w-24">
                        <input type="number" step="0.1" name="weight_glass" class="block w-full pr-8 py-2 text-sm border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 text-center font-bold text-slate-700 bg-slate-50" placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><span class="text-slate-400 text-xs font-bold">Kg</span></div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" onclick="return confirm('Data sudah benar? Poin akan langsung dikirim ke pelanggan setelah disimpan.')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black px-6 py-4 rounded-2xl text-sm transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Konfirmasi & Selesaikan Tugas
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>