<x-app-layout>
    @php
        // Logika Sistem Level B2B (Disesuaikan dengan skala bisnis/harga ribuan)
        $points = Auth::user()->point_balance;
        $currentLevel = 'Mitra Pemula';
        $nextLevel = 'Mitra Penggerak';
        
        // Batas level B2B dinaikkan 10x lipat dari B2C
        $maxPoints = 500000; // Level 1: 500rb poin
        $icon = 'fa-seedling';
        $color = 'bg-amber-100 text-amber-700'; 

        if ($points >= 10000000) { 
            // Level Max (10 Juta Poin)
            $currentLevel = 'Pahlawan Ekonomi Sirkular';
            $nextLevel = 'Maksimal';
            $maxPoints = $points; 
            $icon = 'fa-crown';
            $color = 'bg-purple-100 text-purple-700'; 
        } elseif ($points >= 2500000) { 
            // Level 3 (2,5 Juta Poin)
            $currentLevel = 'Mitra Strategis';
            $nextLevel = 'Pahlawan Ekonomi Sirkular';
            $maxPoints = 10000000;
            $icon = 'fa-medal';
            $color = 'bg-yellow-100 text-yellow-600'; 
        } elseif ($points >= 500000) { 
            // Level 2 (500 Ribu Poin)
            $currentLevel = 'Mitra Penggerak';
            $nextLevel = 'Mitra Strategis';
            $maxPoints = 2500000;
            $icon = 'fa-shield-halved';
            $color = 'bg-gray-200 text-gray-700'; 
        }

        $progressPercentage = ($points >= 10000000) ? 100 : ($points / $maxPoints) * 100;
        $pointsNeeded = ($points >= 10000000) ? 0 : $maxPoints - $points;
    @endphp

    <div class="min-h-screen bg-gray-50 pb-12">
        
        <div class="bg-gradient-to-r from-teal-800 to-emerald-900 pb-24 pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-teal-700/50 text-teal-100 border border-teal-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                <i class="fa-solid fa-shop mr-1"></i> Akun Bisnis / UMKM
                            </span>
                        </div>
                        <h2 class="text-3xl font-black text-white tracking-tight">
                            Halo, {{ Auth::user()->name }}! 
                        </h2>
                        <p class="text-teal-100 mt-1">Pantau kontribusi ESG & manajemen limbah bisnismu hari ini.</p>
                    </div>

                    <div class="w-full lg:w-auto bg-black/20 p-5 rounded-2xl backdrop-blur-md border border-white/10 shadow-xl min-w-[320px]">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-2">
                                <div class="{{ $color }} p-1.5 rounded-full shadow-inner flex items-center justify-center w-8 h-8">
                                    <i class="fa-solid {{ $icon }} text-sm"></i>
                                </div>
                                <span class="text-white font-bold tracking-wide text-sm">Peringkat: {{ $currentLevel }}</span>
                            </div>
                            <span class="text-teal-200 text-xs font-bold">{{ number_format($points, 0, ',', '.') }} Pts</span>
                        </div>
                        
                        <div class="w-full bg-black/40 rounded-full h-2.5 mb-1.5 p-0.5">
                            <div class="bg-gradient-to-r from-teal-400 to-emerald-400 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        
                        <p class="text-[10px] text-teal-100/80 text-right uppercase tracking-widest font-bold">
                            @if($pointsNeeded > 0)
                                {{ number_format($pointsNeeded, 0, ',', '.') }} poin lagi ke {{ $nextLevel }}
                            @else
                                Kontribusi Maksimal Dicapai 🎉
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden flex flex-col justify-center">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-teal-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Total Kas Hasil Daur Ulang</p>
                            <h3 class="text-4xl sm:text-5xl font-black text-gray-900 mb-2">Rp {{ number_format(Auth::user()->point_balance, 0, ',', '.') }}<span class="text-xl text-gray-400 font-medium">,00</span></h3>
                            <p class="text-sm text-teal-600 font-bold bg-teal-50 inline-block px-3 py-1 rounded-full border border-teal-100">
                                <i class="fa-solid fa-chart-line"></i> Akumulasi saldo bisnis
                            </p>
                        </div>
                        <div class="w-full sm:w-auto flex flex-col gap-3">
                            <a href="{{ route('pickup.create') }}" class="w-full bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-teal-600/30 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-truck"></i> Jadwalkan Armada
                            </a>
                            <button onclick="window.location.href='{{ route('withdrawals.create') }}'" class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-building-columns text-teal-600"></i> Tarik Dana
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 shadow-xl relative overflow-hidden text-white flex flex-col justify-center border border-gray-700">
                    <div class="absolute -bottom-10 -right-10 text-9xl text-white opacity-5 transform -rotate-12">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <p class="text-gray-400 font-medium mb-4 relative z-10">Dampak ESG Perusahaan</p>
                    
                    <div class="space-y-4 relative z-10">
                        <div>
                            <div class="flex items-end gap-2">
                                <h3 class="text-3xl font-black text-teal-400">0</h3>
                                <span class="text-sm text-gray-400 font-medium mb-1">Kg</span>
                            </div>
                            <p class="text-xs text-gray-500">Limbah Terkelola</p>
                        </div>
                        <div class="w-full h-px bg-gray-700"></div>
                        <div>
                            <div class="flex items-end gap-2">
                                <h3 class="text-3xl font-black text-emerald-400">0</h3>
                                <span class="text-sm text-gray-400 font-medium mb-1">Kg CO₂</span>
                            </div>
                            <p class="text-xs text-gray-500">Jejak Karbon Direduksi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-teal-600 to-emerald-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-teal-200/50 text-white mb-8 flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 text-8xl text-white opacity-10 transform rotate-12 pointer-events-none">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                
                <div class="relative z-10 text-center sm:text-left">
                    <h4 class="font-black text-2xl mb-1 flex items-center justify-center sm:justify-start gap-2">
                        <i class="fa-solid fa-handshake"></i> Program Afiliasi Bisnis
                    </h4>
                    <p class="text-teal-50 text-sm md:text-base max-w-lg">Ajak rekan bisnis atau UMKM lain untuk mengelola limbah di EcoCycle. Dapatkan bonus <strong class="text-yellow-300">+5000 Poin</strong> untuk setiap akun yang aktif menggunakan kodemu.</p>
                </div>

                <div class="relative z-10">
                    <div class="bg-white/20 backdrop-blur-md border border-white/40 pl-6 pr-2 py-2 rounded-2xl flex items-center gap-4 group cursor-pointer hover:bg-white/30 transition shadow-inner" onclick="navigator.clipboard.writeText('{{ Auth::user()->referral_code ?? 'BELUM-ADA' }}'); alert('Kode Referal Bisnis berhasil disalin!');">
                        <span class="font-black tracking-widest text-2xl drop-shadow-md">
                            {{ Auth::user()->referral_code ?? 'BELUM-ADA' }}
                        </span>
                        <div class="bg-white text-teal-700 w-10 h-10 rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition">
                            <i class="fa-regular fa-copy"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-center text-teal-100 mt-2 uppercase font-bold tracking-wider">Klik untuk salin kode</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('history.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Riwayat Logistik</h4>
                </a>
                
                <a href="{{ route('leaderboard') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-orange-50 text-orange-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Papan Peringkat</h4>
                </a>
                
                <a href="{{ route('b2b.csr') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Laporan CSR</h4>
                </a>
                
                <a href="{{ route('address.edit') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Alamat Saya</h4>
                </a>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Manajemen Logistik Terakhir</h3>
                    <a href="{{ route('history.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700">Kelola Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentPickups as $pickup)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0
                                    {{ $pickup->status == 'completed' ? 'bg-teal-100 text-teal-600' : '' }}
                                    {{ $pickup->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $pickup->status == 'on_the_way' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $pickup->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}
                                ">
                                    @if($pickup->status == 'completed') <i class="fa-solid fa-check"></i>
                                    @elseif($pickup->status == 'pending') <i class="fa-solid fa-hourglass-half"></i>
                                    @elseif($pickup->status == 'on_the_way') <i class="fa-solid fa-truck"></i>
                                    @else <i class="fa-solid fa-xmark"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Manajemen Armada Logistik</h4>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($pickup->status == 'pending')
                                    <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md">Menunggu</span>
                                @elseif($pickup->status == 'on_the_way')
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">Di Jalan</span>
                                @elseif($pickup->status == 'completed')
                                    <span class="text-sm font-black text-teal-600">+{{ number_format($pickup->total_points_earned, 0, ',', '.') }} Kas</span>
                                @else
                                    <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md">Batal</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-4 border-2 border-dashed border-gray-100 rounded-2xl">
                            <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-dolly text-3xl text-gray-300"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum ada jadwal armada</h4>
                            <p class="text-gray-500 max-w-md mx-auto text-sm mb-6">Tingkatkan efisiensi pengelolaan limbah bisnismu dengan layanan penjemputan skala besar kami.</p>
                            <a href="{{ route('pickup.create') }}" class="inline-block mt-2 bg-teal-50 text-teal-700 hover:bg-teal-100 px-6 py-2.5 rounded-full font-bold transition text-sm">
                                Buat Jadwal Baru
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>