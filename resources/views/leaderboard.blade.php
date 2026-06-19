<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-amber-100 p-2 rounded-xl">
                <i class="fa-solid fa-trophy text-amber-500"></i>
            </div>
            {{ __('Papan Peringkat EcoCycle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="{ activeTab: '{{ $currentUser->role === 'b2b_user' ? 'b2b' : 'b2c' }}' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-900 rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden mb-8 text-white flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500 rounded-full blur-3xl -mr-20 -mt-20 opacity-20"></div>
                <div class="relative z-10 text-center md:text-left">
                    <p class="text-gray-400 font-medium mb-1">Peringkat Kamu Saat Ini</p>
                    <h3 class="text-2xl font-bold">
                        Kategori {{ $currentUser->role === 'b2b_user' ? 'Bisnis / UMKM' : 'Personal' }}
                    </h3>
                </div>
                <div class="relative z-10 flex items-center gap-4 bg-white/10 p-4 rounded-2xl border border-white/20 backdrop-blur-sm">
                    <div class="w-14 h-14 bg-amber-500 rounded-full flex items-center justify-center text-2xl shadow-lg">
                        🏆
                    </div>
                    <div>
                        <p class="text-xs text-amber-200 font-bold uppercase tracking-widest mb-0.5">Rank</p>
                        <h4 class="text-4xl font-black">#{{ $currentUserRank }}</h4>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mb-8 relative z-20">
                <div class="bg-white p-1.5 rounded-full shadow-sm border border-gray-100 inline-flex">
                    <button @click="activeTab = 'b2c'" :class="{ 'bg-green-600 text-white shadow-md': activeTab === 'b2c', 'text-gray-500 hover:text-green-600': activeTab !== 'b2c' }" class="px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300">
                        <i class="fa-solid fa-user mr-2"></i> Pahlawan Personal
                    </button>
                    <button @click="activeTab = 'b2b'" :class="{ 'bg-teal-600 text-white shadow-md': activeTab === 'b2b', 'text-gray-500 hover:text-teal-600': activeTab !== 'b2b' }" class="px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300">
                        <i class="fa-solid fa-shop mr-2"></i> Mitra Bisnis
                    </button>
                </div>
            </div>

            <!-- TAB B2C (PERSONAL) -->
            <div x-show="activeTab === 'b2c'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                    <div class="bg-green-50/50 p-6 border-b border-gray-100 text-center">
                        <h3 class="font-black text-xl text-gray-900">Top 10 Pejuang Lingkungan</h3>
                        <p class="text-sm text-gray-500 mt-1">Kategori Pengguna Rumah Tangga & Personal</p>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($topB2CUsers as $index => $user)
                            <div class="p-4 sm:p-6 flex items-center justify-between hover:bg-gray-50 transition {{ $user->id === $currentUser->id ? 'bg-green-50/30' : '' }}">
                                <div class="flex items-center gap-4 sm:gap-6">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-black text-lg shrink-0
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-600 shadow-sm border border-yellow-200' : '' }}
                                        {{ $index === 1 ? 'bg-gray-200 text-gray-600 shadow-sm border border-gray-300' : '' }}
                                        {{ $index === 2 ? 'bg-orange-100 text-orange-700 shadow-sm border border-orange-200' : '' }}
                                        {{ $index > 2 ? 'bg-gray-50 text-gray-400 font-bold' : '' }}
                                    ">
                                        @if($index === 0) 🥇
                                        @elseif($index === 1) 🥈
                                        @elseif($index === 2) 🥉
                                        @else {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-base sm:text-lg flex items-center gap-2">
                                            @php
                                                // Logika Sensor Nama B2C
                                                $name = trim($user->name);
                                                $len = strlen($name);
                                                
                                                if ($user->id === $currentUser->id) {
                                                    // Jika ini akun yang sedang login, tampilkan nama penuh
                                                    $displayName = $name;
                                                } else {
                                                    // Jika akun orang lain, lakukan sensor
                                                    if ($len > 3) {
                                                        $displayName = substr($name, 0, 2) . str_repeat('*', $len - 3) . substr($name, -1);
                                                    } elseif ($len === 3) {
                                                        $displayName = substr($name, 0, 1) . '*' . substr($name, -1);
                                                    } else {
                                                        $displayName = substr($name, 0, 1) . str_repeat('*', $len > 1 ? $len - 1 : 1);
                                                    }
                                                }
                                            @endphp
                                            
                                            {{ $displayName }}

                                            @if($user->id === $currentUser->id)
                                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-md uppercase tracking-wider">Anda</span>
                                            @endif
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5">Bergabung sejak {{ $user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-black text-green-600 text-lg sm:text-xl">{{ number_format($user->point_balance, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-400 block font-bold">POIN</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500">
                                Belum ada data pengguna di kategori ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- TAB B2B (BISNIS) -->
            <div x-show="activeTab === 'b2b'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                    <div class="bg-teal-50/50 p-6 border-b border-gray-100 text-center">
                        <h3 class="font-black text-xl text-gray-900">Top 10 Penggerak Ekonomi Sirkular</h3>
                        <p class="text-sm text-gray-500 mt-1">Kategori Perusahaan, Restoran & UMKM</p>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($topB2BUsers as $index => $user)
                            <div class="p-4 sm:p-6 flex items-center justify-between hover:bg-gray-50 transition {{ $user->id === $currentUser->id ? 'bg-teal-50/30' : '' }}">
                                <div class="flex items-center gap-4 sm:gap-6">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-black text-lg shrink-0
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-600 shadow-sm border border-yellow-200' : '' }}
                                        {{ $index === 1 ? 'bg-gray-200 text-gray-600 shadow-sm border border-gray-300' : '' }}
                                        {{ $index === 2 ? 'bg-orange-100 text-orange-700 shadow-sm border border-orange-200' : '' }}
                                        {{ $index > 2 ? 'bg-gray-50 text-gray-400 font-bold' : '' }}
                                    ">
                                        @if($index === 0) 🥇
                                        @elseif($index === 1) 🥈
                                        @elseif($index === 2) 🥉
                                        @else {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-base sm:text-lg flex items-center gap-2">
                                            @php
                                                // Logika Sensor Nama B2B
                                                $name = trim($user->name);
                                                $len = strlen($name);
                                                
                                                if ($user->id === $currentUser->id) {
                                                    // Jika ini akun yang sedang login, tampilkan nama penuh
                                                    $displayName = $name;
                                                } else {
                                                    // Jika akun orang lain, lakukan sensor
                                                    if ($len > 3) {
                                                        $displayName = substr($name, 0, 2) . str_repeat('*', $len - 3) . substr($name, -1);
                                                    } elseif ($len === 3) {
                                                        $displayName = substr($name, 0, 1) . '*' . substr($name, -1);
                                                    } else {
                                                        $displayName = substr($name, 0, 1) . str_repeat('*', $len > 1 ? $len - 1 : 1);
                                                    }
                                                }
                                            @endphp
                                            
                                            {{ $displayName }}

                                            @if($user->id === $currentUser->id)
                                                <span class="bg-teal-100 text-teal-700 text-[10px] px-2 py-0.5 rounded-md uppercase tracking-wider">Bisnis Anda</span>
                                            @endif
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5"><i class="fa-solid fa-map-pin mr-1"></i> {{ Str::limit($user->city ?? 'Bandung', 15) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-black text-teal-600 text-lg sm:text-xl">{{ number_format($user->point_balance, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-400 block font-bold">POIN KAS</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500">
                                Belum ada data UMKM di kategori ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>