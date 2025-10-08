@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 text-gray-700 dark:text-gray-300">

  <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Privacy Policy</h1>

  <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

  <p class="mb-6">
    Thank you for using <strong>HR Connect</strong>. This Privacy Policy explains how your data is handled when using this application.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">1. Open Source Usage</h2>
  <p class="mb-6">
    HR Connect is an open-source project released for free on GitHub. You are allowed to
    <strong>clone, modify, or use</strong> the application for personal or business purposes without any fee.
    However, if you request bug fixes, new features, or additional support, a
    <strong>minimum service fee of $5</strong> will apply before any work begins.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">2. Data Storage</h2>
  <p class="mb-6">
    All user data is stored <strong>locally</strong> on your own machine using a local SQLite database.
    No personal data is transmitted, stored, or shared with any third-party service or remote server.
    You have full control of your local data.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">3. Third-Party Access</h2>
  <p class="mb-6">
    HR Connect does not collect analytics, tracking information, or transmit data to any external service.
    Your privacy and control over your data are fully protected.
  </p>

  <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">4. Developer Contact</h2>
  <p class="mb-4">
    For technical support, bug reports, or custom feature development, please reach out directly to the developer.
  </p>

  <!-- Contact button -->
  <button 
    onclick="document.getElementById('contact-info').classList.toggle('hidden')" 
    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
    Contact Support
  </button>

  <!-- Hidden contact info -->
  <div id="contact-info" class="hidden mt-5 space-y-3 text-sm">

    <div class="flex items-center gap-3">
      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>

      @php
        $subject = rawurlencode('Support Request from HR Connect');
        $body = rawurlencode("Hello, I'm using HR Connect and have a question.\r\nPlease describe your inquiry below:\r\n\r\n\r\n\r\nBest regards,\n[Your Full Name]");
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

  <h2 class="text-xl font-semibold mb-3 mt-8 text-gray-900 dark:text-white">5. Changes to This Policy</h2>
  <p class="mb-6">
    This Privacy Policy may be updated occasionally. Any future changes will be reflected in this document.
    Continued use of HR Connect after any updates constitutes your acceptance of the revised terms.
  </p>

  <p class="text-sm text-gray-500 dark:text-gray-500">
    © {{ date('Y') }} HR Connect. Developed by <strong>SEAVPEAV PECH</strong>.
  </p>

</div>
@endsection
