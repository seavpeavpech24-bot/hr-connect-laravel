{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- << Synchronous theme initializer — put BEFORE CSS/Vite to avoid FOUC >> -->
  <script>
    (function() {
      try {
        const saved = localStorage.getItem('theme'); // "light" | "dark" | "system" | null
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (saved === 'dark' || (saved === 'system' && prefersDark) || (!saved && prefersDark)) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      } catch (e) {
        // ignore
      }
    })();
  </script>

  <script src="https://cdn.tailwindcss.com"></script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-800 dark:text-gray-100 transition-colors duration-300">
  {{-- Header --}}
  @include('layouts.header')

  <div class="flex flex-1 pt-16"> {{-- pt-16 assumes header height ~4rem --}}
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main Content Area --}}
    <div class="flex flex-col flex-1 ml-64">
      <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
      </main>

      {{-- Footer --}}
      @include('layouts.footer')
    </div>
  </div>
</body>
</html>
