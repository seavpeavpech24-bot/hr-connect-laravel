{{-- resources/views/auth/verify.blade.php --}}
@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-800 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        Verify Your Email
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
        We've sent a 4-digit verification code to your email.
      </p>
    </div>
    <form class="mt-8 space-y-6" action="{{ route('verify') }}" method="POST">
      @csrf
      <input type="hidden" name="email" value="{{ session('email') }}">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="code" class="sr-only">Verification Code</label>
          <input id="code" name="code" type="text" maxlength="4" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Enter 4-digit code">
        </div>
      </div>

      <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Verify
        </button>
      </div>

      @if(session('error'))
        <div class="text-red-600 text-sm text-center">
          {{ session('error') }}
        </div>
      @endif

      @if(session('success'))
        <div class="text-green-600 text-sm text-center">
          {{ session('success') }}
        </div>
      @endif
    </form>
  </div>
</div>
@endsection