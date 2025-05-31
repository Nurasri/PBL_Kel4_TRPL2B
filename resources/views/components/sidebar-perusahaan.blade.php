<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
  style="{{ request()->routeIs('perusahaan.dashboard') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2"
    href="{{ route('perusahaan.dashboard') }}"
    :title="isSidebarCollapsed ? 'Dashboard' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Dashboard</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('laporan-harian.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('laporan-harian.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('laporan-harian.index') }}"
    :title="isSidebarCollapsed ? 'Laporan Harian' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Laporan Harian</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('penyimpanan.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('penyimpanan.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('penyimpanan.index') }}"
    :title="isSidebarCollapsed ? 'Penyimpanan' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Penyimpanan</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
  style="{{ request()->routeIs('#') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2"
    href="#"
    :title="isSidebarCollapsed ? 'Pengelolaan Limbah' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Pengelolaan Limbah</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2"
    href="#"
    :title="isSidebarCollapsed ? 'Laporan Hasil Pengolahan' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707v11a2 2 0 01-2 2z"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Laporan Hasil Pengolahan</span>
  </a>
</li>