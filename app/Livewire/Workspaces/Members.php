<?php

namespace App\Livewire\Workspaces;

use App\Models\Member;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Members extends Component
{
    use WithPagination;

    public Workspace $workspace;
    public $email = '';
    public $search = '';

    public function mount(Workspace $workspace)
    {
        $this->workspace = $workspace;
    }

    public function invite()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $this->email)->first();

        // Check if user is already a member
        if ($this->workspace->members()->where('user_id', $user->id)->exists()) {
            $this->addError('email', 'User is already a member of this workspace.');
            return;
        }

        // Add user as member
        $this->workspace->members()->create([
            'user_id' => $user->id,
            'role' => 'member',
        ]);

        $this->email = '';
        $this->dispatch('show-alert', message: 'User has been invited to the workspace.', type: 'success');
    }

    public function removeMember($memberId)
    {
        $member = Member::findOrFail($memberId);
        
        // Only allow admin/owner to remove members
        if (!in_array($this->workspace->members()->where('user_id', Auth::id())->first()?->role, ['admin', 'owner'])) {
            $this->dispatch('show-alert', message: 'You do not have permission to remove members.', type: 'error');
            return;
        }

        $member->delete();
        $this->dispatch('show-alert', message: 'Member has been removed from the workspace.', type: 'success');
    }

    public function leave()
    {
        $member = $this->workspace->members()->where('user_id', Auth::id())->first();
        
        if ($member && $member->role !== 'owner') {
            $member->delete();
            $this->dispatch('show-alert', message: 'You have left the workspace.', type: 'success');
            return redirect()->route('workspaces.index');
        }

        $this->dispatch('show-alert', message: 'Owner cannot leave the workspace.', type: 'error');
    }

    public function render()
    {
        $members = $this->workspace->members()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.workspaces.members', [
            'members' => $members,
        ]);
    }
} 