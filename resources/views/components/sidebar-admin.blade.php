<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
  style="{{ request()->routeIs('admin.dashboard') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('admin.dashboard') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('admin.dashboard') }}"
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
  style="{{ request()->routeIs('admin.users.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('admin.users.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('admin.users.index') }}"
    :title="isSidebarCollapsed ? 'Manajemen User' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Manajemen User</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
  style="{{ request()->routeIs('admin.perusahaan.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2 {{ request()->routeIs('admin.perusahaan.*') ? 'text-green-700 font-bold bg-green-100 dark:bg-green-900' : '' }}"
    href="{{ route('admin.perusahaan.index') }}"
    :title="isSidebarCollapsed ? 'Perusahaan' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Perusahaan</span>
  </a>
</li>

<li class="relative px-4 py-3">
  <span x-cloak class="absolute inset-y-0 left-0 w-1 bg-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"
  style="{{ request()->routeIs('admin.jenis-limbah.*') ? '' : 'display:none;' }}"></span>
  <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md px-2 py-2"
    href="{{ route('admin.jenis-limbah.index') }}"
    :title="isSidebarCollapsed ? 'Jenis Limbah' : ''">
    <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
      stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
      <path d="M20 7l-8-4-8 4m16 0l-8 4</path>
    </svg>
    <span x-show="!isSidebarCollapsed" x-transition class="ml-4">Jenis Limbah</span>
  </a>
</li>