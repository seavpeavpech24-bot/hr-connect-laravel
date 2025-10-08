<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | HR Connect</title>

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: radial-gradient(circle at top, #141427, #0b0b17);
      color: #fff;
      font-family: 'Inter', sans-serif;
    }

    .glass-card {
      background: rgba(20, 20, 32, 0.85);
      backdrop-filter: blur(14px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 40px rgba(124, 58, 237, 0.25);
    }

    .btn-login {
      background: linear-gradient(135deg, #7c3aed, #5b21b6);
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
    }

    .brand-gradient {
      background: linear-gradient(to right, #a78bfa, #7c3aed);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .link-hover:hover {
      color: #a78bfa;
    }

    .star {
      position: absolute;
      width: 2px;
      height: 2px;
      background: white;
      border-radius: 50%;
      opacity: 0.7;
      animation: twinkle 2s infinite ease-in-out;
    }

    @keyframes twinkle {
      0%, 100% { opacity: 0.2; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.5); }
    }
  </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden">

  <!-- Animated Stars Background -->
  <div class="star" style="top: 10%; left: 20%; animation-delay: 0s;"></div>
  <div class="star" style="top: 25%; left: 70%; animation-delay: 0.5s;"></div>
  <div class="star" style="top: 60%; left: 40%; animation-delay: 1s;"></div>
  <div class="star" style="top: 75%; left: 80%; animation-delay: 1.5s;"></div>

  <!-- Login Container -->
  <div class="flex flex-col md:flex-row w-full max-w-6xl rounded-3xl overflow-hidden shadow-2xl glass-card">

    <!-- Left Info -->
    <div class="md:w-1/2 p-10 flex flex-col justify-center relative">
      <h1 class="text-5xl font-bold mb-4 brand-gradient">HR Connect</h1>
      <p class="text-gray-300 text-base leading-relaxed mb-5">
        <strong>HR Connect</strong> is a free, modern HR management system that empowers human resource professionals 
        to manage <span class="text-purple-400">applicant data</span>, send <span class="text-purple-400">email invitations</span> for interviews, 
        handle <span class="text-purple-400">approvals</span> or <span class="text-purple-400">rejections</span>, and track 
        <span class="text-purple-400">message history</span> — all in one smart dashboard.
      </p>

      <p class="text-sm text-gray-400 italic mb-8">
        “Because every applicant deserves a clear response.”
      </p>

      <div class="space-y-2 text-sm text-gray-500">
        <p>
          <i class="fas fa-user-gear text-purple-400 mr-2"></i>
          Developed by <span class="text-purple-400 font-semibold">SEAVPEAV PECH</span>
        </p>

        <p>
          <i class="fas fa-globe text-purple-400 mr-2"></i>
          Free & Open to the Community
        </p>

        <p>
          <i class="fas fa-calendar text-purple-400 mr-2"></i>
          © {{ date('Y') }} HR Connect. All rights reserved.
        </p>

        <p>
          <i class="fas fa-headset text-purple-400 mr-2"></i>
          Need help? <a href="/support" class="text-purple-400 hover:text-purple-300 font-medium underline">Contact Support</a>
        </p>
      </div>


      <!-- Glow Elements -->
      <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-purple-700/30 rounded-full blur-3xl"></div>
      <div class="absolute -top-20 -left-20 w-72 h-72 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Right Login Form -->
    <div class="md:w-1/2 p-10 flex flex-col justify-center bg-black/30">
      <div class="space-y-6">

        <h2 class="text-3xl font-semibold text-center mb-4">Welcome Back</h2>
        <p class="text-center text-gray-400 text-sm mb-6">Login to access your HR Connect dashboard.</p>

        @if (session('error'))
          <div class="bg-red-900/30 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
          @csrf

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
              <i class="fas fa-envelope text-purple-400 mr-2"></i> Email Address
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white 
                          focus:outline-none focus:ring-2 focus:ring-purple-600">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
              <i class="fas fa-lock text-purple-400 mr-2"></i> Password
            </label>
            <input type="password" name="password" required
                   class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white 
                          focus:outline-none focus:ring-2 focus:ring-purple-600">
          </div>

          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center text-gray-400">
              <input type="checkbox" name="remember" class="mr-2 rounded border-gray-600 bg-gray-800"> Remember me
            </label>
            <a href="/forgot-password" class="text-purple-400 link-hover">Forgot password?</a>
          </div>

          <button type="submit" class="btn-login w-full py-3 rounded-xl font-semibold text-white text-lg shadow-lg">
            <i class="fas fa-sign-in-alt mr-2"></i> Login
          </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-6">
          Don’t have an account? 
          <a href="/register" class="text-purple-400 font-medium link-hover">Create one</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Modal: Registration Blocked -->
  @if (session('registration_blocked'))
  <div x-data="{ show: true }" x-show="show"
       class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70"
       x-transition>
    <div class="bg-gray-900 rounded-lg shadow-xl max-w-lg w-full mx-4 p-6 text-center border border-purple-600/30">
      <div class="mb-4 text-red-400 text-3xl">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2 text-white">Registration Blocked</h3>
      <p class="text-gray-300 mb-6">{{ session('registration_blocked') }}</p>
      <button @click="show = false" class="px-5 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-white font-medium">
        Got it, I'll login
      </button>
    </div>
  </div>
  @endif

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
