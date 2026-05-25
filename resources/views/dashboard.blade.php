<x-app-layout>
    @php
        $points = Auth::user()->point_balance;
        $currentLevel = 'Pemula';
        $nextLevel = 'Penggerak';
        
        // LEVEL BARU: Diperbesar agar sesuai dengan harga poin ribuan
        $maxPoints = 50000; 
        $icon = 'fa-seedling';
        $color = 'bg-amber-100 text-amber-700'; // Nuansa Bronze

        if ($points >= 1000000) { 
            // Level Max (1 Juta Poin / Setara ~1 Ton Sampah)
            $currentLevel = 'Pahlawan Bumi';
            $nextLevel = 'Maksimal';
            $maxPoints = $points; // Bar penuh
            $icon = 'fa-crown';
            $color = 'bg-purple-100 text-purple-700'; // Nuansa Diamond/Platinum
        } elseif ($points >= 250000) { 
            // Level 3 (250 Ribu Poin)
            $currentLevel = 'Penyelamat';
            $nextLevel = 'Pahlawan Bumi';
            $maxPoints = 1000000;
            $icon = 'fa-medal';
            $color = 'bg-yellow-100 text-yellow-600'; // Nuansa Gold
        } elseif ($points >= 50000) { 
            // Level 2 (50 Ribu Poin)
            $currentLevel = 'Penggerak';
            $nextLevel = 'Penyelamat';
            $maxPoints = 250000;
            $icon = 'fa-shield-halved';
            $color = 'bg-gray-200 text-gray-700'; // Nuansa Silver
        }

        // Hitung persentase bar
        $progressPercentage = ($points >= 1000000) ? 100 : ($points / $maxPoints) * 100;
        // Hitung sisa poin
        $pointsNeeded = ($points >= 1000000) ? 0 : $maxPoints - $points;
    @endphp

    <div class="min-h-screen bg-gray-50 pb-12">
        
        <div class="bg-gradient-to-r from-green-700 to-green-900 pb-24 pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight">
                            Halo, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-green-200 mt-1">Siap menyelamatkan bumi hari ini?</p>
                    </div>
                    
                    <div class="w-full md:w-auto bg-white/10 p-5 rounded-2xl backdrop-blur-md border border-white/20 shadow-lg min-w-[320px]">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-2">
                                <div class="{{ $color }} p-1.5 rounded-full shadow-inner flex items-center justify-center w-8 h-8">
                                    <i class="fa-solid {{ $icon }} text-sm"></i>
                                </div>
                                <span class="text-white font-bold tracking-wide">Level: {{ $currentLevel }}</span>
                            </div>
                            <span class="text-green-100 text-xs font-bold">{{ number_format($points, 0, ',', '.') }} / {{ number_format($maxPoints, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="w-full bg-black/30 rounded-full h-3 mb-1.5 shadow-inner p-0.5">
                            <div class="bg-gradient-to-r from-yellow-400 to-yellow-300 h-2 rounded-full shadow-md transition-all duration-1000 ease-out" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        
                        @if($pointsNeeded > 0)
                            <p class="text-xs text-green-100 text-right"><strong class="text-yellow-300">{{ number_format($pointsNeeded, 0, ',', '.') }} poin</strong> lagi menuju {{ $nextLevel }}! 🚀</p>
                        @else
                            <p class="text-xs text-yellow-300 text-right font-bold">Level Maksimal! Kamu luar biasa! 🎉</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Total Saldo Aktif</p>
                            <h3 class="text-4xl sm:text-5xl font-black text-gray-900 mb-2">{{ number_format(Auth::user()->point_balance, 0, ',', '.') }} <span class="text-xl text-gray-400 font-medium">Poin</span></h3>
                            <p class="text-sm text-green-600 font-bold bg-green-50 inline-block px-3 py-1 rounded-full border border-green-100">
                                <i class="fa-solid fa-arrow-trend-up"></i> Setara Rp {{ number_format(Auth::user()->point_balance, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-full sm:w-auto flex flex-col gap-3">
                            <a href="{{ route('pickup.create') }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-truck-fast"></i> Jemput Sampah
                            </a>
                            <a href="{{ route('withdrawals.create') }}" class="w-full text-center bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-money-bill-transfer text-green-600"></i> Tarik Saldo
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-800 to-green-900 rounded-3xl p-8 shadow-xl relative overflow-hidden text-white flex flex-col justify-center">
                    <div class="absolute -bottom-10 -right-10 text-9xl text-white opacity-5 transform -rotate-12">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <p class="text-green-200 font-medium mb-4 relative z-10">Dampak Lingkunganmu</p>
                    <div class="flex items-end gap-3 relative z-10">
                        <h3 class="text-5xl font-black">0</h3>
                        <span class="text-xl text-green-300 font-medium mb-1">Kg</span>
                    </div>
                    <p class="text-sm text-green-100 mt-2 relative z-10">Sampah berhasil didaur ulang</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl p-6 md:p-8 shadow-xl shadow-green-200/50 text-white mb-8 flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 text-8xl text-white opacity-10 transform rotate-12 pointer-events-none">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                
                <div class="relative z-10 text-center sm:text-left">
                    <h4 class="font-black text-2xl mb-1 flex items-center justify-center sm:justify-start gap-2">
                        <i class="fa-solid fa-users"></i> Ajak Teman, Dapat Poin!
                    </h4>
                    <p class="text-green-100 text-sm md:text-base max-w-lg">Bagikan kode referal ini ke temanmu. Kamu akan langsung mendapatkan <strong class="text-yellow-300">+5000 Poin</strong> setiap ada pendaftar baru yang menggunakan kodemu.</p>
                </div>

                <div class="relative z-10">
                    <div class="bg-white/20 backdrop-blur-md border border-white/40 pl-6 pr-2 py-2 rounded-2xl flex items-center gap-4 group cursor-pointer hover:bg-white/30 transition shadow-inner" onclick="navigator.clipboard.writeText('{{ Auth::user()->referral_code ?? 'BELUM-ADA' }}'); alert('Hore! Kode Referal berhasil disalin!');">
                        <span class="font-black tracking-widest text-2xl drop-shadow-md">
                            {{ Auth::user()->referral_code ?? 'BELUM-ADA' }}
                        </span>
                        <div class="bg-white text-green-600 w-10 h-10 rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 group-hover:bg-green-50 transition">
                            <i class="fa-regular fa-copy"></i>
                        </div>
                    </div>
                    <p class="text-xs text-center text-green-100 mt-2 opacity-80">Klik kode untuk menyalin</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('history.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-history"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Riwayat</h4>
                </a>
                
                <a href="{{ route('leaderboard') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-amber-50 text-amber-500 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Leaderboard</h4>
                </a>

                <a href="{{ route('address.edit') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Alamat Saya</h4>
                </a>
                
                <a href="{{ route('withdrawals.create') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Tukar Poin</h4>
                </a>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Aktivitas Terakhir</h3>
                    <a href="{{ route('history.index') }}" class="text-sm font-bold text-green-600 hover:text-green-700">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentPickups as $pickup)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0
                                    {{ $pickup->status == 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ $pickup->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $pickup->status == 'on_the_way' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $pickup->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}
                                ">
                                    @if($pickup->status == 'completed') <i class="fa-solid fa-check"></i>
                                    @elseif($pickup->status == 'pending') <i class="fa-solid fa-hourglass-half"></i>
                                    @elseif($pickup->status == 'on_the_way') <i class="fa-solid fa-truck-fast"></i>
                                    @else <i class="fa-solid fa-xmark"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Penjemputan Sampah</h4>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($pickup->status == 'pending')
                                    <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md">Menunggu</span>
                                @elseif($pickup->status == 'on_the_way')
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">Di Jalan</span>
                                @elseif($pickup->status == 'completed')
                                    <span class="text-sm font-black text-green-600">+{{ number_format($pickup->total_points_earned, 0, ',', '.') }} Pts</span>
                                @else
                                    <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md">Batal</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-4">
                            <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum ada aktivitas</h4>
                            <p class="text-gray-500 max-w-sm mx-auto">Mulai kumpulkan sampah anorganikmu dan jadwalkan penjemputan pertamamu sekarang!</p>
                            <a href="{{ route('pickup.create') }}" class="inline-block mt-6 bg-green-100 text-green-700 hover:bg-green-200 px-6 py-2.5 rounded-full font-bold transition">
                                Jadwalkan Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>