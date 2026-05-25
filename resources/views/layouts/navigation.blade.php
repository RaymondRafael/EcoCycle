<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.location.href='{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}'">
                    <div class="bg-green-100 p-2.5 rounded-xl shadow-sm">
                        <i class="fa-solid fa-recycle text-green-600 text-xl"></i>
                    </div>
                    <span class="font-black text-2xl text-gray-900 tracking-tight hidden sm:block">Eco<span class="text-green-600">Cycle</span></span>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-base font-bold transition {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-300' }}">
                            {{ __('Admin Panel') }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-base font-bold transition {{ request()->routeIs('dashboard') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-300' }}">
                            {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('history.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-base font-bold transition {{ request()->routeIs('history.index') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-300' }}">
                            {{ __('Riwayat') }}
                        </a>
                        <a href="{{ route('leaderboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-base font-bold transition {{ request()->routeIs('leaderboard') ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-amber-600 hover:border-amber-300' }}">
                            <i class="fa-solid fa-trophy mr-1"></i> {{ __('Leaderboard') }}
                        </a>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-bold rounded-full text-gray-700 bg-gray-50 hover:bg-green-50 hover:border-green-200 hover:text-green-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="w-6 h-6 rounded-full {{ Auth::user()->role === 'admin' ? 'bg-gray-800 text-white' : 'bg-green-200 text-green-700' }} flex items-center justify-center mr-2">
                                <i class="fa-solid {{ Auth::user()->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} text-xs"></i>
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 bg-white">
                            <p class="text-sm text-gray-500">Masuk sebagai</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="hover:text-green-600 hover:bg-green-50 font-medium flex items-center gap-2 bg-white">
                            <i class="fa-solid fa-gear w-4 text-center"></i> {{ __('Pengaturan Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 hover:text-red-700 font-bold flex items-center gap-2 border-t border-gray-100 bg-white">
                                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-green-600 hover:bg-green-50 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 font-bold text-base transition {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-green-600 bg-green-50' : 'border-transparent text-gray-600 hover:text-green-600 hover:bg-green-50 hover:border-green-300' }}">
                    <i class="fa-solid fa-user-shield mr-2"></i> {{ __('Admin Panel') }}
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 font-bold text-base transition {{ request()->routeIs('dashboard') ? 'border-green-500 text-green-600 bg-green-50' : 'border-transparent text-gray-600 hover:text-green-600 hover:bg-green-50 hover:border-green-300' }}">
                    <i class="fa-solid fa-house mr-2"></i> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('history.index') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 font-bold text-base transition {{ request()->routeIs('history.index') ? 'border-green-500 text-green-600 bg-green-50' : 'border-transparent text-gray-600 hover:text-green-600 hover:bg-green-50 hover:border-green-300' }}">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> {{ __('Riwayat') }}
                </a>
                <a href="{{ route('leaderboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 font-bold text-base transition {{ request()->routeIs('leaderboard') ? 'border-amber-500 text-amber-600 bg-amber-50' : 'border-transparent text-gray-600 hover:text-amber-600 hover:bg-amber-50 hover:border-amber-300' }}">
                    <i class="fa-solid fa-trophy mr-2 text-amber-500"></i> {{ __('Leaderboard') }}
                </a>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-100 bg-gray-50">
            <div class="px-4 flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full {{ Auth::user()->role === 'admin' ? 'bg-gray-800 text-white' : 'bg-green-200 text-green-700' }} flex items-center justify-center">
                    <i class="fa-solid {{ Auth::user()->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} text-lg"></i>
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-medium flex items-center gap-2 hover:text-green-600 hover:bg-green-100">
                    <i class="fa-solid fa-gear w-5 text-center"></i> {{ __('Pengaturan Profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold flex items-center gap-2 hover:bg-red-100 border-t border-gray-200 mt-2">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>