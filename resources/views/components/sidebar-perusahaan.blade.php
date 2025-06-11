<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('perusahaan.dashboard') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('perusahaan.dashboard') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('perusahaan.dashboard') }}" :title="isSidebarCollapsed ? 'Dashboard' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path
        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
      </path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Dashboard</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('jenis-limbah.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('jenis-limbah.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('jenis-limbah.index') }}" :title="isSidebarCollapsed ? 'Referensi Jenis Limbah' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Referensi Jenis Limbah</span>
  </a>
</li>
<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('vendor*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('vendor.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('vendor.index') }}" :title="isSidebarCollapsed ? 'Daftar Vendor' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Daftar Vendor</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('laporan-harian.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('laporan-harian.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('laporan-harian.index') }}" :title="isSidebarCollapsed ? 'Laporan Harian' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path
        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
      </path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Laporan Harian</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="{{ request()->routeIs('penyimpanan.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('penyimpanan.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('penyimpanan.index') }}">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Penyimpanan</span>
  </a>
</li>

<li class="relative px-6 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="display:none;"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
    href="#">
    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Pengelolaan Limbah</span>
  </a>
</li>

<li class="relative px-6 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
    style="display:none;"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
    href="#">
    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Laporan Hasil Pengolahan</span>
  </a>
</li>