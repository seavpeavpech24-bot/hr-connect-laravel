{{-- resources/views/applicants.blade.php --}}
@extends('layouts.app')

@section('title', 'Applicants')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900 dark:border-green-200 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Applicants</h1>
            <p class="text-gray-600 dark:text-gray-300">Manage your candidates and their application process.</p>
        </div>
        <div class="flex gap-2">
            <!-- Job Positions Button -->
            <button onclick="openJobModal()" class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Job Positions
            </button>

            <!-- Add Applicant Button -->
            <button onclick="openAddModal()" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Applicant
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-4 py-4">
        <input
            type="text"
            id="nameFilter"
            placeholder="Filter by name..."
            class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
            oninput="filterTable()"
        >
        <select id="statusFilter" onchange="filterTable()" class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 w-[180px] focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="reviewed">Reviewed</option>
            <option value="rejected">Rejected</option>
            <option value="approved">Approved</option>
            <option value="interviewed">Interviewed</option>
        </select>

        <select id="jobFilter" onchange="filterTable()" class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 w-[240px] focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="all">All Jobs</option>
            @foreach($jobPositions as $position)
                <option value="{{ $position->title }}">{{ $position->title }}</option>
            @endforeach
        </select>

        <button onclick="clearFilters()" class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Clear Filters
        </button>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="applicantsTable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($applicants as $applicant)
                <tr data-id="{{ $applicant->id }}"
                    data-name="{{ strtolower($applicant->full_name) }}"
                    data-status="{{ $applicant->status }}"
                    data-job="{{ $applicant->position?->title ?? 'N/A' }}"
                    data-fullname="{{ $applicant->full_name }}"
                    data-email="{{ $applicant->email }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $applicant->full_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $applicant->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $applicant->position?->title ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $applicant->status_class }}">
                            {{ $applicant->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        {{-- CHANGED: Details now links to show page --}}
                        <a href="{{ route('applicants.show', $applicant) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Details</a>
                        {{-- CHANGED: Edit now links to edit page --}}
                        <a href="{{ route('applicants.edit', $applicant) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                        <button onclick="confirmDelete('{{ $applicant->id }}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No applicants yet. Add one above!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Applicant Modal (KEPT: For new applicants only) --}}
<div id="applicantModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white">Add New Applicant</h2>
            <p id="modalDesc" class="text-gray-600 dark:text-gray-300 mt-1">Fill in the details below to add a new candidate to your pipeline.</p>
        </div>
        <form id="applicantForm" method="POST" action="{{ route('applicants.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="applicantId" name="id">
            <input type="hidden" id="_method" name="_method">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone (Optional)</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="applied_position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Position</label>
                    <select id="applied_position_id" name="applied_position_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">No Position</option>
                        @foreach($jobPositions as $position)
                            <option value="{{ $position->id }}">{{ $position->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="status" name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="pending">Pending</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="rejected">Rejected</option>
                        <option value="approved">Approved</option>
                        <option value="interviewed">Interviewed</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source (Optional)</label>
                    <input type="text" id="source" name="source" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="e.g., LinkedIn">
                </div>
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeApplicantModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Applicant</button>
            </div>
        </form>
    </div>
</div>

{{-- REMOVED: Details Modal (now full page) --}}

{{-- Job Positions Modal (KEPT) --}}
<div id="jobModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Job Positions</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Manage available job positions for applicants.</p>
        </div>
        <div class="p-6 space-y-4">
            <!-- Add Job Position Form -->
            <form method="POST" action="{{ route('positions.store') }}" class="space-y-4">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="title" placeholder="New job title..." required class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Add Position</button>
                </div>
            </form>
            <!-- Positions List -->
            <div class="space-y-2">
                @forelse($jobPositions as $position)
                <div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $position->title }}</span>
                    <form method="POST" action="{{ route('positions.destroy', $position) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this position?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
                    </form>
                </div>
                @empty
                <div class="text-center text-gray-500 dark:text-gray-400">No positions yet. Add one above!</div>
                @endforelse
            </div>
            <div class="flex justify-end">
                <button onclick="closeJobModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal (KEPT, with minor fix for onclick) --}}
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Are you sure?</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">This action cannot be undone. This will permanently delete the applicant.</p>
            <div class="flex justify-end space-x-2">
                <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    let applicantToDelete = null;

    function openAddModal() {
        document.getElementById('applicantModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = 'Add New Applicant';
        document.getElementById('modalDesc').textContent = 'Fill in the details below to add a new candidate to your pipeline.';
        document.getElementById('applicantForm').action = '{{ route("applicants.store") }}';
        document.getElementById('_method').remove(); // Remove if exists
        document.getElementById('applicantId').value = '';
        document.getElementById('full_name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('applied_position_id').value = '';
        document.getElementById('status').value = 'pending';
        document.getElementById('source').value = '';
        document.getElementById('notes').value = '';
    }

    {{-- REMOVED: editApplicant() and info() functions (now links) --}}

    function closeApplicantModal() {
        document.getElementById('applicantModal').classList.add('hidden');
    }

    function openJobModal() {
        document.getElementById('jobModal').classList.remove('hidden');
    }

    function closeJobModal() {
        document.getElementById('jobModal').classList.add('hidden');
    }

    {{-- FIXED: confirmDelete now sets onclick properly --}}
    function confirmDelete(id) {
        applicantToDelete = id;
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.onclick = function() { performDelete(id); };
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        applicantToDelete = null;
    }

    function performDelete(id) {
        if (applicantToDelete) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/applicants/${applicantToDelete}`;
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
        closeDeleteModal();
    }

    function filterTable() {
        const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const jobFilter = document.getElementById('jobFilter').value;
        const rows = document.querySelectorAll('#applicantsTable tr');
        rows.forEach(row => {
            if (!row.dataset.id) return; // Skip header/empty
            const nameMatch = row.dataset.name.includes(nameFilter);
            const statusMatch = statusFilter === 'all' || row.dataset.status === statusFilter;
            const jobMatch = jobFilter === 'all' || row.dataset.job === jobFilter;
            row.style.display = (nameMatch && statusMatch && jobMatch) ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('nameFilter').value = '';
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('jobFilter').value = 'all';
        filterTable();
    }

    // Close modals on outside click
    document.addEventListener('click', (e) => {
        if (e.target.id === 'applicantModal') closeApplicantModal();
        if (e.target.id === 'jobModal') closeJobModal();
        if (e.target.id === 'deleteModal') closeDeleteModal();
    });
</script>
@endsection