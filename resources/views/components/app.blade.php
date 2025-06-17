<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'EcoCycle' }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden" x-data="data()">
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
