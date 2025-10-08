{{-- resources/views/support.blade.php --}}
@extends('layouts.app')

@section('title', 'Support')

@section('content')
<div class="space-y-8">
  <div>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Support Center</h1>
    <p class="text-gray-600 dark:text-gray-300">Everything you need to set up, use, and troubleshoot HR Connect.</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- LEFT CONTENT -->
    <div class="lg:col-span-2 space-y-8">

      {{-- Getting Started --}}
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fas fa-rocket text-blue-500"></i> Getting Started: Your First Steps
          </h2>
        </div>
        <div class="p-6 space-y-4 text-gray-600 dark:text-gray-300">
          <p>Welcome to <strong>HR Connect</strong>! Follow these steps to set up your system and send your first email.</p>
          <ol class="list-decimal list-inside space-y-2">
            <li>
              <strong>Create Your HR Account:</strong>  
              Go to <a href="/settings" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Settings → HR Account</a> and add your Gmail address and App Password.  
              This enables the system to send messages through Gmail.
            </li>
            <li>
              <strong>Add Job Positions:</strong>  
              Visit <a href="/applicants" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Applicants</a> → “Job Positions” to define the roles you’re hiring for.
            </li>
            <li>
              <strong>Add Your First Applicant:</strong>  
              Click “Add Applicant” on the Applicants page to add candidate details and upload their CV.
            </li>
            <li>
              <strong>Send Messages:</strong>  
              Go to the <a href="/messages" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Messages</a> page or use “Send Message” from an applicant’s profile to send interview invitations, approvals, or rejections.
            </li>
            <li>
              <strong>Track History:</strong>  
              Open the <a href="/history" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">History</a> page to view sent messages, statuses, and delivery results.
            </li>
          </ol>
        </div>
      </div>

      {{-- Gmail App Password --}}
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h2 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fas fa-key text-blue-500"></i> How to Generate a Gmail App Password
          </h2>
        </div>
        <div class="p-6 space-y-4 text-gray-600 dark:text-gray-300">
          <div class="flex items-start p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md">
            <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-0.5"></i>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-gray-900 dark:text-white">Why You Need It</h3>
              <p class="text-sm">Gmail requires an App Password to allow third-party apps like HR Connect to send emails securely. It’s safer and limited to this specific app.</p>
            </div>
          </div>

          <p>Follow these steps to generate one:</p>
          <ol class="list-decimal list-inside space-y-3">
            <li>Open your Google Account <a href="https://myaccount.google.com/" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">here</a> or https://myaccount.google.com/.</li>
            <li>Go to <strong>Security</strong> → enable <strong>2-Step Verification</strong>.</li>
            <li>Return to the Security page, and find <strong>“App passwords”</strong>.</li>
            <li>Select “Other (Custom name)” and type <code>HR Connect</code>.</li>
            <li>Click <strong>Create</strong>, then copy the 16-character code.</li>
            <li>Paste it into your <a href="/settings" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">HR Account Settings</a> → “App Password”.</li>
          </ol>
        </div>
      </div>

      {{-- Tutorials --}}
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white"><i class="fas fa-play-circle text-blue-500"></i> Video Tutorials</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <iframe class="w-full aspect-video rounded-lg" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
            <p class="text-center text-sm mt-2 text-gray-600 dark:text-gray-300">System Overview</p>
          </div>
          <div>
            <iframe class="w-full aspect-video rounded-lg" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
            <p class="text-center text-sm mt-2 text-gray-600 dark:text-gray-300">Sending Messages via Gmail</p>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="lg:col-span-1 space-y-8">

      {{-- FAQ --}}
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">FAQ</h2>
        </div>
        <div class="p-6">
          @foreach([
              ['question' => 'How do I add applicants?', 'answer' => 'Go to “Applicants” → “Add Applicant” to register a candidate, upload their resume, and assign a job position.'],
              ['question' => 'Can I send messages to multiple people?', 'answer' => 'Yes. On the “Messages” page, select multiple applicants from the “To” field. The message will personalize automatically for each one.'],
              ['question' => 'What happens when I send an approval/rejection?', 'answer' => 'The applicant’s status automatically updates in the Applicants list.'],
              ['question' => 'Where can I see message history?', 'answer' => 'All sent or failed messages are visible in the “History” page.']
          ] as $item)
          <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 pb-4">
            <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center py-2">
              <span class="font-medium text-gray-900 dark:text-white">{{ $item['question'] }}</span>
              <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
            </button>
            <div class="hidden mt-2 text-gray-600 dark:text-gray-300 text-sm">
              {{ $item['answer'] }}
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Contact Developer --}}
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white"><i class="fas fa-life-ring text-blue-500"></i> Need Help?</h2>
          <p class="text-sm text-gray-600 dark:text-gray-300">Contact the developer directly for paid or personalized support.</p>
        </div>
        <div class="p-6 space-y-4">
          <div class="flex items-center gap-3 text-sm">
            <i class="fas fa-envelope text-gray-500"></i>
            <a href="mailto:seavpeavpech24@gmail.com?subject=HR Connect Support Request" class="text-blue-600 hover:underline dark:text-blue-400">Email Support</a>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <i class="fab fa-whatsapp text-green-500"></i>
            <a href="https://wa.me/85516700896" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">Message on WhatsApp</a>
          </div>
          <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md text-sm text-gray-700 dark:text-gray-300">
            <i class="fas fa-exclamation-triangle text-yellow-500"></i> Personalized assistance may include a small support fee ($5+).
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleFAQ(button) {
  const content = button.nextElementSibling;
  const icon = button.querySelector('i');
  const isHidden = content.classList.contains('hidden');
  content.classList.toggle('hidden');
  icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>
@endsection
