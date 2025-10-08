{{-- resources/views/applicants/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Applicant - ' . $applicant->full_name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Applicant</h1>
            <p class="text-gray-600 dark:text-gray-300">Update the details for {{ $applicant->full_name }}.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('applicants.show', $applicant) }}" class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                View Details
            </a>
            <a href="{{ route('applicants.index') }}" class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Back to List
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('applicants.update', $applicant) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="{{ $applicant->full_name }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ $applicant->email }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone (Optional)</label>
                <input type="tel" id="phone" name="phone" value="{{ $applicant->phone }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="applied_position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Position</label>
                <select id="applied_position_id" name="applied_position_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">No Position</option>
                    @foreach($jobPositions as $position)
                        <option value="{{ $position->id }}" {{ $applicant->applied_position_id == $position->id ? 'selected' : '' }}>{{ $position->title }}</option>
                    @endforeach
                </select>
                @error('applied_position_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status" name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="pending" {{ $applicant->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewed" {{ $applicant->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="rejected" {{ $applicant->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="approved" {{ $applicant->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="interviewed" {{ $applicant->status == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source (Optional)</label>
                <input type="text" id="source" name="source" value="{{ $applicant->source }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="e.g., LinkedIn">
                @error('source') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">{{ $applicant->notes }}</textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
            <a href="{{ route('applicants.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Applicant</button>
        </div>
    </form>
</div>
@endsection