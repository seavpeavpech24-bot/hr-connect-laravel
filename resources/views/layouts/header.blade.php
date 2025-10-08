{{-- layouts/header.blade.php --}}
<header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-3 bg-white dark:bg-gray-900 shadow-sm transition-colors duration-300">
  <div class="text-xl font-bold text-blue-600 dark:text-blue-400">
    <a href="/">HR Connect</a>
  </div>

  <!-- Show if user is logged in -->
  @auth
    <div id="user-menu-container" class="relative">
      <button id="user-toggle" aria-haspopup="true" aria-expanded="false"
              class="flex items-center space-x-3 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate max-w-32">
          {{ Auth::user()->full_name }}
        </span>
        <div class="w-8 h-8 bg-blue-600 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
          <img id="#" src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : '/images/default-avatar.jpg' }}" alt="avatar" class="w-full h-full object-cover">
        </div>
      </button>

      <!-- Dropdown Menu -->
      <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg hidden z-50">
        <a href="/settings" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Settings</a>
        <a href="/support" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Support</a>
        <form method="POST" action="/logout" class="block">
          @csrf
          <button type="submit" class="w-full px-4 py-2 text-left text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
            Logout
          </button>
        </form>
      </div>
    </div>
  @endauth

  <!-- Show if user is not logged in -->
  @guest
    <div class="flex items-center gap-4">
      <a href="/login" class="text-sm text-gray-700 dark:text-gray-200 hover:text-blue-600">Login</a>
      <a href="/register" class="text-sm text-white bg-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-700 transition">Register</a>
    </div>
  @endguest
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('user-toggle');
  const dropdown = document.getElementById('user-dropdown');

  if (toggleBtn && dropdown) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isHidden = dropdown.classList.contains('hidden');
      dropdown.classList.toggle('hidden');
      toggleBtn.setAttribute('aria-expanded', String(!isHidden));
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('#user-menu-container')) {
        dropdown.classList.add('hidden');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }
});
</script>
