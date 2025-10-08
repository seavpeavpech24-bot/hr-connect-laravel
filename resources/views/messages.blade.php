{{-- resources/views/messages.blade.php --}}
@extends('layouts.app')

@section('title', 'Messages')

@php
    $templates = [
        'approval' => [
            'subject' => 'Congratulations on Your Job Offer!',
            'body' => 'Dear @{{name}},\n\nWe are thrilled to offer you the position of @{{jobTitle}} at @{{companyName}}. Your skills and experience stood out to our team, and we believe you will be a valuable asset.\n\nWe were very impressed during the interview process and are excited about the prospect of you joining our team.\n\nFurther details about your offer will be sent in a separate email. We look forward to welcoming you aboard!\n\nBest regards,\nThe Hiring Team at @{{companyName}}',
        ],
        'rejection' => [
            'subject' => 'Update on Your Application for @{{jobTitle}}',
            'body' => 'Dear @{{name}},\n\nThank you for your interest in the @{{jobTitle}} position at @{{companyName}} and for taking the time to interview with our team.\n\nAfter careful consideration, we have decided to move forward with other candidates whose qualifications more closely match the current needs of the role.\n\nThis was a difficult decision, as we met with many talented individuals. We appreciate you sharing your experience with us and wish you the best in your job search.\n\nSincerely,\nThe Hiring Team at @{{companyName}}',
        ],
        'interview' => [
            'subject' => 'Invitation to Interview for @{{jobTitle}}',
            'body' => 'Dear @{{name}},\n\nThank you for your application for the @{{jobTitle}} position at @{{companyName}}. We were impressed with your background and would like to invite you for an interview to discuss your qualifications further.\n\nHere are the details for the interview:\nDate: @{{interviewDate}}\nTime: @{{interviewTime}}\nLocation: @{{interviewLocation}}\n\nPlease let us know if this time works for you. We look forward to speaking with you.\n\nBest regards,\nThe Hiring Team at @{{companyName}}',
        ]
    ];
