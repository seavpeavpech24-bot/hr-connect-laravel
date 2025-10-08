{{-- resources/views/applicants/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Applicant Details - ' . $applicant->full_name)

@php
    // FIXED: Use real message history from $applicant->messageHistory (loaded in controller)
    $applicantHistory = $applicant->messageHistory ?? collect();

    // Templates with escaped placeholders to avoid Blade parsing (use {jobTitle} instead of {{jobTitle}})
    $approvalTemplate = [
        'subject' => "Congratulations on Your Job Offer for {jobTitle}, {name}!",
        'body' => "Dear {name},\n\nWe are thrilled to offer you the position of {jobTitle} at {companyName}. Your skills and experience stood out to our team, and we believe you will be a valuable asset.\n\nWe were very impressed during the interview process and are excited about the prospect of you joining our team.\n\nFurther details about your offer will be sent in a separate email. We look forward to welcoming you aboard!\n\nBest regards,\nThe Hiring Team at {companyName}",
    ];
    $rejectionTemplate = [
        'subject' => "Update on Your Application for {jobTitle}, {name}",
        'body' => "Dear {name},\n\nThank you for your interest in the {jobTitle} position at {companyName} and for taking the time to interview with our team.\n\nAfter careful consideration, we have decided to move forward with other candidates whose qualifications more closely match the current needs of the role.\n\nThis was a difficult decision, as we met with many talented individuals. We appreciate you sharing your experience with us and wish you the best in your job search.\n\nSincerely,\nThe Hiring Team at {companyName}",
    ];
    $interviewTemplate = [
        'subject' => "Invitation to Interview for {jobTitle}, {name} at {companyName}",
        'body' => "Dear {name},\n\nThank you for your application for the {jobTitle} position at {companyName}. We were impressed with your background and would like to invite you for an interview to discuss your qualifications further.\n\nHere are the details for the interview:\nDate: {interviewDate}\nTime: {interviewTime}\nLocation: {interviewLocation}\n\nPlease let us know if this time works for you. We look forward to speaking with you.\n\nBest regards,\nThe Hiring Team at {companyName}",
    ];
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('applicants.index') }}" class="p-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $applicant->full_name }}</h1>
            <p class="text-gray-600 dark:text-gray-300">Details for applicant ID: {{ $applicant->id }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-3 space-y-6">
            {{-- Applicant Information Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Applicant Information</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-gray-900 dark:text-white">{{ $applicant->full_name }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $applicant->email }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">{{ $applicant->email }}</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="text-gray-900 dark:text-white">{{ $applicant->phone ?? 'N/A' }}</span>
                    </div>
                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-gray-900 dark:text-white">Applying for <strong>{{ $applicant->position?->title ?? 'N/A' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="applicantStatus" class="px-2 py-1 text-xs font-semibold rounded-full {{ $applicant->status_class }} border">
                            {{ $applicant->status_label }}
                        </span>
                    </div>
                    @if($applicant->notes)
                        <hr class="my-4 border-gray-200 dark:border-gray-700">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-sm text-gray-600 dark:text-gray-300 italic">{{ $applicant->notes }}</p>
                        </div>
                    @endif
                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                    <div class="flex w-full gap-2">
                        {{-- Send Message Button --}}
                        <button onclick="openMessageModal()" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Send Message
                        </button>

                        {{-- View CV Button (assuming cvUrl or first file) --}}
                        @if($applicant->files->isNotEmpty() && $applicant->files->first()->file_type === 'cv')
                            <a href="{{ Storage::url($applicant->files->first()->file_path) }}" target="_blank" rel="noopener noreferrer" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                View CV
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Email History Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Email History</h2>
                </div>
                @if($applicantHistory->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Preview</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sent At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($applicantHistory as $history)
                                <tr class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700" data-message-id="{{ $history->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $history->subject }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($history->body, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($history->sent_at)->timezone('Asia/Phnom_Penh')->format('M d, Y \a\t g:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full @if($history->send_status === 'sent') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @elseif($history->send_status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                            {{ ucfirst($history->send_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No email history yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col space-y-2"></div>

{{-- Send Message Modal --}}
<div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Send Message to {{ $applicant->full_name }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Compose and send a direct message. Select a template or write a custom one.</p>
        </div>
        <form id="messageForm" method="POST" action="#" class="p-6 space-y-4"> {{-- Route to be created --}}
            @csrf
            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button type="button" data-tab="approval" class="tab-btn px-4 py-2 text-sm font-medium transition-colors text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Approval Template</button>
                <button type="button" data-tab="rejection" class="tab-btn px-4 py-2 text-sm font-medium transition-colors text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Rejection Template</button>
                <button type="button" data-tab="interview" class="tab-btn px-4 py-2 text-sm font-medium transition-colors text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Interview Template</button>
            </div>
            <div id="interviewFields" class="grid grid-cols-1 md:grid-cols-3 gap-4 hidden"> {{-- Hidden by default --}}
                <div>
                    <label for="interviewDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Interview Date</label>
                    <input type="date" id="interviewDate" name="interview_date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="interviewTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Interview Time</label>
                    <input type="time" id="interviewTime" name="interview_time" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="interviewLocation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location / URL</label>
                    <input type="text" id="interviewLocation" name="interview_location" placeholder="e.g., Google Meet link or Address" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                <input type="text" id="subject" name="subject" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                <textarea id="message" name="body" rows="12" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white min-h-[250px]"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeMessageModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                <button id="sendModalBtn" type="submit" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span id="sendModalText">Send Message to {{ $applicant->full_name }}</span>
                    <div id="sendModalSpinner" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- View Message Details Modal --}}
<div id="viewMessageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Email Details</h2>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                <p id="viewSubject" class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sent At</label>
                <p id="viewSentAt" class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-2 rounded"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <span id="viewStatus" class="inline-block px-2 py-1 text-xs font-semibold rounded-full"></span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body</label>
                <div id="viewBody" class="bg-gray-50 dark:bg-gray-700 p-3 rounded text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap min-h-[200px] max-h-[400px] overflow-y-auto"></div>
            </div>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button type="button" onclick="closeViewMessageModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Close</button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let activeTab = 'approval'; // Default tab
    const applicant = @json($applicant); // Pass to JS
    const companyName = '{{ auth()->user()->company_name ?? 'Unknown Company' }}';
    const history = @json($applicantHistory);

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toast function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `p-4 rounded-md shadow-lg max-w-sm w-full transform transition-all ${
            type === 'success' 
                ? 'bg-green-500 text-white dark:bg-green-600' 
                : 'bg-red-500 text-white dark:bg-red-600'
        }`;
        toast.textContent = message;
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';

        const container = document.getElementById('toast-container');
        container.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => container.removeChild(toast), 300);
        }, 3000);
    }

    function openMessageModal() {
        document.getElementById('messageModal').classList.remove('hidden');
        setTab('approval'); // Reset to default
    }

    function closeMessageModal() {
        document.getElementById('messageModal').classList.add('hidden');
    }

    function setTab(tab) {
        activeTab = tab;

        // Update button classes
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
            btn.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
        });
        const activeBtn = document.querySelector(`[data-tab="${tab}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
            activeBtn.classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        }

        const interviewFields = document.getElementById('interviewFields');
        if (tab === 'interview') {
            interviewFields.classList.remove('hidden');
        } else {
            interviewFields.classList.add('hidden');
        }

        let template;
        switch (tab) {
            case 'approval':
                template = @json($approvalTemplate);
                break;
            case 'rejection':
                template = @json($rejectionTemplate);
                break;
            case 'interview':
                template = @json($interviewTemplate);
                break;
        }

        const jobTitle = applicant.position?.title || 'Position';
        const name = applicant.full_name;

        let subject = template.subject
            .replace('{jobTitle}', jobTitle)
            .replace('{name}', name)
            .replace('{companyName}', companyName);
        document.getElementById('subject').value = subject;

        let body = template.body
            .replace(/{name}/g, name)
            .replace(/{jobTitle}/g, jobTitle)
            .replace(/{companyName}/g, companyName);

        if (tab === 'interview') {
            body = body
                .replace('{interviewDate}', document.getElementById('interviewDate').value || '[Date]')
                .replace('{interviewTime}', document.getElementById('interviewTime').value || '[Time]')
                .replace('{interviewLocation}', document.getElementById('interviewLocation').value || '[Location]');
        }
        body = unescapeBackslashNewlines(body);
        document.getElementById('message').value = body;
    }

    // Add click listeners to tab buttons
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('tab-btn')) {
            const tab = e.target.dataset.tab;
            setTab(tab);
        }
    });

    // Update body on interview input change
    document.addEventListener('input', (e) => {
        if (activeTab === 'interview' && e.target.id.startsWith('interview')) {
            setTab('interview');
        }
    });

    // Close modal on outside click
    document.addEventListener('click', (e) => {
        if (e.target.id === 'messageModal') closeMessageModal();
    });

    // Initialize default tab on modal open
    setTab('approval');

    // View Message Modal Functions
    function viewMessage(id) {
        const msg = history.find(h => h.id == id);
        if (!msg) return;

        document.getElementById('viewSubject').textContent = msg.subject;

        // Format sent_at in Cambodia timezone (Asia/Phnom_Penh)
        const sentAt = new Date(msg.sent_at);
        const formatter = new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Phnom_Penh',
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        document.getElementById('viewSentAt').textContent = formatter.format(sentAt);

        const statusEl = document.getElementById('viewStatus');
        const statusText = msg.send_status.charAt(0).toUpperCase() + msg.send_status.slice(1);
        statusEl.textContent = statusText;

        let statusClass = '';
        if (msg.send_status === 'sent') {
            statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        } else if (msg.send_status === 'failed') {
            statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        } else {
            statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        }
        statusEl.className = `inline-block px-2 py-1 text-xs font-semibold rounded-full ${statusClass}`;

        let bodyText = unescapeBackslashNewlines(msg.body);
        document.getElementById('viewBody').textContent = bodyText;

        document.getElementById('viewMessageModal').classList.remove('hidden');
    }

    function closeViewMessageModal() {
        document.getElementById('viewMessageModal').classList.add('hidden');
    }

    // Close view modal on outside click
    document.addEventListener('click', (e) => {
        if (e.target.id === 'viewMessageModal') closeViewMessageModal();
    });

    // Add click listeners to history table rows
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('tbody tr').forEach(tr => {
            tr.addEventListener('click', (e) => {
                const id = tr.dataset.messageId;
                viewMessage(id);
            });
        });

        // Form submission handler
        document.getElementById('messageForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleSendModal();
        });
    });

    // Helpers
    function unescapeBackslashNewlines(str) {
        // Replace literal backslash-n sequences (\n) with real newline characters
        return String(str).replace(/\\n/g, '\n');
    }

    async function handleSendModal() {
        const applicantId = document.querySelector('input[name="applicant_id"]').value;
        if (!applicantId) {
            showToast('Applicant ID is required.', 'error');
            return;
        }

        const subject = document.getElementById('subject').value.trim();
        const body = document.getElementById('message').value.trim();

        if (!subject || !body) {
            showToast('Subject and message are required.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('applicant_ids[]', applicantId);
        formData.append('subject', subject);
        formData.append('body', body);
        formData.append('type', activeTab);

        // Add interview fields if applicable
        if (activeTab === 'interview') {
            const date = document.getElementById('interviewDate').value;
            const time = document.getElementById('interviewTime').value;
            const location = document.getElementById('interviewLocation').value;

            if (!date || !time || !location) {
                showToast('Interview date, time, and location are required.', 'error');
                return;
            }

            formData.append('interview_date', date);
            formData.append('interview_time', time);
            formData.append('interview_location', location);
        }

        // Show loader
        const btn = document.getElementById('sendModalBtn');
        const text = document.getElementById('sendModalText');
        const spinner = document.getElementById('sendModalSpinner');
        btn.disabled = true;
        text.classList.add('hidden');
        spinner.classList.remove('hidden');

        try {
            const response = await fetch('/messages', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');

                // Update status in DOM (for immediate feedback)
                let newStatus, newStatusClass;
                switch (activeTab) {
                    case 'approval': 
                        newStatus = 'Approved'; 
                        newStatusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                        break;
                    case 'rejection': 
                        newStatus = 'Rejected'; 
                        newStatusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                        break;
                    case 'interview': 
                        newStatus = 'Interview Scheduled'; 
                        newStatusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                        break;
                }

                const statusEl = document.getElementById('applicantStatus');
                if (statusEl && newStatus) {
                    statusEl.textContent = newStatus;
                    statusEl.className = `px-2 py-1 text-xs font-semibold rounded-full ${newStatusClass} border`;
                }

                // Close modal
                closeMessageModal();

                // Reload page after delay for full sync
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.error || 'Failed to send message.', 'error');
                console.error(data.error || 'Failed to send message.', 'error');
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
            console.error('Error: ' + error.message, 'error');
        } finally {
            // Hide loader
            btn.disabled = false;
            text.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    }
</script>
@endsection