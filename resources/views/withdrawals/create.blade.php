<x-app-layout>
    @php
        $isB2B = Auth::user()->role === 'b2b_user';
        
        // PERBAIKAN: Menulis class Tailwind secara utuh agar terbaca oleh JIT Compiler
        $iconBg = $isB2B ? 'bg-teal-100' : 'bg-green-100';
        $iconText = $isB2B ? 'text-teal-600' : 'text-green-600';
        
        $cardGrad = $isB2B ? 'from-teal-700 to-teal-900' : 'from-green-700 to-green-900';
        $cardTextLight = $isB2B ? 'text-teal-200' : 'text-green-200';
        $cardTextLighter = $isB2B ? 'text-teal-100' : 'text-green-100';
        
        $inputFocus = $isB2B ? 'focus:ring-teal-500 focus:border-teal-500' : 'focus:ring-green-500 focus:border-green-500';
        $previewText = $isB2B ? 'text-teal-600' : 'text-green-600';
        $btnTheme = $isB2B ? 'bg-teal-600 hover:bg-teal-700 shadow-teal-600/20' : 'bg-green-600 hover:bg-green-700 shadow-green-600/20';
        
        // Custom warna hover untuk dropdown agar sesuai tema akun
        $dropdownHover = $isB2B ? 'hover:bg-teal-50 hover:text-teal-700' : 'hover:bg-green-50 hover:text-green-700';
        $dropdownRing = $isB2B ? 'focus:ring-teal-500 focus:border-teal-500 ring-teal-500 border-teal-500' : 'focus:ring-green-500 focus:border-green-500 ring-green-500 border-green-500';
    @endphp

    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="{{ $iconBg }} p-2 rounded-xl">
                <i class="fa-solid fa-money-bill-transfer {{ $iconText }}"></i>
            </div>
            {{ $isB2B ? __('Penarikan Dana Kas') : __('Tukar Poin Saldo') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                
                <div class="bg-gradient-to-br {{ $cardGrad }} rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute -bottom-10 -right-10 text-8xl text-white opacity-5">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <p class="{{ $cardTextLight }} text-sm font-medium mb-1">Saldo yang Bisa Dicairkan</p>
                    <h3 class="text-3xl font-black mb-2">
                        {{ number_format(Auth::user()->point_balance, 0, ',', '.') }} 
                        <span class="text-sm font-normal {{ $cardTextLight }}">{{ $isB2B ? 'Poin' : 'Pts' }}</span>
                    </h3>
                    <div class="w-full h-px bg-white/20 my-4"></div>
                    <p class="text-xs {{ $cardTextLighter }} leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1 text-yellow-300"></i> 
                        Nilai konversi berlaku kelipatan 1:1 (1 Poin = Rp 1). Batas minimal penarikan adalah <strong>10.000 Poin</strong>.
                    </p>
                </div>

                <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <form action="{{ route('withdrawals.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block font-bold text-gray-700 mb-2">Metode Pencairan <span class="text-red-500">*</span></label>
                            
                            <!-- CUSTOM DROPDOWN UI -->
                            <div class="relative" id="customDropdown">
                                <!-- Input tersembunyi yang akan dikirim ke server -->
                                <input type="text" id="payment_method" name="payment_method" required class="sr-only" value="{{ old('payment_method') }}">
                                
                                <!-- Tombol Dropdown -->
                                <button type="button" id="dropdownBtn" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 text-sm text-left flex items-center justify-between transition focus:outline-none focus:ring-2 focus:ring-offset-1 {{ $dropdownRing }} shadow-sm">
                                    <div id="dropdownSelected" class="text-gray-500 font-medium">
                                        -- Pilih E-Wallet / Bank --
                                    </div>
                                    <i id="dropdownIcon" class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                                </button>

                                <!-- Menu Dropdown -->
                                <div id="dropdownMenu" class="absolute z-20 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] opacity-0 invisible transition-all duration-200 transform origin-top -translate-y-2 overflow-hidden">
                                    
                                    <div class="p-2 text-xs font-bold tracking-widest text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">Dompet Digital</div>
                                    <ul class="max-h-60 overflow-y-auto">
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="DANA">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">DANA</span>
                                        </li>
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="OVO">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">OVO</span>
                                        </li>
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="GOPAY">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">GoPay</span>
                                        </li>
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="LINKAJA">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">LinkAja</span>
                                        </li>
                                        
                                        <div class="p-2 text-xs font-bold tracking-widest text-gray-400 uppercase bg-gray-50/50 border-y border-gray-100">Transfer Bank</div>
                                        
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="BANK BCA">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-building-columns"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">Bank BCA</span>
                                        </li>
                                        <li class="dropdown-item px-4 py-3 cursor-pointer flex items-center gap-3 transition {{ $dropdownHover }}" data-value="BANK MANDIRI">
                                            <div class="item-icon w-8 h-8 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-building-columns"></i>
                                            </div>
                                            <span class="item-text font-bold text-gray-700">Bank Mandiri</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END CUSTOM DROPDOWN UI -->
                            
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="account_number" class="block font-bold text-gray-700 mb-2">No. Rekening / No. HP <span class="text-red-500">*</span></label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" required
                                    class="block w-full border-gray-200 rounded-xl px-4 py-3.5 text-sm {{ $inputFocus }} transition" placeholder="Contoh: 0812xxxx / 73123xxx">
                                <x-input-error :messages="$errors->get('account_number')" class="mt-2 text-red-600 text-sm" />
                            </div>

                            <div>
                                <label for="account_name" class="block font-bold text-gray-700 mb-2">Nama Pemilik Rekening <span class="text-red-500">*</span></label>
                                <input type="text" id="account_name" name="account_name" value="{{ old('account_name') }}" required
                                    class="block w-full border-gray-200 rounded-xl px-4 py-3.5 text-sm {{ $inputFocus }} transition" placeholder="Sesuai kartu / aplikasi">
                                <x-input-error :messages="$errors->get('account_name')" class="mt-2 text-red-600 text-sm" />
                            </div>
                        </div>

                        <div>
                            <label for="amount_points" class="block font-bold text-gray-700 mb-2">Jumlah Poin yang Dicairkan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" id="amount_points" name="amount_points" value="{{ old('amount_points') }}" required
                                    class="block w-full px-4 py-3.5 pr-16 border-gray-200 rounded-xl text-sm {{ $inputFocus }} transition" placeholder="Minimal 10000" oninput="calculateCashout(this.value)">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm font-bold">Poin</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('amount_points')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 flex justify-between items-center mt-2">
                            <span class="text-sm font-medium text-gray-500">Uang tunai yang akan diterima:</span>
                            <span id="cash_preview" class="text-xl font-black {{ $previewText }}">Rp 0</span>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full {{ $btnTheme }} text-white font-bold py-4 rounded-xl transition shadow-lg flex items-center justify-center gap-2 text-base">
                                <i class="fa-solid fa-paper-plane"></i> Ajukan Pencairan Sekarang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Kalkulasi Rupiah
        function calculateCashout(val) {
            const preview = document.getElementById('cash_preview');
            if(!val || val < 0) {
                preview.innerText = "Rp 0";
                return;
            }
            const formatted = new Intl.NumberFormat('id-ID').format(val);
            preview.innerText = "Rp " + formatted;
        }

        // Logika Interaktif Custom Dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownContainer = document.getElementById('customDropdown');
            const dropdownBtn = document.getElementById('dropdownBtn');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownIcon = document.getElementById('dropdownIcon');
            const dropdownSelected = document.getElementById('dropdownSelected');
            const hiddenInput = document.getElementById('payment_method');
            const items = document.querySelectorAll('.dropdown-item');

            // Buka/Tutup Menu saat tombol diklik
            dropdownBtn.addEventListener('click', function() {
                const isExpanded = dropdownMenu.classList.contains('opacity-100');
                
                if(isExpanded) {
                    closeDropdown();
                } else {
                    dropdownMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                    dropdownMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                    dropdownIcon.classList.add('rotate-180');
                    dropdownBtn.classList.add('border-gray-400');
                }
            });

            // Logika saat memilih item dompet/bank
            items.forEach(item => {
                item.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('.item-text').innerText;
                    const iconHtml = this.querySelector('.item-icon').outerHTML;

                    // Update nilai input form yang akan di-submit
                    hiddenInput.value = value;

                    // Ubah tampilan teks tombol
                    dropdownSelected.innerHTML = `
                        <div class="flex items-center gap-3">
                            ${iconHtml}
                            <span class="font-bold text-gray-900">${text}</span>
                        </div>
                    `;
                    
                    closeDropdown();
                });
            });

            // Tutup Dropdown
            function closeDropdown() {
                dropdownMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                dropdownIcon.classList.remove('rotate-180');
                dropdownBtn.classList.remove('border-gray-400');
            }

            // Klik di luar area untuk menutup dropdown
            document.addEventListener('click', function(event) {
                if (!dropdownContainer.contains(event.target)) {
                    closeDropdown();
                }
            });
        });
    </script>
</x-app-layout>