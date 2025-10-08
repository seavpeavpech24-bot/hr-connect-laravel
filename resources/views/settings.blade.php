{{-- resources/views/settings.blade.php - Updated view (minor tweaks for real data fetching: ensures SMTP data loads correctly, enables Edit button, and handles nulls gracefully) --}}
@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h1>
        <p class="text-gray-600 dark:text-gray-300">Manage your profile, app credentials and users.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button"
                        class="tab-button border-blue-500 text-blue-600 dark:text-blue-400 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        id="profile-tab"
                        onclick="openTab(event, 'profile')">
                    Profile
                </button>
                <button type="button"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        id="app-credentials-tab"
                        onclick="openTab(event, 'app-credentials')">
                    App Credentials
                </button>
                <button type="button"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        id="account-security-tab"
                        onclick="openTab(event, 'account-security')">
                    Account Security
                </button>
                @if(auth()->user()->role === 'admin')
                <button type="button"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        id="users-tab"
                        onclick="openTab(event, 'users')">
                    Users
                </button>
                @endif
            </nav>
        </div>

        <div id="profile" class="tab-content p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Profile</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Edit your display name and profile picture.</p>

            <form id="profileForm" onsubmit="event.preventDefault(); saveProfile();">
                @csrf
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <img id="avatarPreview" src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : '/images/default-avatar.jpg' }}" alt="avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full name</label>
                        <input id="fullName" type="text" name="full_name" class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ auth()->user()->full_name }}">
                        <div class="mt-2 flex items-center gap-2">
                            <label class="cursor-pointer text-xs text-gray-500 dark:text-gray-300">Change photo
                                <input id="avatarInput" type="file" accept="image/*" name="profile_picture" class="hidden">
                            </label>
                            <button type="button" onclick="removeAvatar()" class="text-xs text-red-600 dark:text-red-400">Remove</button>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <!-- Inside the <form id="profileForm">, replace the company div -->
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                        <input id="company" type="text" name="company_name" class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ auth()->user()->company_name ?? '' }}" placeholder="Your company name">
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>

        <!-- In the App Credentials tab -->
        <div id="app-credentials" class="tab-content hidden p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">App Credentials</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Manage SMTP credentials for email functionality. Defaults are pre-set for Gmail.</p>

            <form id="appCredForm" onsubmit="event.preventDefault(); saveAppCred();">
                @csrf
                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1"><strong>Gmail Defaults (Fixed):</strong></p>
                    <p class="text-xs"><strong>Host:</strong> smtp.gmail.com</p>
                    <p class="text-xs"><strong>Port:</strong> 587</p>
                    <p class="text-xs"><strong>Secure (TLS):</strong> Enabled</p>
                </div>
                
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SMTP Email</label>
                <input id="smtpEmail" type="email" name="smtp_email" autocomplete="off" 
                    class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                    value="{{ auth()->user()->smtpCredential?->smtp_email ?? auth()->user()->email }}" placeholder="e.g., your@gmail.com" required>
                
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">Google App Password</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Generate a 16-character app-specific password from your Google Account security settings (not your main account password). Leave blank to keep current. Spaces will be automatically removed.</p>
                @if(auth()->user()->smtpCredential && auth()->user()->smtpCredential->smtp_app_password_encrypted)
                    <p class="text-xs text-green-600 dark:text-green-400 mb-1">✓ App Password is already configured.</p>
                @endif
                <input id="googleAppPassword" type="password" name="smtp_app_password" autocomplete="new-password" 
                    class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                    placeholder="Enter your 16-character Google App Password">
                
                <div class="mt-4 flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    <button type="button" onclick="clearAppCred()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded">Clear</button>
                </div>
            </form>
        </div>

        <!-- {{-- resources/views/settings.blade.php - Fix password confirmation field name to match Laravel's |confirmed rule --}}
        {{-- Only the account-security form changes; replace the existing <div id="account-security"...> with this --}} -->

        <div id="account-security" class="tab-content hidden p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Account Security</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Change your account password.</p>

            <form id="resetPasswordForm" onsubmit="event.preventDefault(); changePassword();" class="space-y-2">
                @csrf
                <input id="currentPassword" type="password" name="current_password" placeholder="Current password" class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700">
                <input id="newPassword" type="password" name="new_password" placeholder="New password" class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700">
                <input id="confirmPassword" type="password" name="new_password_confirmation" placeholder="Confirm new password" class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700">
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Reset Password</button>
                </div>
            </form>
        </div>

        @if(auth()->user()->role === 'admin')
        <div id="users" class="tab-content hidden p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Users</h2>
                <button type="button" class="px-3 py-1 bg-green-600 text-white rounded text-sm" onclick="openAddUser()">Add User</button>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Manage other accounts that can access this app.</p>

            <div id="usersList" class="mt-4 space-y-3">
                @forelse($users as $user)
                    <div class="flex items-center justify-between p-3 rounded border border-gray-100 dark:border-gray-700">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            <div class="text-xs text-gray-400">Role: {{ ucfirst($user->role) }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="text-sm text-blue-600" onclick="editUser('{{ $user->id }}')">Edit</button>
                            <button class="text-sm text-red-600" onclick="deleteUser('{{ $user->id }}')">Delete</button>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No users found.</p>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New User</h3>
        <form id="addUserForm" onsubmit="event.preventDefault(); createUser();" class="mt-4 space-y-3">
            @csrf
            <input id="newUserName" type="text" name="full_name" placeholder="Full name" 
                   class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700" required>
            <input id="newUserEmail" type="email" name="email" autocomplete="off" placeholder="Email" 
                   class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700" required>
            <input id="newUserPassword" type="password" name="password" autocomplete="new-password" placeholder="Password" 
                   class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700" required>
            <input id="newUserConfirmPassword" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" 
                   class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-700" required>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded" onclick="closeAddUser()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Create</button>
            </div>
        </form>
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

    // Avatar preview handler
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        avatarPreview.src = url;
    });

    function removeAvatar() {
        avatarPreview.src = '/images/default-avatar.jpg';
        avatarInput.value = null;
        // Optionally send request to remove profile picture
    }

    function clearAppCred() {
        document.getElementById('googleAppPassword').value = '';
    }

    async function saveProfile() {
        const fullName = document.getElementById('fullName').value.trim();
        const companyName = document.getElementById('company').value.trim();

        if (!fullName) {
            showToast('Full name is required.', 'error');
            return;
        }
        if (!companyName) {
            showToast('Company name is required.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('full_name', fullName);
        formData.append('company_name', companyName);  // Added this line
        const file = avatarInput.files[0];
        if (file) {
            formData.append('profile_picture', file);
        }

        try {
            const response = await fetch('/settings/profile', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (response.ok) {
                showToast('Profile saved successfully!', 'success');
                location.reload(); // Reload to update preview and values
            } else {
                showToast('Error saving profile.', 'error');
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
        }
    }

    async function saveAppCred() {
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('smtp_email', document.getElementById('smtpEmail').value);
        let appPassword = document.getElementById('googleAppPassword').value.trim();
        // Automatically remove all spaces/whitespace for better UX
        appPassword = appPassword.replace(/\s/g, '');
        if (appPassword) {
            formData.append('smtp_app_password', appPassword);
        }

        try {
            const response = await fetch('/settings/app-credentials', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (response.ok) {
                showToast('App credentials saved successfully!', 'success');
                // location.reload(); // Reload to update the "already configured" note
                console.log('App credentials updated');
            } else {
                showToast('Error saving credentials.', 'error');
                console.error('Error response:', response);
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
            console.error('Fetch error:', error);
        }
    }

    async function changePassword() {
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('current_password', document.getElementById('currentPassword').value);
        formData.append('new_password', document.getElementById('newPassword').value);
        formData.append('new_password_confirmation', document.getElementById('confirmPassword').value);  // Fixed: Use correct name for |confirmed

        if (document.getElementById('newPassword').value !== document.getElementById('confirmPassword').value) {
            showToast('Passwords do not match', 'error');
            return;
        }

        try {
            const response = await fetch('/settings/password', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'  // Ensures JSON errors from validation
                }
            });
            if (response.ok) {
                showToast('Password changed successfully!', 'success');
                document.getElementById('resetPasswordForm').reset();
            } else {
                // Read body as text first, then parse
                const responseText = await response.text();
                let errorMsg = 'Unknown error';
                try {
                    const errorData = JSON.parse(responseText);
                    // Handle validation errors (e.g., from |confirmed or hash check)
                    if (errorData.errors && errorData.errors.new_password_confirmation) {
                        errorMsg = errorData.errors.new_password_confirmation[0];
                    } else if (errorData.error) {
                        errorMsg = errorData.error;
                    } else if (errorData.message) {
                        errorMsg = errorData.message;
                    }
                } catch (jsonErr) {
                    errorMsg = responseText.includes('<!DOCTYPE') ? 'Server error. Please check logs.' : responseText.substring(0, 200) + '...';
                }
                showToast('Error: ' + errorMsg, 'error');
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
        }
    }

    function openAddUser() {
        document.getElementById('addUserModal').classList.remove('hidden');
        document.getElementById('addUserModal').classList.add('flex');
    }
    function closeAddUser() {
        document.getElementById('addUserModal').classList.add('hidden');
        document.getElementById('addUserModal').classList.remove('flex');
        document.getElementById('addUserForm').reset();
    }

    async function createUser() {
        // Client-side check for password match
        const password = document.getElementById('newUserPassword').value;
        const confirmPassword = document.getElementById('newUserConfirmPassword').value;
        if (password !== confirmPassword) {
            showToast('Passwords do not match', 'error');
            return;
        }

        const formData = new FormData(document.getElementById('addUserForm'));

        try {
            const response = await fetch('/settings/users', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'  // Ensures validation errors return JSON
                }
            });
            if (response.ok) {
                showToast('User created successfully!', 'success');
                closeAddUser();
                location.reload(); // Reload to update list
            } else {
                // Read body as text once
                const responseText = await response.text();
                let errorMsg = 'Unknown error';
                try {
                    const errorData = JSON.parse(responseText);
                    errorMsg = errorData.error || errorData.message || 'Unknown';  // Handles ValidationException format
                } catch (jsonErr) {
                    errorMsg = responseText.includes('<!DOCTYPE') ? 'Server error. Please check logs.' : responseText.substring(0, 200) + '...';
                    console.error('Create user non-JSON response:', responseText);
                }
                showToast('Error: ' + errorMsg, 'error');
                console.error('Create user error response:', responseText);
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
            console.error('Create user error:', error);
        }
    }

    async function deleteUser(id) {
        if (!confirm('Are you sure you want to delete this user?')) return;

        try {
            const response = await fetch(`/settings/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                showToast('User deleted successfully!', 'success');
                location.reload();
            } else {
                // Read body as text once
                const responseText = await response.text();
                let errorMsg = 'Unknown error';
                try {
                    const errorData = JSON.parse(responseText);
                    errorMsg = errorData.error || 'Unknown';
                } catch (jsonErr) {
                    errorMsg = responseText.includes('<!DOCTYPE') ? 'Server error. Please check logs.' : responseText.substring(0, 200) + '...';
                }
                showToast('Error: ' + errorMsg, 'error');
            }
        } catch (error) {
            showToast('Error: ' + error.message, 'error');
            console.error('Delete user error:', error);
        }
    }

    async function editUser(id) {
        window.location.href = `/settings/users/${id}/edit`;
    }

    // async function deleteUser(id) {
    //     if (!confirm('Are you sure you want to delete this user?')) return;

    //     try {
    //         const response = await fetch(`/settings/users/${id}`, {
    //             method: 'DELETE',
    //             headers: {
    //                 'X-CSRF-TOKEN': csrfToken,
    //                 'Content-Type': 'application/json'
    //             }
    //         });
    //         if (response.ok) {
    //             showToast('User deleted successfully!', 'success');
    //             location.reload();
    //         } else {
    //             showToast('Error deleting user.', 'error');
    //         }
    //     } catch (error) {
    //         showToast('Error: ' + error.message, 'error');
    //     }
    // }

    function openTab(evt, tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements that have a class of "tab-content"
        tabcontent = document.getElementsByClassName("tab-content");
        tablinks = document.getElementsByClassName("tab-button");

        // Hide all tab contents
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Remove active styles from all tab buttons
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("border-blue-500", "text-blue-600", "dark:text-blue-400");
            tablinks[i].classList.add("border-transparent", "text-gray-500", "hover:text-gray-700", "dark:text-gray-400", "dark:hover:text-gray-200");
        }

        // Show the current tab content
        document.getElementById(tabName).style.display = "block";

        // Add active styles to the clicked tab button
        evt.currentTarget.classList.add("border-blue-500", "text-blue-600", "dark:text-blue-400");
        evt.currentTarget.classList.remove("border-transparent", "text-gray-500", "hover:text-gray-700", "dark:text-gray-400", "dark:hover:text-gray-200");
    }

    // Set initial tab if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Profile tab is already visible
    });
</script>

@endsection