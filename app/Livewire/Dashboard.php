<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $user;

    public function getTaskStats()
    {
        $startOfQuarter = Carbon::now()->startOfQuarter();
        $endOfQuarter = Carbon::now()->endOfQuarter();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'total_this_quarter' => Task::where('assigned_to', Auth::id())
                ->whereBetween('created_at', [$startOfQuarter, $endOfQuarter])
                ->count(),

            'due_this_month_tasks' => Task::where('assigned_to', Auth::id())
                ->whereBetween('due_at', [$startOfMonth, $endOfMonth])
                ->where('status', '!=', 'done')
                ->with(['workspace'])
                ->orderBy('due_at')
                ->take(3)
                ->get(),

            'in_progress_tasks' => Task::where('assigned_to', Auth::id())
                ->where('status', 'in_progress')
                ->with(['workspace'])
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),

            'completed_this_month' => Task::where('assigned_to', Auth::id())
                ->where('status', 'done')
                ->whereBetween('finished_at', [$startOfMonth, $endOfMonth])
                ->count(),
        ];
    }

    public function getRecentActivity()
    {
        $workspaceIds = Workspace::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })->pluck('id');

        return Task::whereIn('workspace_id', $workspaceIds)
            ->with(['workspace', 'creator', 'assignee'])
            ->latest()
            ->take(5)
            ->get();
    }

    public function getUpcomingTasks()
    {
        return Task::where('assigned_to', Auth::id())
            ->where('status', '!=', 'done')
            ->where('due_at', '>=', now())
            ->where('due_at', '<=', now()->addDays(7))
            ->with(['workspace', 'assignee'])
            ->orderBy('due_at')
            ->take(5)
            ->get();
    }

    public function getMyTasks()
    {
        $workspaceIds = Workspace::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })->pluck('id');

        return [
            'todo' => Task::whereIn('workspace_id', $workspaceIds)
                ->where('assigned_to', Auth::id())
                ->where('status', 'todo')
                ->with(['workspace'])
                ->orderBy('due_at')
                ->take(3)
                ->get(),

            'in_progress' => Task::whereIn('workspace_id', $workspaceIds)
                ->where('assigned_to', Auth::id())
                ->where('status', 'in_progress')
                ->with(['workspace'])
                ->orderBy('due_at')
                ->take(3)
                ->get(),

            'done' => Task::whereIn('workspace_id', $workspaceIds)
                ->where('assigned_to', Auth::id())
                ->where('status', 'done')
                ->with(['workspace'])
                ->orderBy('finished_at')
                ->take(3)
                ->get(),
        ];
    }

    public function getWorkspaceSummary()
    {
        return Workspace::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })
        ->withCount(['tasks', 'members'])
        ->get();
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'taskStats' => $this->getTaskStats(),
            'recentActivity' => $this->getRecentActivity(),
            'upcomingTasks' => $this->getUpcomingTasks(),
            'myTasks' => $this->getMyTasks(),
            'workspaces' => $this->getWorkspaceSummary(),
        ]);
    }
}