@endphp

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Emails</h1>
        <p class="text-gray-600 dark:text-gray-300">Compose and send emails to applicants.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Compose Section -->
        <div class="space-y-4">
            <!-- Tabs -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex space-x-8" id="tabsNav">
                    <button class="tab-btn py-2 px-1 border-b-2 font-medium text-sm tab-active" data-tab="approval">Approval</button>
                    <button class="tab-btn py-2 px-1 border-b-2 font-medium text-sm" data-tab="rejection">Rejection</button>
                    <button class="tab-btn py-2 px-1 border-b-2 font-medium text-sm" data-tab="interview">Interview</button>
                </nav>
            </div>

            <div id="tabContents">
                <!-- Approval Tab Content (empty as it's handled by form below) -->
                <div class="tab-content" data-tab="approval"></div>
                <!-- Rejection Tab Content -->
                <div class="tab-content hidden" data-tab="rejection"></div>
                <!-- Interview Tab Content -->
                <div class="tab-content hidden" data-tab="interview"></div>
            </div>

            <!-- Compose Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Compose Message</h2>
                        <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-4">
                            <span id="activeTemplateName" class="font-medium">Approval</span>
                            <span id="selectedCountInline" class="text-xs text-gray-500">0 selected</span>
                            <button id="toggleRenderBtn" type="button" class="ml-2 text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-gray-700 dark:text-gray-200">Live Render</button>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <!-- To (Applicants) - Multi-Select as Checkboxes -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">To (Applicants)</label>
                        <div class="max-h-40 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-700">
                            @forelse($applicants as $applicant)
                            <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded cursor-pointer">
                                <input type="checkbox" class="applicant-checkbox rounded" value="{{ $applicant->id }}" data-name="{{ $applicant->fullName }}" data-job="{{ $applicant->jobTitle }}" data-email="{{ $applicant->email }}">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $applicant->fullName }} - {{ $applicant->jobTitle }} - {{ $applicant->status }}</span>
                            </label>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 p-2">No applicants found. Add some via the Applicants page.</p>
                            @endforelse
                        </div>
                        <p id="selectedCount" class="text-sm text-gray-500 dark:text-gray-400">0 selected</p>
                    </div>

                    <!-- Interview Details (only for interview tab) -->
                    <div id="interviewDetails" class="grid grid-cols-1 md:grid-cols-3 gap-4 hidden">
                        <div class="space-y-2">
                            <label for="interviewDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Interview Date</label>
                            <input type="date" id="interviewDate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="space-y-2">
                            <label for="interviewTime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Interview Time</label>
                            <div class="flex items-center gap-3">
                                <input type="time" id="interviewTime" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <div id="formattedInterviewTime" class="text-xs text-gray-500 dark:text-gray-400">&nbsp;</div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="interviewLocation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location / URL</label>
                            <input type="text" id="interviewLocation" placeholder="e.g., Google Meet link" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                        <input type="text" id="subject" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="space-y-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea id="message" rows="12" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white min-h-[250px]"></textarea>
                    </div>
                    <!-- Inline rendered compose preview (hidden by default) -->
                    <div id="inlineRender" class="mt-4 p-4 border rounded bg-gray-50 dark:bg-gray-700 hidden">
                        <div id="inlineApplicantInfo" class="text-xs text-gray-600 dark:text-gray-300 mb-2"></div>
                        <div id="inlineRenderedBody" class="text-sm text-gray-700 dark:text-gray-300"></div>
                    </div>
                    <button id="sendBtn" onclick="handleSend()" class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span id="sendText">Send Messages</span>
                        <div id="sendSpinner" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Live Preview</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">This is how the email will look for the first selected applicant.</p>
            </div>
            <div class="p-6">
                <div id="previewContent" class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 space-y-4">
                    <div class="space-y-1">
                        <p id="previewSubject" class="text-sm font-semibold text-gray-900 dark:text-white"></p>
                        <p id="previewTo" class="text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>
                    <div class="border-t pt-4">
                        <div id="previewApplicantInfo" class="text-xs text-gray-600 dark:text-gray-300 mb-2"></div>
                        <div id="previewBody" class="text-sm text-gray-700 dark:text-gray-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col space-y-2"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
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

    // Global variables
    const templates = @json($templates);
    const applicants = @json($applicants);
    const loggedInCompany = '{{ $loggedInCompany }}';
    let activeTab = 'approval';
    let selectedApplicants = [];
    let interviewDate = '';
    let interviewTime = '';
    let interviewLocation = '';

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        handleTabChange('approval');
        updatePreview();
        // Use input events for real-time updates while typing/selecting
        document.getElementById('interviewDate').addEventListener('input', function(e) { interviewDate = e.target.value; if (activeTab === 'interview') renderTemplateToMessage('interview'); updatePreview(); });
        document.getElementById('interviewTime').addEventListener('input', function(e) { interviewTime = e.target.value; // update live formatted time
            document.getElementById('formattedInterviewTime').textContent = interviewTime ? formatTime12(interviewTime) : '';
            if (activeTab === 'interview') renderTemplateToMessage('interview'); updatePreview(); });
        document.getElementById('interviewLocation').addEventListener('input', function(e) { interviewLocation = e.target.value; if (activeTab === 'interview') renderTemplateToMessage('interview'); updatePreview(); });
        document.getElementById('subject').addEventListener('input', updatePreview);
        document.getElementById('message').addEventListener('input', updatePreview);
        // Live render toggle and syncing
        const toggleBtn = document.getElementById('toggleRenderBtn');
        const inlineRender = document.getElementById('inlineRender');
        toggleBtn.addEventListener('click', function() {
            const show = inlineRender.classList.toggle('hidden');
            // toggle returns true when classList.toggle added the class; invert for visibility
            if (!show) { // now visible
                toggleBtn.classList.add('bg-blue-600', 'text-white');
                toggleBtn.classList.remove('bg-gray-100', 'text-gray-700');
                renderInline();
            } else {
                toggleBtn.classList.remove('bg-blue-600', 'text-white');
                toggleBtn.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
        // When textarea changes, update inline render if visible
        document.getElementById('message').addEventListener('input', function() { if (!inlineRender.classList.contains('hidden')) renderInline(); });

        // Checkbox listeners
        document.querySelectorAll('.applicant-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const id = this.value;
                if (this.checked) {
                    selectedApplicants.push(id);
                } else {
                    selectedApplicants = selectedApplicants.filter(s => s !== id);
                }
                updateSelectedCount();
                updateInlineSelectedCount();
                updatePreview();
            });
        });
    });

    // Tab handling
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.dataset.tab;
            handleTabChange(tab, this);
        });
    });

    function handleTabChange(tab) {
        activeTab = tab;
        // Update active tab UI
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('tab-active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
            b.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });
        // If a button element was provided (user click), use it; otherwise select the button by data-tab
        let activeBtn = (arguments.length > 1 && arguments[1]) ? arguments[1] : document.querySelector(`.tab-btn[data-tab="${tab}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            activeBtn.classList.add('tab-active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        }

        // Hide/show tab contents
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.querySelector(`[data-tab="${tab}"]`).classList.remove('hidden');

        // Show/hide interview details
        document.getElementById('interviewDetails').classList.toggle('hidden', tab !== 'interview');

        // Load template into subject/message
        renderTemplateToMessage(tab);
        updateActiveTemplateName();
        updatePreview();
    }

    // Apply the template for a tab into the subject and message fields
    function renderTemplateToMessage(tab) {
        const template = templates[tab];
        if (!template) return;
        document.getElementById('subject').value = template.subject;
        let body = template.body.replace(/@{{companyName}}/g, loggedInCompany);
        if (tab === 'interview') {
            const displayDate = interviewDate || '[Date]';
            const displayTime = interviewTime ? formatTime12(interviewTime) : '[Time]';
            const displayLocation = interviewLocation || '[Location]';
            body = body
                .replace(/@{{interviewDate}}/g, displayDate)
                .replace(/@{{interviewTime}}/g, displayTime)
                .replace(/@{{interviewLocation}}/g, displayLocation);
            // Update the formatted time display next to the input
            document.getElementById('formattedInterviewTime').textContent = interviewTime ? formatTime12(interviewTime) : '';
        }
    // Convert escaped backslash-n sequences into real newlines for the editor
    document.getElementById('message').value = unescapeBackslashNewlines(body);
        // If inline render visible, update it too
        const inlineRender = document.getElementById('inlineRender');
        if (inlineRender && !inlineRender.classList.contains('hidden')) renderInline();
    }

    function renderInline() {
        const applicantInfoEl = document.getElementById('inlineApplicantInfo');
        const bodyEl = document.getElementById('inlineRenderedBody');
        const firstApplicantId = selectedApplicants.length ? selectedApplicants[0] : null;
        const firstApplicant = firstApplicantId ? applicants.find(a => a.id == firstApplicantId) : null;
        if (firstApplicant) {
            applicantInfoEl.textContent = `${firstApplicant.fullName} — ${firstApplicant.jobTitle} — ${firstApplicant.email} — ${firstApplicant.status}`;
        } else {
            applicantInfoEl.textContent = '';
        }
        let bodyText = document.getElementById('message').value || '';
        bodyText = unescapeBackslashNewlines(bodyText);
        bodyEl.innerHTML = nl2br(escapeHtml(bodyText));
    }

    function updateSelectedCount() {
        document.getElementById('selectedCount').textContent = `${selectedApplicants.length} selected`;
    }

    function updateInlineSelectedCount() {
        document.getElementById('selectedCountInline').textContent = `${selectedApplicants.length} selected`;
    }

    function updateActiveTemplateName() {
        const name = activeTab.charAt(0).toUpperCase() + activeTab.slice(1);
        document.getElementById('activeTemplateName').textContent = name;
    }

    function getPreview() {
        // If nothing selected, preview the current message (with company placeholder replaced)
        if (selectedApplicants.length === 0) {
            return document.getElementById('message').value.replace(/@{{companyName}}/g, loggedInCompany);
        }

        // Use the first selected applicant for the preview
        const firstId = selectedApplicants[0];
        const applicant = applicants.find(a => a.id == firstId);
        // If we couldn't find the applicant, fallback to message content
        if (!applicant) return document.getElementById('message').value.replace(/@{{companyName}}/g, loggedInCompany);

        const msgValue = document.getElementById('message').value.trim();

        // If the message textarea is empty, show a concise applicant summary
        if (!msgValue) {
            return `Name: ${applicant.fullName}\nEmail: ${applicant.email}\nJob: ${applicant.jobTitle}\nStatus: ${applicant.status}`;
        }

        // Otherwise, perform template substitutions on the message content
        let previewBody = document.getElementById('message').value
            .replace(/@{{name}}/g, applicant.fullName)
            .replace(/@{{jobTitle}}/g, applicant.jobTitle)
            .replace(/@{{companyName}}/g, loggedInCompany);

        if (activeTab === 'interview') {
            previewBody = previewBody
                .replace(/@{{interviewDate}}/g, interviewDate || '[Date]')
                .replace(/@{{interviewTime}}/g, interviewTime ? formatTime12(interviewTime) : '[Time]')
                .replace(/@{{interviewLocation}}/g, interviewLocation || '[Location]');
        }

        return previewBody;
    }

    function updatePreview() {
        if (selectedApplicants.length === 0) {
            document.getElementById('previewSubject').textContent = document.getElementById('subject').value.replace(/@{{jobTitle}}/g, 'the Position');
            document.getElementById('previewTo').textContent = '';
        } else {
            const firstId = selectedApplicants[0];
            const applicant = applicants.find(a => a.id == firstId);
            document.getElementById('previewSubject').textContent = document.getElementById('subject').value.replace(/@{{jobTitle}}/g, applicant ? applicant.jobTitle : 'the Position');
            document.getElementById('previewTo').textContent = `To: ${applicant ? applicant.email : ''}`;
        }
        // Render applicant info (if any)
        const previewContainer = document.getElementById('previewBody');
        const applicantInfoEl = document.getElementById('previewApplicantInfo');
        const firstApplicantId = selectedApplicants.length ? selectedApplicants[0] : null;
        const firstApplicant = firstApplicantId ? applicants.find(a => a.id == firstApplicantId) : null;

        if (firstApplicant) {
            applicantInfoEl.textContent = `${firstApplicant.fullName} — ${firstApplicant.jobTitle} — ${firstApplicant.email} — ${firstApplicant.status}`;
        } else {
            applicantInfoEl.textContent = '';
        }

        // Safely render the preview body as HTML with line breaks
        let bodyText = getPreview();
        // Convert escaped backslash-n sequences ("\\n") into actual newlines
        bodyText = unescapeBackslashNewlines(bodyText);
        previewContainer.innerHTML = nl2br(escapeHtml(bodyText));
    }

    // Helpers
    function escapeHtml(unsafe) {
        if (unsafe === null || unsafe === undefined) return '';
        return String(unsafe)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function nl2br(str) {
        return String(str).replace(/\n/g, '<br>');
    }

    function unescapeBackslashNewlines(str) {
        // Replace literal backslash-n sequences (\n) with real newline characters
        return String(str).replace(/\\n/g, '\n');
    }

    // Convert 24-hour 'HH:MM' from <input type="time"> to 12-hour format with AM/PM
    function formatTime12(hhmm) {
        if (!hhmm) return '';
        // expected hh:mm
        const parts = hhmm.split(':');
        if (parts.length < 2) return hhmm;
        let hh = parseInt(parts[0], 10);
        const mm = parts[1];
        const ampm = hh >= 12 ? 'PM' : 'AM';
        hh = hh % 12;
        if (hh === 0) hh = 12;
        return `${hh}:${mm} ${ampm}`;
    }

    async function handleSend() {
        if (selectedApplicants.length === 0) {
            showToast('Please select at least one applicant to send the message to.', 'error');
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
        selectedApplicants.forEach(id => formData.append('applicant_ids[]', id));
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
        const btn = document.getElementById('sendBtn');
        const text = document.getElementById('sendText');
        const spinner = document.getElementById('sendSpinner');
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

                // Update statuses in DOM (for immediate feedback)
                let newStatus;
                switch (activeTab) {
                    case 'approval': newStatus = 'Approved'; break;
                    case 'rejection': newStatus = 'Rejected'; break;
                    case 'interview': newStatus = 'Interviewed'; break;
                }

                selectedApplicants.forEach(id => {
                    const checkbox = document.querySelector(`.applicant-checkbox[value="${id}"]`);
                    if (checkbox) {
                        const applicant = applicants.find(a => a.id == id);
                        if (applicant && newStatus) {
                            const label = checkbox.closest('label').querySelector('span');
                            label.textContent = `${applicant.fullName} - ${applicant.jobTitle} - ${newStatus}`;
                            // Update JS array for consistency
                            if (applicant) applicant.status = newStatus;
                        }
                    }
                });

                // Clear form/selection
                selectedApplicants = [];
                document.querySelectorAll('.applicant-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('subject').value = '';
                document.getElementById('message').value = '';
                updateSelectedCount();
                updatePreview();

                // Optional: Reload page after delay for full sync (or fetch updated applicants)
                // setTimeout(() => location.reload(), 2000);
            } else {
                showToast(data.error || 'Failed to send messages.', 'error');
                console.error(data.error || 'Failed to send messages.', 'error');
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

<style>
    .tab-active { color: #2563eb; border-color: #2563eb; }
    .tab-btn { border-bottom-width: 2px; transition: all 0.2s; }
</style>
@endsection