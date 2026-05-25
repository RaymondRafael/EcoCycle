<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle - Ubah Sampah Anorganik Jadi Saldo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased overflow-x-hidden">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="bg-green-100 p-2.5 rounded-xl shadow-sm">
                        <i class="fa-solid fa-recycle text-green-600 text-2xl animate-pulse"></i>
                    </div>
                    <span class="font-black text-2xl text-gray-900 tracking-tight">Eco<span class="text-green-600">Cycle</span></span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#beranda" class="text-gray-600 hover:text-green-600 font-semibold transition">Beranda</a>
                    <a href="#cara-kerja" class="text-gray-600 hover:text-green-600 font-semibold transition">Cara Kerja</a>
                    <a href="#kategori" class="text-gray-600 hover:text-green-600 font-semibold transition">Kategori</a>
                    <a href="#layanan" class="text-gray-600 hover:text-green-600 font-semibold transition">Layanan B2B</a>
                </div>

                <div class="hidden md:flex items-center space-x-5">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 font-semibold hover:text-green-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:text-green-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-full font-bold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-200">Daftar Sekarang</a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-green-600 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
            <div class="px-4 pt-2 pb-6 space-y-2 flex flex-col">
                <a href="#beranda" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50">Beranda</a>
                <a href="#cara-kerja" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50">Cara Kerja</a>
                <a href="#kategori" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50">Kategori</a>
                <a href="#layanan" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50">Layanan B2B</a>
                <hr class="my-2 border-gray-100">
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-3 text-center rounded-md text-base font-medium text-white bg-green-600 hover:bg-green-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-3 text-center rounded-md text-base font-medium text-gray-700 hover:text-green-600 bg-gray-50">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-3 mt-2 text-center rounded-md text-base font-bold text-white bg-green-600 hover:bg-green-700">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-white">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-green-100/50 to-emerald-50/50 blur-3xl opacity-70"></div>
            <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] rounded-full bg-gradient-to-tr from-green-50/50 to-teal-50/50 blur-3xl opacity-70"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                
                <div class="lg:col-span-6 text-center lg:text-left mb-16 lg:mb-0">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 border border-green-200 text-green-700 text-sm font-bold mb-6 shadow-sm">
                        <span class="flex gap-1 text-yellow-400">
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                            <i class="fa-solid fa-star text-xs"></i>
                        </span>
                        Dipercaya oleh 500+ pejuang lingkungan
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-6 tracking-tight">
                        Ubah Sampah Jadi <br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Saldo Digital.</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Layanan penjemputan sampah anorganik terintegrasi untuk area Bandung dan sekitarnya. Setorkan plastik, kardus, dan logam bekasmu, lalu dapatkan poin yang bisa dicairkan ke e-wallet.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg transition shadow-lg hover:shadow-green-600/30 transform hover:-translate-y-1 duration-200 flex justify-center items-center gap-3">
                            <i class="fa-solid fa-truck-fast"></i> Mulai Jadwalkan
                        </a>
                        <a href="#cara-kerja" class="bg-white text-gray-700 border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 px-8 py-4 rounded-full font-bold text-lg transition flex justify-center items-center gap-3">
                            <i class="fa-regular fa-circle-play text-green-600"></i> Cara Kerja
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-2xl bg-gradient-to-tr from-gray-50 to-gray-100 border-2 border-gray-200 shadow-2xl overflow-hidden aspect-[4/3] flex flex-col group">
                        <div class="bg-white px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <div class="mx-auto w-1/2 h-4 bg-gray-100 rounded-full"></div>
                        </div>
                        <div class="flex-1 p-8 flex items-center justify-center bg-gray-50 relative overflow-hidden">
                            <div class="w-full h-full bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col gap-4 relative z-10 transform transition duration-500 group-hover:scale-[1.02]">
                                <div class="w-32 h-6 bg-gray-200 rounded-md"></div>
                                <div class="flex gap-4">
                                    <div class="w-1/2 h-24 bg-green-50 rounded-lg border border-green-100 flex flex-col justify-center px-4 relative overflow-hidden">
                                        <div class="w-16 h-4 bg-green-200 rounded mb-2"></div>
                                        <div class="w-24 h-8 bg-green-600 rounded"></div>
                                        <i class="fa-solid fa-wallet absolute right-2 bottom-2 text-4xl text-green-600/10"></i>
                                    </div>
                                    <div class="w-1/2 h-24 bg-blue-50 rounded-lg border border-blue-100"></div>
                                </div>
                                <div class="w-full h-32 bg-gray-50 rounded-lg border border-gray-100 mt-auto flex items-center justify-center">
                                    <i class="fa-solid fa-chart-line text-5xl text-gray-200"></i>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-50"></div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-4 animate-bounce hover:animate-none transition" style="animation-duration: 3s;">
                        <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center text-green-600">
                            <i class="fa-solid fa-arrow-trend-up text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Transaksi Terakhir</p>
                            <p class="font-black text-gray-900 text-lg">+12.500 Poin</p>
                        </div>
                    </div>

                    <div class="absolute top-10 -right-6 bg-white px-5 py-3 rounded-full shadow-lg border border-gray-100 flex items-center gap-3">
                        <i class="fa-solid fa-recycle text-blue-500 text-xl"></i>
                        <span class="text-sm font-bold text-gray-700">Plastik PET Diterima</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="kategori" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-green-600 font-bold tracking-wider uppercase text-sm">Nilai Tukar</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-2">Apa Saja yang Kami Terima?</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100 hover:border-blue-300 hover:shadow-lg transition">
                    <i class="fa-solid fa-recycle text-4xl text-blue-500 mb-4"></i>
                    <h3 class="font-bold text-gray-900">Plastik PET</h3>
                    <p class="text-green-600 font-bold mt-2">Rp 2.500 / Kg</p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100 hover:border-yellow-300 hover:shadow-lg transition">
                    <i class="fa-solid fa-box-open text-4xl text-yellow-600 mb-4"></i>
                    <h3 class="font-bold text-gray-900">Kardus Bekas</h3>
                    <p class="text-green-600 font-bold mt-2">Rp 1.500 / Kg</p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100 hover:border-gray-400 hover:shadow-lg transition">
                    <i class="fa-solid fa-oil-can text-4xl text-gray-500 mb-4"></i>
                    <h3 class="font-bold text-gray-900">Kaleng Aluminium</h3>
                    <p class="text-green-600 font-bold mt-2">Rp 8.000 / Kg</p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100 hover:border-purple-300 hover:shadow-lg transition">
                    <i class="fa-solid fa-plug text-4xl text-purple-500 mb-4"></i>
                    <h3 class="font-bold text-gray-900">E-Waste Kecil</h3>
                    <p class="text-green-600 font-bold mt-2">Bervariasi</p>
                </div>
                
            </div>
            </div>
    </section>

    <section id="cara-kerja" class="py-24 bg-gray-50 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-green-600 font-bold tracking-wider uppercase text-sm">Proses Sederhana</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-2">Bagaimana EcoCycle Bekerja?</h2>
                <p class="mt-4 text-gray-600 text-lg">Sistem terintegrasi yang mudah, transparan, dan menguntungkan.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-10 text-center relative">
                <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-1 bg-gradient-to-r from-green-200 via-gray-300 to-green-200 -z-10 rounded-full"></div>

                <div class="p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group">
                    <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-green-100 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">1. Pilah Sampah</h3>
                    <p class="text-gray-600 leading-relaxed">Pisahkan sampah anorganik seperti botol plastik, kardus, dan kaleng logam di tempatmu.</p>
                </div>
                <div class="p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">2. Jadwalkan Jemput</h3>
                    <p class="text-gray-600 leading-relaxed">Gunakan web app kami, tentukan estimasi berat, dan pilih jadwal agar mitra kami datang menjemput.</p>
                </div>
                <div class="p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group">
                    <div class="w-20 h-20 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-yellow-100 group-hover:bg-yellow-500 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">3. Dapatkan Poin</h3>
                    <p class="text-gray-600 leading-relaxed">Setelah ditimbang oleh mitra, poin akan otomatis masuk ke akunmu dan siap dicairkan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-24 bg-green-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-5 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdib3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnPmNpcmNsZSBjeD0iMyIgY3k9IjMiIHI9IjMiIGZpbGw9IiNmZmZmZmYiLz48L2c+PC9nPjwvc3ZnPg==')]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <span class="inline-block bg-green-800 text-green-300 px-3 py-1 rounded-full font-bold tracking-wider uppercase text-xs mb-4 border border-green-700">EcoCycle For Business</span>
                <h2 class="text-3xl md:text-5xl font-black mb-6 leading-tight">Solusi Manajemen Limbah untuk Bisnismu</h2>
                <p class="text-green-100 text-lg mb-8 leading-relaxed">
                    Tingkatkan nilai ESG (Environmental, Social, and Governance) perusahaanmu. EcoCycle menyediakan layanan berlangganan khusus untuk Kafe, Restoran, dan Perkantoran.
                </p>
                <ul class="space-y-4 mb-10">
                    <li class="flex items-start gap-4 bg-green-800/40 p-4 rounded-xl border border-green-700/50 hover:bg-green-800/60 transition">
                        <i class="fa-solid fa-truck-clock text-green-400 mt-1 text-xl"></i> 
                        <div>
                            <strong class="block text-white text-lg">Jadwal Prioritas (VIP)</strong>
                            <span class="text-green-200">Penjemputan rutin sesuai jam operasional bisnismu tanpa antre.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 bg-green-800/40 p-4 rounded-xl border border-green-700/50 hover:bg-green-800/60 transition">
                        <i class="fa-solid fa-file-contract text-green-400 mt-1 text-xl"></i> 
                        <div>
                            <strong class="block text-white text-lg">Sustainability Report</strong>
                            <span class="text-green-200">Laporan kontribusi lingkungan bulanan untuk keperluan PR & Branding.</span>
                        </div>
                    </li>
                </ul>
                <a href="#" class="inline-flex items-center gap-2 bg-white text-green-900 hover:bg-green-50 px-8 py-4 rounded-full font-bold transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Konsultasi Bisnis Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="bg-gradient-to-br from-green-800 to-green-950 p-10 rounded-3xl shadow-2xl border border-green-700 relative">
                <div class="absolute -top-6 -right-6 bg-yellow-400 text-yellow-900 font-black py-2 px-6 rounded-full shadow-lg transform rotate-3 border-2 border-yellow-300">
                    ESG Compliant
                </div>
                <div class="flex items-center justify-between mb-8 border-b border-green-700 pb-6">
                    <div>
                        <p class="text-sm text-green-300 font-bold uppercase tracking-wide mb-1">Dampak Klien B2B Kami</p>
                        <p class="text-5xl font-black text-white">2.450 <span class="text-2xl text-green-400 font-bold">Kg CO2</span></p>
                        <p class="text-sm text-green-200 mt-2 bg-green-900 inline-block px-2 py-1 rounded">Emisi karbon berhasil dicegah</p>
                    </div>
                    <div class="w-20 h-20 bg-green-700 rounded-full flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-leaf text-4xl text-green-400"></i>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center text-sm mb-2">
                            <span class="text-green-200 font-medium">Plastik Terdestruksi</span>
                            <span class="text-white font-bold bg-blue-500/20 px-2 py-0.5 rounded text-blue-300">1.2 Ton</span>
                        </div>
                        <div class="w-full bg-green-950 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-3 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center text-sm mb-2">
                            <span class="text-green-200 font-medium">Kertas & Kardus</span>
                            <span class="text-white font-bold bg-yellow-500/20 px-2 py-0.5 rounded text-yellow-300">850 Kg</span>
                        </div>
                        <div class="w-full bg-green-950 rounded-full h-3">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 h-3 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-950 text-gray-400 py-12 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-gray-800 pb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-900 p-2.5 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-recycle text-green-500 text-2xl"></i>
                    </div>
                    <span class="font-black text-2xl text-white tracking-tight">Eco<span class="text-green-500">Cycle</span></span>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fa-brands fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fa-brands fa-github text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fa-solid fa-envelope text-xl"></i></a>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>&copy; 2026 EcoCycle. All rights reserved.</p>
                <p class="font-medium">Tim Pengembang: <span class="text-gray-300">Raymond, Yudi, Najwa, Exalt</span></p>
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = btn.querySelector('i');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            if(menu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        });
    </script>
</body>
</html>