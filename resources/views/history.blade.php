{{-- resources/views/history.blade.php --}}
@extends('layouts.app')

@section('title', 'Message History')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Message History</h1>
            <p class="text-gray-600 dark:text-gray-300">View and manage all sent or received messages.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-3 py-4">
        <input
            type="text"
            id="searchFilter"
            placeholder="Search by subject or email..."
            class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
            oninput="filterMessages()"
        >

        <select id="statusFilter" onchange="filterMessages()" class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 w-[140px] focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="all">All Statuses</option>
            <option value="sent">Sent</option>
            <option value="failed">Failed</option>
            <option value="queued">Queued</option>
        </select>

        <select id="positionFilter" onchange="filterMessages()" class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 w-[140px] focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="all">All Positions</option>
            @foreach(\App\Models\Position::orderBy('title')->get() as $position)
                <option value="{{ $position->title }}">{{ $position->title }}</option>
            @endforeach
        </select>

        <button onclick="clearFilters()" class="flex items-center gap-2 px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Clear
        </button>
    </div>

    <!-- Message Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sender</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Receiver</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recips</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Position</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sent At</th>
                </tr>
            </thead>
            <tbody id="messagesTable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($messages as $msg)
                <tr 
                    data-id="{{ $msg->id }}"
                    data-sender="{{ $msg->sender }}"
                    data-recipients="{{ json_encode($msg->recipients) }}"
                    data-primary-receiver="{{ $msg->recipients[0]->email ?? '' }}"
                    data-subject="{{ $msg->subject }}"
                    data-body="{{ $msg->body }}"
                    data-status="{{ $msg->status }}"
                    data-sent="{{ \Carbon\Carbon::parse($msg->sent_at)->timezone('Asia/Phnom_Penh')->format('M d, Y \a\t g:i A') }}"
                    data-job-position="{{ $msg->job_position }}"
                    onclick="showMessageDetails('{{ $msg->id }}')"
                    class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $msg->sender }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 truncate max-w-[150px]">{{ $msg->recipients[0]->email ?? '' }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ count($msg->recipients) }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 truncate max-w-[200px]">{{ $msg->subject }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $msg->job_position }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($msg->status === 'sent') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($msg->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @elseif($msg->status === 'queued') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                            {{ ucfirst($msg->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($msg->sent_at)->timezone('Asia/Phnom_Penh')->format('M d, Y \a\t g:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No messages found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Message Details Modal -->
<div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Message Details</h2>
            <button onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong class="text-gray-800 dark:text-gray-200">Sender:</strong> <span id="detailSender" class="text-gray-600 dark:text-gray-300 block"></span></div>
                <div><strong class="text-gray-800 dark:text-gray-200">Subject:</strong> <span id="detailSubject" class="text-gray-600 dark:text-gray-300 block"></span></div>
                <div><strong class="text-gray-800 dark:text-gray-200">Job Position:</strong> <span id="detailJobPosition" class="text-gray-600 dark:text-gray-300 block"></span></div>
                <div><strong class="text-gray-800 dark:text-gray-200">Status:</strong> <span id="detailStatus" class="text-gray-600 dark:text-gray-300 block"></span></div>
                <div><strong class="text-gray-800 dark:text-gray-200">Sent At:</strong> <span id="detailSentAt" class="text-gray-600 dark:text-gray-300 block"></span></div>
            </div>
            <div>
                <strong class="text-gray-800 dark:text-gray-200">Primary Receiver:</strong>
                <div id="detailPrimaryReceiver" class="text-gray-600 dark:text-gray-300 mt-1"></div>
            </div>
            <div>
                <strong class="text-gray-800 dark:text-gray-200">All Recipients:</strong>
                <div id="detailRecipients" class="text-gray-600 dark:text-gray-300 mt-1 space-y-1 max-h-32 overflow-y-auto"></div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <strong class="text-gray-800 dark:text-gray-200 block mb-2">Message:</strong>
                <div id="detailBody" class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap bg-gray-50 dark:bg-gray-700 p-3 rounded-md max-h-64 overflow-y-auto"></div>
            </div>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 text-right">
            <button onclick="closeMessageModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Close</button>
        </div>
    </div>
</div>

<script>
function showMessageDetails(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;

    document.getElementById('detailSender').textContent = row.dataset.sender;
    document.getElementById('detailSubject').textContent = row.dataset.subject;
    document.getElementById('detailStatus').textContent = row.dataset.status;
    document.getElementById('detailSentAt').textContent = row.dataset.sent;
    document.getElementById('detailJobPosition').textContent = row.dataset.jobPosition;
    document.getElementById('detailPrimaryReceiver').textContent = row.dataset.primaryReceiver;

    const recipientsData = JSON.parse(row.dataset.recipients || '[]');
    let recipientsHtml = '';
    recipientsData.forEach(r => {
        recipientsHtml += `<div class="flex items-center gap-2"><span class="font-medium">${r.name}</span> - <span class="text-sm">${r.email}</span></div>`;
    });
    if (recipientsData.length === 0) {
        recipientsHtml = '<div class="italic text-gray-500 dark:text-gray-400">No recipients</div>';
    }
    document.getElementById('detailRecipients').innerHTML = recipientsHtml;

    document.getElementById('detailBody').textContent = row.dataset.body;

    document.getElementById('messageModal').classList.remove('hidden');
}

function closeMessageModal() {
    document.getElementById('messageModal').classList.add('hidden');
}

function filterMessages() {
    const searchValue = document.getElementById('searchFilter').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const positionFilter = document.getElementById('positionFilter').value;
    const rows = document.querySelectorAll('#messagesTable tr');

    rows.forEach(row => {
        const subject = row.dataset.subject.toLowerCase();
        const sender = row.dataset.sender.toLowerCase();
        const primaryReceiver = row.dataset.primaryReceiver.toLowerCase();
        const status = row.dataset.status;
        const jobPos = row.dataset.jobPosition.toLowerCase();

        const recipientsData = JSON.parse(row.dataset.recipients || '[]');
        let matchesRecipientSearch = false;
        recipientsData.forEach(r => {
            if (r.email.toLowerCase().includes(searchValue) || r.name.toLowerCase().includes(searchValue)) {
                matchesRecipientSearch = true;
            }
        });

        const matchesSearch = subject.includes(searchValue) || sender.includes(searchValue) || primaryReceiver.includes(searchValue) || matchesRecipientSearch || jobPos.includes(searchValue);
        const matchesStatus = (statusFilter === 'all' || status === statusFilter);
        const matchesPosition = (positionFilter === 'all' || row.dataset.jobPosition === positionFilter);

        row.style.display = (matchesSearch && matchesStatus && matchesPosition) ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('searchFilter').value = '';
    document.getElementById('statusFilter').value = 'all';
    document.getElementById('positionFilter').value = 'all';
    filterMessages();
}

// Close modal when clicking outside
document.addEventListener('click', (e) => {
    if (e.target.id === 'messageModal') closeMessageModal();
});
</script>
@endsection