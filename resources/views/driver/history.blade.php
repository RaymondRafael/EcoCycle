<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-900 leading-tight flex items-center gap-3">
            <div class="bg-slate-900 p-2 rounded-xl text-white text-base">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            {{ __('Riwayat Penjemputan') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Log Aktivitas Selesai</h3>
                    <p class="text-xs text-slate-500">Daftar semua penjemputan yang telah rampung atau dibatalkan.</p>
                </div>

                <!-- TOMBOL TABS FILTER CIRI KHUSUS B2C / B2B -->
                <div class="bg-white p-1 rounded-xl border border-slate-200 flex gap-1 self-start sm:self-auto shadow-sm">
                    <a href="{{ route('driver.history') }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ !request()->query('type') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua
                    </a>
                    <a href="{{ route('driver.history', ['type' => 'b2c']) }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ request()->query('type') === 'b2c' ? 'bg-green-600 text-white shadow-sm' : 'text-slate-600 hover:text-green-600' }}">
                        Personal / B2C
                    </a>
                    <a href="{{ route('driver.history', ['type' => 'b2b']) }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ request()->query('type') === 'b2b' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-teal-600' }}">
                        Bisnis / B2B
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($historyTasks as $task)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm relative overflow-hidden">
                        
                        <!-- Jalur Warna Status -->
                        <div class="absolute top-0 left-0 bottom-0 w-2 {{ $task->status === 'completed' ? 'bg-emerald-500' : 'bg-red-500' }}"></div>

                        <div class="pl-2">
                            <!-- Header Kartu -->
                            <div class="flex justify-between items-start gap-4 mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-black text-slate-800">{{ $task->user->name }}</span>
                                        
                                        <!-- INDIKATOR BADGE JENIS AKUN -->
                                        @if($task->user->role === 'b2b_user')
                                            <span class="text-[9px] font-black uppercase tracking-widest bg-teal-50 text-teal-700 border border-teal-200 px-2 py-0.5 rounded-md"><i class="fa-solid fa-building text-[8px] mr-0.5"></i> B2B</span>
                                        @else
                                            <span class="text-[9px] font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-md"><i class="fa-solid fa-user text-[8px] mr-0.5"></i> B2C</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-400 block"><i class="fa-regular fa-clock mr-1"></i> Selesai: {{ \Carbon\Carbon::parse($task->updated_at)->format('d M Y - H:i') }}</span>
                                </div>
                                <div>
                                    @if($task->status === 'completed')
                                        <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-md flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> Selesai
                                        </span>
                                    @else
                                        <span class="text-[10px] font-black uppercase tracking-wider bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-md flex items-center gap-1">
                                            <i class="fa-solid fa-xmark"></i> Batal
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Detail Sampah & Poin (Hanya muncul jika Selesai) -->
                            @if($task->status === 'completed')
                                <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl flex justify-between items-center mt-2">
                                    <div class="flex flex-wrap gap-2">
                                        @if($task->weight_plastic > 0) <span class="text-xs text-slate-600 bg-white px-2 py-1 border border-slate-200 rounded-md font-bold text-blue-600" title="Plastik">{{ floatval($task->weight_plastic) }}kg</span> @endif
                                        @if($task->weight_paper > 0) <span class="text-xs text-slate-600 bg-white px-2 py-1 border border-slate-200 rounded-md font-bold text-yellow-600" title="Kertas">{{ floatval($task->weight_paper) }}kg</span> @endif
                                        @if($task->weight_metal > 0) <span class="text-xs text-slate-600 bg-white px-2 py-1 border border-slate-200 rounded-md font-bold text-gray-600" title="Logam">{{ floatval($task->weight_metal) }}kg</span> @endif
                                        @if($task->weight_glass > 0) <span class="text-xs text-slate-600 bg-white px-2 py-1 border border-slate-200 rounded-md font-bold text-teal-600" title="Kaca">{{ floatval($task->weight_glass) }}kg</span> @endif
                                    </div>
                                    <div class="text-right shrink-0 ml-4">
                                        <span class="text-[10px] font-bold text-slate-400 block uppercase">Total Poin</span>
                                        <span class="font-black text-emerald-600">+{{ number_format($task->total_points_earned, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </div>
                        <h4 class="font-black text-slate-800 mb-1">Riwayat Kosong</h4>
                        <p class="text-sm text-slate-500 max-w-xs mx-auto">Tidak ada penjemputan yang sesuai dengan filter ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>