<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-green-100 p-2 rounded-xl">
                <i class="fa-solid fa-user-gear text-green-600"></i>
            </div>
            {{ __('Pengaturan Akun') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-gray-200/40 border border-gray-100 sm:rounded-3xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-green-50 rounded-full blur-3xl -mr-10 -mt-10 opacity-60 transition duration-500 group-hover:bg-green-100"></div>
                
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-gray-200/40 border border-gray-100 sm:rounded-3xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50 rounded-full blur-3xl -mr-10 -mt-10 opacity-60 transition duration-500 group-hover:bg-blue-100"></div>
                
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if(Auth::user()->role !== 'admin')
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-gray-200/40 border border-red-50 sm:rounded-3xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-red-50 rounded-full blur-3xl -mr-10 -mt-10 opacity-60 transition duration-500 group-hover:bg-red-100"></div>
                
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endif
            
        </div>
    </div>
</x-app-layout>