@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 text-gray-700 dark:text-gray-300">

  <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Terms of Service</h1>

  <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

  <p class="mb-6">
    Welcome to <strong>HR Connect</strong>. These Terms of Service (“Terms”) govern your use of this application.
    By using HR Connect, you agree to comply with and be bound by these Terms.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">1. License and Usage</h2>
  <p class="mb-6">
    HR Connect is an <strong>open-source project</strong> available for free on GitHub.
    You are permitted to clone, modify, and use this application for personal, educational, or commercial purposes
    without any licensing fee. Proper attribution to the original developer is appreciated but not mandatory.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">2. Developer Support and Fees</h2>
  <p class="mb-6">
    The software itself is free to use. However, if you require assistance such as:
  </p>

  <ul class="list-disc pl-6 mb-6 space-y-2">
    <li>Bug fixing or troubleshooting</li>
    <li>Adding or updating features</li>
    <li>Technical consultation or setup help</li>
  </ul>

  <p class="mb-6">
    A <strong>minimum service fee of $5</strong> will apply for developer support, depending on the task’s complexity.
    Payment is required before any service work begins.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">3. Data Responsibility</h2>
  <p class="mb-6">
    All data you create within HR Connect is stored <strong>locally</strong> in a SQLite database on your own device.
    The developer does not collect, store, or have access to any of your personal or business data.
    You are fully responsible for managing and backing up your local data.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">4. Disclaimer of Warranties</h2>
  <p class="mb-6">
    HR Connect is provided on an <strong>“as is”</strong> and <strong>“as available”</strong> basis without warranties of any kind,
    either expressed or implied. The developer makes no guarantees regarding the reliability, performance,
    or suitability of the software for any specific purpose.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">5. Limitation of Liability</h2>
  <p class="mb-6">
    In no event shall the developer, <strong>SEAVPEAV PECH</strong>, be held liable for any damages arising from
    the use or inability to use HR Connect — including, but not limited to, data loss, system failure,
    or business interruptions.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">6. Support Contact</h2>
  <p class="mb-4">
    If you need support or would like to request a paid service, you can reach the developer privately.
  </p>

  <!-- Contact button -->
  <button 
    onclick="document.getElementById('contact-info').classList.toggle('hidden')" 
    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
    Contact Developer
  </button>

  <!-- Hidden contact info -->
  <div id="contact-info" class="hidden mt-5 space-y-3 text-sm">

    <div class="flex items-center gap-3">
      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>

      @php
        $subject = rawurlencode('Service Request for HR Connect');
        $body = rawurlencode("Hello SEAVPEAV PECH,\r\nI'm interested in your support or have a question about HR Connect.\r\nPlease describe your inquiry below:\r\n\r\n\r\nBest regards,\n[Your Full Name]");
      @endphp

      <a href="mailto:seavpeavpech24@gmail.com?subject={{ $subject }}&body={{ $body }}"
         class="text-blue-600 hover:underline dark:text-blue-400">
        Send an Email
      </a>
    </div>

    <div class="flex items-center gap-3">
      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <a href="https://wa.me/85516700896" target="_blank" rel="noopener noreferrer"
         class="text-blue-600 hover:underline dark:text-blue-400">
        Message on WhatsApp
      </a>
    </div>

  </div>

  <h2 class="text-xl font-semibold mb-3 mt-8 text-gray-900 dark:text-white">7. Updates to Terms</h2>
  <p class="mb-6">
    These Terms may be updated periodically without prior notice.
    By continuing to use HR Connect after any update, you agree to the revised Terms.
  </p>

  <p class="text-sm text-gray-500 dark:text-gray-500">
    © {{ date('Y') }} HR Connect. Developed by <strong>SEAVPEAV PECH</strong>.
  </p>

</div>
@endsection
