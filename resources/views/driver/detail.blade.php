<x-app-layout>
    @php
        $phone = $pickup->user->phone ?? '';
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        
        $waMessage = urlencode("Halo " . $pickup->user->name . ", saya driver EcoCycle sedang menuju ke lokasi Anda untuk melakukan penjemputan sampah.");
    @endphp

    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-900 pb-24 pt-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
                <a href="{{ route('driver.dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white w-10 h-10 rounded-full flex items-center justify-center transition border border-white/15">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">
                        Detail Penjemputan 📋
                    </h2>
                    <p class="text-blue-200 mt-1">Lakukan verifikasi, timbang sampah, dan selesaikan tugas Anda</p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            @if(session('success'))
                <div class="mb-6 bg-green-500 text-white p-4 rounded-2xl font-bold shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500 text-white p-4 rounded-2xl font-bold shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-red-500 text-white p-4 rounded-2xl font-bold shadow-lg">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-user text-blue-600"></i> Info Pelanggan
                        </h3>
                        @php
                            $statusText = '';
                            $statusClass = '';
                            if ($pickup->status == 'completed') {
                                $statusText = 'Selesai';
                                $statusClass = 'bg-green-100 text-green-700 border border-green-200';
                            } elseif ($pickup->status == 'cancelled') {
                                $statusText = 'Dibatalkan';
                                $statusClass = 'bg-red-100 text-red-700 border border-red-200';
                            } elseif ($pickup->status == 'on_the_way') {
                                $statusText = 'Sedang Menuju Lokasi';
                                $statusClass = 'bg-blue-100 text-blue-700 border border-blue-200';
                            } elseif ($pickup->status == 'pending') {
                                if ($pickup->driver_id === null) {
                                    $statusText = 'Menunggu Driver';
                                    $statusClass = 'bg-green-100 text-green-700 border border-green-200';
                                } else {
                                    $statusText = 'Tugas Diambil';
                                    $statusClass = 'bg-yellow-100 text-yellow-700 border border-yellow-200';
                                }
                            }
                        @endphp
                        <span class="text-xs font-black px-3 py-1 rounded-full {{ $statusClass }}">
                            Status: {{ $statusText }}
                        </span>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Nama Pelanggan</p>
                            <p class="text-gray-900 font-extrabold text-lg mt-0.5">{{ $pickup->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Alamat Lengkap</p>
                            <p class="text-gray-800 font-medium text-sm mt-0.5 leading-relaxed">
                                <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> {{ $pickup->pickup_address }}
                            </p>
                        </div>
                        @if($pickup->user->phone)
                            <div>
                                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Nomor WhatsApp</p>
                                <p class="text-gray-800 font-semibold text-sm mt-0.5">
                                    <i class="fa-brands fa-whatsapp text-green-500 mr-1"></i> {{ $pickup->user->phone }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 border-t border-gray-100 pt-6">
                        @if($phone)
                            <a href="https://wa.me/{{ $phone }}?text={{ $waMessage }}" target="_blank" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold text-xs py-3.5 rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-green-100">
                                <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi WhatsApp
                            </a>
                        @endif
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($pickup->pickup_address) }}" target="_blank" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3.5 rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-blue-100">
                            <i class="fa-solid fa-map-location-dot"></i> Google Maps
                        </a>
                        <a href="https://waze.com/ul?q={{ urlencode($pickup->pickup_address) }}" target="_blank" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-xs py-3.5 rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-indigo-100">
                            <i class="fa-brands fa-waze"></i> Navigasi Waze
                        </a>
                    </div>
                </div>

                @if($pickup->status === 'on_the_way' && $pickup->driver_id === Auth::id())
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 flex items-center gap-2 mb-6">
                            <i class="fa-solid fa-weight-scale text-blue-600"></i> Modul Penimbangan & Foto Validasi
                        </h3>

                        <form action="{{ route('driver.verify', $pickup->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-4 mb-6">
                                <label class="block text-gray-700 font-bold mb-2">Timbang Sampah per Kategori (dalam Kg)</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($categories as $cat)
                                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 flex items-center justify-between gap-4">
                                            <div>
                                                <h4 class="font-extrabold text-gray-800 text-sm mb-0.5">{{ $cat->name }}</h4>
                                                <p class="text-xs text-gray-400">
                                                    Tarif: {{ number_format($pickup->user->role === 'b2b_user' ? $cat->price_to_factory_per_kg : $cat->point_reward_per_kg) }} Pts/Kg
                                                </p>
                                            </div>
                                            <div class="relative w-28 shrink-0">
                                                <input type="number" step="0.01" min="0" name="weights[{{ $cat->id }}]" value="0" class="w-full bg-white border border-gray-300 rounded-xl px-3 py-2 text-right font-black text-gray-800 focus:outline-none focus:border-blue-500 pr-8">
                                                <span class="absolute right-3 top-2.5 text-xs font-bold text-gray-400">Kg</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-bold mb-2">
                                    <i class="fa-solid fa-camera mr-1"></i> Upload Foto Validasi Sampah <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 hover:border-blue-500 transition rounded-2xl p-6 text-center cursor-pointer relative" onclick="document.getElementById('photoInput').click();">
                                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(this);">
                                    <div id="uploadPlaceholder">
                                        <i class="fa-regular fa-image text-4xl text-gray-300 mb-2"></i>
                                        <p class="text-sm font-bold text-gray-600">Klik untuk memilih foto sampah</p>
                                        <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG (Maks 5MB)</p>
                                    </div>
                                    <div id="imagePreviewContainer" class="hidden">
                                        <img id="imagePreview" src="#" class="max-h-48 mx-auto rounded-lg shadow" alt="Preview">
                                        <p class="text-xs font-bold text-blue-600 mt-2">Klik untuk mengganti foto</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-gray-700 font-bold mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="driver_notes" rows="2" class="w-full border border-gray-300 rounded-2xl p-4 font-medium text-sm text-gray-800 focus:outline-none focus:border-blue-500" placeholder="Tambahkan catatan khusus dari lapangan jika ada..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black text-sm py-4 rounded-2xl transition flex items-center justify-center gap-2 shadow-lg shadow-green-100">
                                <i class="fa-solid fa-circle-check text-lg"></i> Selesai Dijemput & Kirim Poin
                            </button>
                        </form>
                    </div>

                @elseif($pickup->status === 'pending' && $pickup->driver_id === Auth::id())
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 flex items-center gap-2 mb-6">
                            <i class="fa-solid fa-truck-fast text-blue-600"></i> Mulai Penjemputan
                        </h3>
                        <p class="text-gray-500 text-sm mb-6">Klik tombol di bawah ini jika Anda sudah siap dan sedang dalam perjalanan menuju lokasi pelanggan.</p>
                        <form action="{{ route('driver.start', $pickup->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-sm py-4 rounded-2xl transition flex items-center justify-center gap-2 shadow-lg shadow-blue-100">
                                <i class="fa-solid fa-truck-fast"></i> Mulai Menuju Lokasi
                            </button>
                        </form>
                    </div>
                @endif

                @if(in_array($pickup->status, ['pending', 'on_the_way']) && $pickup->driver_id === Auth::id())
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                        <h3 class="text-lg font-black text-red-600 flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-triangle-exclamation"></i> Laporkan Kendala / Masalah Lapangan
                        </h3>
                        <p class="text-gray-500 text-sm mb-4">Laporkan jika armada Anda rusak, alamat tidak ditemukan, atau pelanggan tidak ada di rumah untuk membatalkan tugas secara aman.</p>

                        <form action="{{ route('driver.report', $pickup->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="reason" rows="2" class="w-full border border-gray-300 rounded-2xl p-4 font-medium text-sm text-gray-800 focus:outline-none focus:border-red-500" placeholder="Tuliskan alasan lengkap kendala lapangan..." required></textarea>
                            </div>
                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs px-5 py-3 rounded-xl transition flex items-center gap-1.5">
                                <i class="fa-solid fa-ban"></i> Laporkan Masalah & Batalkan
                            </button>
                        </form>
                    </div>
                @elseif($pickup->driver_id === null)
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 flex items-center gap-2 mb-6">
                            <i class="fa-solid fa-hand-holding-hand text-green-600"></i> Ambil Tugas Penjemputan
                        </h3>
                        <p class="text-gray-500 text-sm mb-6">Tugas ini belum diambil oleh driver manapun. Ambil sekarang jika Anda siap menjemput!</p>

                        <form action="{{ route('driver.claim', $pickup->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black text-sm py-4 rounded-2xl transition flex items-center justify-center gap-2 shadow-lg shadow-green-100">
                                <i class="fa-solid fa-check"></i> Ambil Tugas Ini
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
