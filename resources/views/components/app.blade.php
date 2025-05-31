<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" x-init="initTheme()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'EcoCycle - Pengelolaan Limbah GRI 306' }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('resource/css/app.css') }}" />
    @endif
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
    <!-- Custom Alpine Init -->
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    
    <!-- Chart.js for dashboard -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
  </head>
  <body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
      <!-- Sidebar -->
      <x-sidebar />
      
      <!-- Main Content Area -->
      <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Header -->
        <x-header />
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-800">
          <div class="container px-6 mx-auto py-6">
            {{ $slot }}
          </div>
        </main>
        
        <!-- Footer -->
        <x-footer />
      </div>
    </div>
    
    <!-- Backdrop for mobile sidebar -->
    <div x-show="isSideMenuOpen" 
         x-transition:enter="transition ease-in-out duration-150"
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in-out duration-150" 
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center md:hidden"
         @click="closeSideMenu">
    </div>
    
    @stack('scripts')
  </body>
</html>
