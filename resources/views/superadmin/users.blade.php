@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <div>
            <h1 class="page-title">User Accounts Management</h1>
            <p class="page-subtitle">Manage system access, roles, and user permissions.</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="openAddModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add User
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-top: 1.5rem; background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 1rem; border-radius: 8px; border: 1px solid rgba(34, 197, 94, 0.2); display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-top: 1.5rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.2); display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="card" style="margin-top: 2rem; overflow: hidden;">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>User Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Last Active</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td style="color: var(--text-muted);">{{ $loop->iteration }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="navbar-user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 600;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="navbar-role-badge navbar-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                            {{ $user->updated_at->diffForHumans() }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <button class="btn btn-icon" title="Edit User" 
                                    onclick="openEditModal({{ json_encode($user) }})">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Type DELETE to confirm removal of this user?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon" style="color: var(--danger);" title="Delete User">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="userModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Add New User</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="userForm" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="userName" required placeholder="User's full name">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="userEmail" required placeholder="name@domain.com">
            </div>
            <div class="form-group">
                <label id="passLabel">Password</label>
                <input type="password" name="password" id="userPass" placeholder="Leave blank to keep current">
            </div>
            <div class="form-group">
                <label>System Role</label>
                <select name="role" id="userRole" required>
                    <option value="user">User (Viewer)</option>
                    <option value="admin">Administrator (Editor)</option>
                    <option value="superadmin">Super Administrator (Owner)</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Create User Account</button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: var(--bg-primary);
        width: 100%;
        max-width: 450px;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h2 { font-size: 1.25rem; margin: 0; color: var(--text-primary); }
    .modal-close { background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; }
    
    #userForm { padding: 1.5rem; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-muted); }
    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-family: inherit;
    }
    .modal-footer {
        padding-top: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        text-align: left;
        padding: 1rem 1.5rem;
        background: var(--bg-secondary);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }
    .data-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }
    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text-primary);
        cursor: pointer;
    }
</style>

<script>
    const modal = document.getElementById('userModal');
    const form = document.getElementById('userForm');
    const methodField = document.getElementById('methodField');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');

    function openAddModal() {
        modalTitle.innerText = "Add New User";
        submitBtn.innerText = "Create User Account";
        form.action = "{{ route('superadmin.users.store') }}";
        methodField.innerHTML = "";
        
        document.getElementById('userName').value = "";
        document.getElementById('userEmail').value = "";
        document.getElementById('userPass').value = "";
        document.getElementById('userPass').required = true;
        document.getElementById('passLabel').innerText = "Password";
        document.getElementById('userRole').value = "user";

        modal.style.display = 'flex';
    }

    function openEditModal(user) {
        modalTitle.innerText = "Edit User: " + user.name;
        submitBtn.innerText = "Save Changes";
        form.action = "/superadmin/users/" + user.id;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userPass').value = "";
        document.getElementById('userPass').required = false;
        document.getElementById('passLabel').innerText = "Password (Optional)";
        document.getElementById('userRole').value = user.role;

        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) closeModal();
    }
</script>
@endsection
