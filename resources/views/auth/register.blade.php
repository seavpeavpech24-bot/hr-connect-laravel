<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register | HR Connect</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    .btn-register {
      background: linear-gradient(135deg, #7c3aed, #5b21b6);
      transition: all 0.3s ease;
    }

    .btn-register:hover {
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

  <!-- Animated Stars -->
  <div class="star" style="top: 10%; left: 20%; animation-delay: 0s;"></div>
  <div class="star" style="top: 25%; left: 70%; animation-delay: 0.5s;"></div>
  <div class="star" style="top: 60%; left: 40%; animation-delay: 1s;"></div>
  <div class="star" style="top: 75%; left: 80%; animation-delay: 1.5s;"></div>

  <!-- Register Container -->
  <div class="flex flex-col md:flex-row w-full max-w-5xl rounded-3xl overflow-hidden glass-card">

    <!-- Left Info / Branding -->
    <div class="md:w-1/2 p-10 flex flex-col justify-center relative">
      <h1 class="text-5xl font-bold mb-4 brand-gradient">Join HR Connect</h1>
      <p class="text-gray-300 text-base leading-relaxed mb-5">
        Simplify your hiring process with <span class="text-purple-400 font-medium">HR Connect</span> — 
        manage applicants, send interview invitations, approvals, and rejection emails, 
        all from one secure dashboard. Designed for HR professionals who value clarity and efficiency.
      </p>

      <p class="text-sm text-gray-400 italic mb-8">
        “Connecting teams, empowering recruitment.”
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

      <!-- Background Glow -->
      <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-purple-700/30 rounded-full blur-3xl"></div>
      <div class="absolute -top-20 -left-20 w-72 h-72 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Right Registration Form -->
    <div class="md:w-1/2 p-10 flex flex-col justify-center bg-black/30">
      <h2 class="text-3xl font-semibold text-center mb-6">Create Your Account</h2>
      <p class="text-center text-gray-400 text-sm mb-6">Start managing your recruitment smarter with HR Connect.</p>

      @if (session('error'))
        <div class="bg-red-900/30 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg text-sm mb-4">
          {{ session('error') }}
        </div>
      @endif

      <form method="POST" action="/register" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
            <i class="fas fa-user text-purple-400 mr-2"></i>
            Full Name
          </label>
          <input type="text" name="full_name" class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
            <i class="fas fa-envelope text-purple-400 mr-2"></i>
            Email Address
          </label>
          <input type="email" name="email" class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
            <i class="fas fa-lock text-purple-400 mr-2"></i>
            Password
          </label>
          <input type="password" name="password" class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
            <i class="fas fa-lock text-purple-400 mr-2"></i>
            Confirm Password
          </label>
          <input type="password" name="password_confirmation" class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <label class="flex items-center text-sm text-gray-400">
          <input type="checkbox" name="term_accept" class="mr-2 rounded border-gray-600" required>
          <span>I agree to the <a href="/terms" class="text-purple-400 link-hover">Terms</a> & <a href="/privacy-policy" class="text-purple-400 link-hover">Privacy Policy</a></span>
        </label>

        <button type="submit" class="btn-register w-full py-3 rounded-xl font-semibold text-white text-lg shadow-lg">
          <i class="fas fa-user-plus mr-2"></i> Register
        </button>
      </form>

      <p class="text-center text-sm text-gray-400 mt-6">
        Already have an account?
        <a href="/login" class="text-purple-400 font-medium link-hover">Login</a>
      </p>
    </div>
  </div>
</body>
</html>
