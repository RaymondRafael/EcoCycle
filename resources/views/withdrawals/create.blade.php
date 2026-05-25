<x-app-layout>
    @php
        $isB2B = Auth::user()->role === 'b2b_user';
        $themeColor = $isB2B ? 'teal' : 'green';
    @endphp

    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-{{ $themeColor }}-100 p-2 rounded-xl">
                <i class="fa-solid fa-money-bill-transfer text-{{ $themeColor }}-600"></i>
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
                
                <div class="bg-gradient-to-br from-{{ $themeColor }}-700 to-{{ $themeColor }}-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute -bottom-10 -right-10 text-8xl text-white opacity-5">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <p class="text-{{ $themeColor }}-200 text-sm font-medium mb-1">Saldo yang Bisa Dicairkan</p>
                    <h3 class="text-3xl font-black mb-2">
                        {{ number_format(Auth::user()->point_balance, 0, ',', '.') }} 
                        <span class="text-sm font-normal text-{{ $themeColor }}-200">{{ $isB2B ? 'Poin' : 'Pts' }}</span>
                    </h3>
                    <div class="w-full h-px bg-white/20 my-4"></div>
                    <p class="text-xs text-{{ $themeColor }}-100 leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1 text-yellow-300"></i> 
                        Nilai konversi berlaku kelipatan 1:1 (1 Poin = Rp 1). Batas minimal penarikan adalah <strong>10.000 Poin</strong>.
                    </p>
                </div>

                <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <form action="{{ route('withdrawals.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="payment_method" class="block font-bold text-gray-700 mb-2">Metode Pencairan <span class="text-red-500">*</span></label>
                            <select id="payment_method" name="payment_method" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-{{ $themeColor }}-500 focus:border-{{ $themeColor }}-500 transition">
                                <option value="" disabled selected>-- Pilih E-Wallet / Bank --</option>
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="GOPAY">GoPay</option>
                                <option value="LINKAJA">LinkAja</option>
                                <option value="BANK BCA">Bank BCA</option>
                                <option value="BANK MANDIRI">Bank Mandiri</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="account_number" class="block font-bold text-gray-700 mb-2">No. Rekening / No. HP <span class="text-red-500">*</span></label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" required
                                    class="block w-full border-gray-200 rounded-xl text-sm focus:ring-{{ $themeColor }}-500 focus:border-{{ $themeColor }}-500 transition" placeholder="Contoh: 0812xxxx / 73123xxx">
                                <x-input-error :messages="$errors->get('account_number')" class="mt-2 text-red-600 text-sm" />
                            </div>

                            <div>
                                <label for="account_name" class="block font-bold text-gray-700 mb-2">Nama Pemilik Rekening <span class="text-red-500">*</span></label>
                                <input type="text" id="account_name" name="account_name" value="{{ old('account_name') }}" required
                                    class="block w-full border-gray-200 rounded-xl text-sm focus:ring-{{ $themeColor }}-500 focus:border-{{ $themeColor }}-500 transition" placeholder="Sesuai kartu / aplikasi">
                                <x-input-error :messages="$errors->get('account_name')" class="mt-2 text-red-600 text-sm" />
                            </div>
                        </div>

                        <div>
                            <label for="amount_points" class="block font-bold text-gray-700 mb-2">Jumlah Poin yang Dicairkan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" id="amount_points" name="amount_points" value="{{ old('amount_points') }}" required
                                    class="block w-full pr-16 border-gray-200 rounded-xl text-sm focus:ring-{{ $themeColor }}-500 focus:border-{{ $themeColor }}-500 transition" placeholder="Minimal 10000" oninput="calculateCashout(this.value)">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm font-bold">Poin</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('amount_points')" class="mt-2 text-red-600 text-sm" />
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Uang tunai yang akan diterima:</span>
                            <span id="cash_preview" class="text-xl font-black text-{{ $themeColor }}-600">Rp 0</span>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-{{ $themeColor }}-600 hover:bg-{{ $themeColor }}-700 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-{{ $themeColor }}-600/20 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Ajukan Pencairan Sekarang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function calculateCashout(val) {
            const preview = document.getElementById('cash_preview');
            if(!val || val < 0) {
                preview.innerText = "Rp 0";
                return;
            }
            // Format angka menjadi mata uang Rupiah standar Indonesia
            const formatted = new Intl.NumberFormat('id-ID').format(val);
            preview.innerText = "Rp " + formatted;
        }
    </script>
</x-app-layout>