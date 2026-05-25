<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-emerald-100 p-2 rounded-xl">
                    <i class="fa-solid fa-file-contract text-emerald-600"></i>
                </div>
                {{ __('Laporan Dampak CSR') }}
            </div>
            <button onclick="window.print()" class="print:hidden bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-print"></i> Cetak Dokumen
            </button>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen print:bg-white print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-none sm:rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-14 print:shadow-none print:border-none print:p-0">
                
                <div class="flex justify-between items-center border-b-2 border-gray-900 pb-8 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="bg-teal-100 p-3 rounded-2xl">
                            <i class="fa-solid fa-recycle text-teal-600 text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="font-black text-3xl text-gray-900 tracking-tight">Eco<span class="text-teal-600">Cycle</span></h1>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest">Sustainability Report</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">Periode: {{ now()->format('Y') }}</p>
                        <p class="text-xs text-gray-500">Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mb-10 bg-gray-50 p-6 rounded-2xl border border-gray-100 print:bg-white print:border-gray-300">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Diberikan Kepada:</p>
                    <h2 class="text-2xl font-black text-gray-900">{{ $user->name }}</h2>
                    <div class="mt-2 text-sm text-gray-600 flex flex-col gap-1">
                        <p><i class="fa-solid fa-envelope w-5"></i> {{ $user->email }}</p>
                        <p><i class="fa-solid fa-phone w-5"></i> {{ $user->phone ?? '-' }}</p>
                        <p><i class="fa-solid fa-map-pin w-5"></i> {{ $user->address ?? 'Alamat belum dilengkapi' }}, {{ $user->city ?? 'Bandung' }}</p>
                    </div>
                </div>

                <div class="mb-10 text-gray-700 leading-relaxed text-justify">
                    <p>
                        Sertifikat dan laporan ini diterbitkan sebagai bentuk apresiasi dan bukti sah atas komitmen <strong>{{ $user->name }}</strong> dalam menjalankan program <em>Corporate Social Responsibility</em> (CSR) di bidang pelestarian lingkungan hidup dan penerapan prinsip ekonomi sirkular bersama platform EcoCycle.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <div class="border-2 border-teal-100 bg-teal-50/30 rounded-2xl p-6 text-center print:border-gray-300 print:bg-white">
                        <i class="fa-solid fa-globe text-3xl text-teal-600 mb-3"></i>
                        <h4 class="text-4xl font-black text-gray-900 mb-1">{{ number_format($wasteManagedKg, 1, ',', '.') }} <span class="text-lg text-gray-500 font-medium">Kg</span></h4>
                        <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Total Limbah Terkelola</p>
                    </div>
                    
                    <div class="border-2 border-emerald-100 bg-emerald-50/30 rounded-2xl p-6 text-center print:border-gray-300 print:bg-white">
                        <i class="fa-solid fa-leaf text-3xl text-emerald-600 mb-3"></i>
                        <h4 class="text-4xl font-black text-gray-900 mb-1">{{ number_format($carbonReducedKg, 1, ',', '.') }} <span class="text-lg text-gray-500 font-medium">Kg</span></h4>
                        <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Reduksi Jejak Karbon (CO₂)</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-2xl overflow-hidden mb-12">
                    <table class="w-full text-left">
                        <tr class="border-b border-gray-200 bg-gray-50 print:bg-gray-100">
                            <th class="p-4 text-sm font-bold text-gray-700 uppercase tracking-wider">Detail Operasional</th>
                            <th class="p-4 text-sm font-bold text-gray-700 uppercase tracking-wider text-right">Akumulasi</th>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="p-4 text-gray-600 font-medium">Total Ritase Penjemputan Armada</td>
                            <td class="p-4 text-right font-black text-gray-900">{{ $totalPickups }} Kali</td>
                        </tr>
                        <tr>
                            <td class="p-4 text-gray-600 font-medium">Akumulasi Nilai Ekonomi Sirkular</td>
                            <td class="p-4 text-right font-black text-gray-900">Rp {{ number_format($totalPointsEarned, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="flex justify-end pt-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-16">{{ $user->city ?? 'Bandung' }}, {{ now()->format('d F Y') }}</p>
                        <p class="font-black text-gray-900 border-b border-gray-900 pb-1 px-4 inline-block">Administrator EcoCycle</p>
                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest">Digital Signature Validated</p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>

    <style>
        @media print {
            body { background-color: white !important; }
            nav, header { display: none !important; }
            @page { margin: 0; }
        }
    </style>
</x-app-layout>