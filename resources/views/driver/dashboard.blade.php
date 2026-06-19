<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-900 leading-tight flex items-center gap-3">
            <div class="bg-slate-900 p-2 rounded-xl text-white text-base">
                <i class="fa-solid fa-route"></i>
            </div>
            {{ __('Manifest Penjemputan Kurir') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 text-sm font-bold shadow-sm">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(!empty($waypointsString))
                <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-4 border border-blue-500/30 relative overflow-hidden">
                    
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full blur-3xl opacity-10 -mr-10 -mt-10"></div>
                    
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-2xl backdrop-blur-sm shrink-0">
                            <i class="fa-solid fa-satellite-dish text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-lg">GMaps Route Optimization</h3>
                            <p class="text-blue-100 text-sm mt-0.5">Sistem akan melacak lokasimu saat ini dan menyusun rute penjemputan paling efisien secara otomatis.</p>
                        </div>
                    </div>

                    <button onclick="getMyRoute('{{ $waypointsString }}', '{{ $destinationString }}')" id="btnRoute" class="relative z-10 shrink-0 bg-white text-blue-700 hover:bg-blue-50 px-6 py-3 rounded-xl font-black text-sm transition shadow-md flex items-center justify-center gap-2 w-full md:w-auto">
                        <i class="fa-solid fa-location-crosshairs"></i> Mulai Navigasi
                    </button>
                </div>
            @endif
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Daftar Tugas Hari Ini</h3>
                    <p class="text-xs text-slate-500">Selesaikan penjemputan sesuai dengan rute dan jadwal pelanggan.</p>
                </div>
                
                <div class="bg-white p-1 rounded-xl border border-slate-200 flex gap-1 self-start sm:self-auto shadow-sm">
                    <a href="{{ route('driver.dashboard') }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ !request()->query('type') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua ({{ \App\Models\Pickup::whereIn('status', ['pending', 'on_the_way'])->count() }})
                    </a>
                    <a href="{{ route('driver.dashboard', ['type' => 'b2c']) }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ request()->query('type') === 'b2c' ? 'bg-green-600 text-white shadow-sm' : 'text-slate-600 hover:text-green-600' }}">
                        Personal / B2C
                    </a>
                    <a href="{{ route('driver.dashboard', ['type' => 'b2b']) }}" 
                       class="px-4 py-2 rounded-lg text-xs font-black transition-all {{ request()->query('type') === 'b2b' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-teal-600' }}">
                        Bisnis / B2B
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($tasks as $task)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm relative overflow-hidden transition-all duration-200">
                        
                        <div class="absolute top-0 left-0 bottom-0 w-2 {{ $task->status === 'on_the_way' ? 'bg-blue-500' : 'bg-amber-500' }}"></div>

                        <div class="pl-2">
                            <div class="flex justify-between items-start gap-4 mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-black text-slate-800 text-base leading-tight">{{ $task->user->name }}</span>
                                        
                                        @if($task->user->role === 'b2b_user')
                                            <span class="text-[9px] font-black uppercase tracking-widest bg-teal-50 text-teal-700 border border-teal-200 px-2 py-0.5 rounded-md"><i class="fa-solid fa-building text-[8px] mr-0.5"></i> B2B</span>
                                        @else
                                            <span class="text-[9px] font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-md"><i class="fa-solid fa-user text-[8px] mr-0.5"></i> B2C</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] uppercase font-black tracking-wider text-slate-400 block">Jadwal Kedatangan</span>
                                    <span class="text-sm font-bold text-slate-700"><i class="fa-regular fa-clock mr-1 text-slate-400"></i> {{ \Carbon\Carbon::parse($task->pickup_date)->format('d M Y - H:i') }}</span>
                                </div>
                                <div>
                                    @if($task->status === 'pending')
                                        <span class="text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-md">Menunggu</span>
                                    @else
                                        <span class="text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-md">Di Jalan</span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl mb-4">
                                <span class="text-[10px] uppercase font-black tracking-wider text-slate-400 block mb-1">Titik Lokasi Pelanggan</span>
                                <p class="text-xs text-slate-700 font-medium leading-relaxed mb-3">
                                    {{ $task->pickup_address }}
                                </p>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-200/60">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($task->pickup_address) }}" 
                                       target="_blank" 
                                       class="bg-white hover:bg-blue-50 text-blue-600 hover:text-blue-700 font-bold py-2 px-3 rounded-xl text-xs transition border border-slate-200 hover:border-blue-200 shadow-sm flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-map-location-dot text-sm text-blue-500"></i> Buka Maps
                                    </a>

                                    @php
                                        // Bersihkan string nomor dan ubah format 08 menjadi 62 secara aman
                                        $phoneRaw = $task->user->phone ?? '';
                                        $phoneCleaned = preg_replace('/[^0-9]/', '', $phoneRaw);
                                        if (str_starts_with($phoneCleaned, '0')) {
                                            $phoneCleaned = '62' . substr($phoneCleaned, 1);
                                        }
                                        
                                        // Template pesan teks otomatis kurir menuju lokasi
                                        $waMessage = "Halo " . $task->user->name . ", saya kurir EcoCycle sedang dalam perjalanan menuju lokasi Anda untuk melakukan penjemputan sampah anorganik. Mohon ditunggu ya!";
                                    @endphp
                                    
                                    @if(!empty($phoneCleaned))
                                        <a href="https://wa.me/{{ $phoneCleaned }}?text={{ urlencode($waMessage) }}" 
                                           target="_blank" 
                                           class="bg-white hover:bg-emerald-50 text-emerald-600 hover:text-emerald-700 font-bold py-2 px-3 rounded-xl text-xs transition border border-slate-200 hover:border-emerald-200 shadow-sm flex items-center justify-center gap-1.5">
                                            <i class="fa-brands fa-whatsapp text-base text-emerald-500"></i> Hubungi WA
                                        </a>
                                    @else
                                        <button disabled class="bg-gray-50 text-gray-400 font-bold py-2 px-3 rounded-xl text-xs border border-gray-200 opacity-60 flex items-center justify-center gap-1.5 cursor-not-allowed" title="Nomor HP Pelanggan tidak terdaftar">
                                            <i class="fa-solid fa-phone-slash text-sm"></i> No WA Kosong
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-end items-center gap-2 pt-2 border-t border-slate-100">
                                @if($task->status === 'pending')
                                    <form action="{{ route('driver.pickup.updateStatus', $task->id) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="on_the_way">
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black px-5 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-gas-pump"></i> Mulai Menuju Lokasi
                                        </button>
                                    </form>
                                @elseif($task->status === 'on_the_way')
                                    <form action="{{ route('driver.pickup.updateStatus', $task->id) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" onclick="return confirm('Batalkan penjemputan ini karena kendala lapangan?')" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold px-4 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-1">
                                            Gagal Jangkau
                                        </button>
                                    </form>

                                    <a href="{{ route('driver.pickup.weigh', $task->id) }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-black px-6 py-2.5 rounded-xl text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-weight-scale"></i> Selesai & Timbang Sampah
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </div>
                        <h4 class="font-black text-slate-800 mb-1">Tidak Ada Tugas</h4>
                        <p class="text-sm text-slate-500 max-w-xs mx-auto">Tidak ditemukan jadwal penjemputan aktif untuk kategori filter ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <script>
        function getMyRoute(waypoints, destination) {
            const btn = document.getElementById('btnRoute');
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Mencari Lokasi...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            // Cek apakah browser/HP mendukung fitur GPS
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Jika izin lokasi diberikan, ambil Latitude & Longitude kurir
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const origin = lat + ',' + lng; // Format asal: lat,lng

                        // Perbaikan: Menggunakan Format Universal Cross-Platform Google Maps
                        // Format ini dipastikan berjalan mulus di browser PC maupun aplikasi Google Maps HP
                        const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&waypoints=${waypoints}`;
                        
                        // Buka Google Maps di tab/aplikasi baru
                        window.open(mapsUrl, '_blank');
                        
                        // Kembalikan tombol ke wujud semula
                        btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Mulai Navigasi';
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }, 
                    function(error) {
                        // Jika kurir menolak izin lokasi atau GPS mati
                        alert('Gagal mendapatkan lokasi. Pastikan GPS menyala dan izinkan browser mengakses lokasi Anda.');
                        btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Mulai Navigasi';
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    },
                    { enableHighAccuracy: true } // Minta akurasi GPS paling tinggi
                );
            } else {
                alert('Browser HP Anda tidak mendukung pelacakan lokasi.');
                btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Mulai Navigasi';
                btn.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        }
    </script>
</x-app-layout>