@php
use Illuminate\Support\Facades\Auth;
@endphp

<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title">Workspace Members ({{ $workspace->name }})</h5>
                @if(in_array($workspace->members()->where('user_id', Auth::id())->first()?->role, ['owner']))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteModal">
                        Invite Member
                    </button>
                @endif
                <a href="{{ route('workspaces.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search members...">
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>{{ $member->user->name }}</td>
                                <td>{{ $member->user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $member->role === 'owner' ? 'danger' : ($member->role === 'admin' ? 'warning' : 'info') }}">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->user_id === Auth::id())
                                        @if($member->role !== 'owner')
                                            <button class="btn btn-sm btn-outline-danger" wire:click="leave" wire:confirm="Are you sure you want to leave this workspace?">
                                                Leave
                                            </button>
                                        @endif
                                    @else
                                        @php
                                            $currentUserRole = $workspace->members()->where('user_id', Auth::id())->first()?->role;
                                        @endphp
                                        
                                        @if($currentUserRole === 'owner')
                                            @if($member->role === 'member')
                                                <button class="btn btn-sm btn-outline-primary me-1" wire:click="promoteMember({{ $member->id }})" wire:confirm="Are you sure you want to promote this member to admin?">
                                                    Promote to Admin
                                                </button>
                                            @elseif($member->role === 'admin')
                                                <button class="btn btn-sm btn-outline-success me-1" wire:click="promoteMember({{ $member->id }})" wire:confirm="Are you sure you want to make this admin the owner? You will become an admin.">
                                                    Make Owner
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning me-1" wire:click="demoteMember({{ $member->id }})" wire:confirm="Are you sure you want to demote this admin to member?">
                                                    Demote to Member
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-danger" wire:click="removeMember({{ $member->id }})" wire:confirm="Are you sure you want to remove this member?">
                                                Remove
                                            </button>
                                        @elseif($currentUserRole === 'admin')
                                            @if($member->role === 'member')
                                                <button class="btn btn-sm btn-outline-primary me-1" wire:click="promoteMember({{ $member->id }})" wire:confirm="Are you sure you want to promote this member to admin?">
                                                    Promote to Admin
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" wire:click="removeMember({{ $member->id }})" wire:confirm="Are you sure you want to remove this member?">
                                                    Remove
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    <!-- Invite Modal -->
    <div class="modal fade" id="inviteModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="invite">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email" placeholder="Enter user's email">
                            @error('email') 
                                <small class="d-block mt-1 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Invite</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 