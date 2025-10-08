{{-- layouts/footer.blade.php --}}
@auth
<footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-sm">
  <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
    <p>
      &copy; {{ date('Y') }}
      <span class="font-semibold text-blue-600 dark:text-blue-400">HR Connect</span>.
      All rights reserved.
    </p>

    <div class="flex items-center gap-4 mt-2 md:mt-0">
      <a href="/support" class="hover:text-blue-600 dark:hover:text-blue-400">Support</a>
      <a href="/privacy-policy" class="hover:text-blue-600 dark:hover:text-blue-400">Privacy Policy</a>
      <a href="/terms" class="hover:text-blue-600 dark:hover:text-blue-400">Terms</a>
    </div>
  </div>

  <div class="border-t border-gray-200 dark:border-gray-700 mt-3">
    <div class="flex flex-col md:flex-row justify-center items-center gap-2 py-3 text-xs text-gray-500 dark:text-gray-500">
      <p class="text-center">
        Designed & Developed by
        <span class="font-medium text-blue-600 dark:text-blue-400">SEAVPEAV PECH</span>
      </p>

      <div class="flex items-center gap-3">
        <a href="https://github.com/seavpeavpech24-bot" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400" aria-label="GitHub">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 .5C5.7.5.6 5.6.6 11.9c0 5 3.3 9.3 7.8 10.8.6.1.8-.3.8-.6v-2.1c-3.2.7-3.9-1.5-3.9-1.5-.6-1.5-1.4-1.9-1.4-1.9-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.3 1.8 1.3 1 1.8 2.6 1.3 3.3 1 .1-.7.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.4 1.2-3.3-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.3 11.3 0 0 1 6 0c2.3-1.5 3.3-1.2 3.3-1.2.6 1.6.2 2.8.1 3.1.8.9 1.2 2 1.2 3.3 0 4.5-2.7 5.5-5.3 5.8.4.4.7 1 .7 2v3c0 .3.2.7.8.6a11.6 11.6 0 0 0 7.8-10.8C23.4 5.6 18.3.5 12 .5Z" />
          </svg>
        </a>

        <a href="https://www.linkedin.com/in/seavpeav-pech-557556254/" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400" aria-label="LinkedIn">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14C2.2 0 0 2.2 0 5v14c0 2.8 2.2 5 5 5h14c2.8 0 5-2.2 5-5V5c0-2.8-2.2-5-5-5zM7.1 20.5H3.8V9h3.3v11.5zM5.5 7.5c-1 0-1.8-.8-1.8-1.8S4.5 3.9 5.5 3.9 7.3 4.7 7.3 5.7 6.5 7.5 5.5 7.5zM20.5 20.5h-3.3v-5.6c0-1.3 0-3-1.8-3s-2 1.4-2 2.9v5.7h-3.3V9h3.1v1.6h.1c.4-.7 1.3-1.6 2.7-1.6 2.9 0 3.4 1.9 3.4 4.3v7.2z" />
          </svg>
        </a>
      </div>
    </div>
  </div>
</footer>
@endauth
