{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <section class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-1">Welcome, {{ Auth::user()->full_name }}</p>
        <p class="text-gray-600 mb-6">Role: {{ Auth::user()->role }}</p>
      </div>
      <!-- Optional: Add a date or filter here -->
      <div class="text-sm text-gray-500 dark:text-gray-400">
        {{ now()->format('F j, Y') }} <!-- e.g., October 5, 2025 -->
      </div>
    </div>

   <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Total Applicants -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Applicants</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalApplicants }}</p>
          </div>
        </div>
      </div>

      <!-- Pending -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pending }}</p>
          </div>
        </div>
      </div>

      <!-- Reviewed -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Reviewed</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reviewed }}</p>
          </div>
        </div>
      </div>

      <!-- Interviewed -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-violet-100 dark:bg-violet-900 text-violet-600 dark:text-violet-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Interviewed</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $interviewed }}</p>
          </div>
        </div>
      </div>

      <!-- Approved -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Approved</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $approved }}</p>
          </div>
        </div>
      </div>

      <!-- Rejected -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rejected</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $rejected }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="/applicants" class="block bg-blue-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
          👤 Add Applicant
        </a>
        <a href="/messages" class="block bg-green-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
          📧 Send Messages
        </a>
      </div>
    </div>
  </section>
@endsection