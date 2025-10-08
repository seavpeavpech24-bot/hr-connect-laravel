{{-- layouts/sidebar.blade.php --}}
@auth
<aside id="sidebar"
  class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-gray-900 dark:text-gray-200 w-64 shadow-md hidden md:flex flex-col justify-between transition-colors duration-300">

  {{-- Top Section --}}
  <div>
    <div class="p-4 border-b dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-900 z-10">
      <h2 class="text-xl font-bold text-blue-600 dark:text-blue-400">Menu</h2>
    </div>

    <nav class="p-4 space-y-2">
      <a href="/"
        class="block px-4 py-2 rounded font-medium 
          {{ request()->is('/') ? 'bg-blue-100 text-blue-600 dark:bg-gray-800 dark:text-blue-400' : 'hover:bg-blue-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200' }}">
        Dashboard
      </a>

      <a href="/applicants"
        class="block px-4 py-2 rounded font-medium 
          {{ request()->is('applicants') ? 'bg-blue-100 text-blue-600 dark:bg-gray-800 dark:text-blue-400' : 'hover:bg-blue-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200' }}">
        Applicants
      </a>

      <a href="/messages"
        class="block px-4 py-2 rounded font-medium 
          {{ request()->is('messages') ? 'bg-blue-100 text-blue-600 dark:bg-gray-800 dark:text-blue-400' : 'hover:bg-blue-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200' }}">
        Messages
      </a>

      <a href="/history"
        class="block px-4 py-2 rounded font-medium 
          {{ request()->is('history') ? 'bg-blue-100 text-blue-600 dark:bg-gray-800 dark:text-blue-400' : 'hover:bg-blue-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200' }}">
        History
      </a>
    </nav>
  </div>

  {{-- Bottom Section --}}
  <div class="p-4 border-t dark:border-gray-700 space-y-2">
    <a href="/settings"
      class="block px-4 py-2 rounded font-medium 
        {{ request()->is('settings') ? 'bg-blue-100 text-blue-600 dark:bg-gray-800 dark:text-blue-400' : 'hover:bg-blue-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200' }}">
      Settings
    </a>

    <form method="POST" action="/logout">
      @csrf
      <button type="submit"
        class="w-full text-left block px-4 py-2 rounded font-medium 
          hover:bg-blue-50 dark:hover:bg-gray-800 text-red-600 dark:text-red-400 transition">
        Log out
      </button>
    </form>
  </div>
</aside>
@endauth
