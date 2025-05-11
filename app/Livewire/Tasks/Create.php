<?php

namespace App\Livewire\Tasks;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use App\Models\Workspace;
use Livewire\Component;

class Create extends Component
{
    public Workspace $workspace;
    public TaskForm $form;
    
    public function mount()
    {
        $this->form->scheduled_at = now()->format('Y-m-d');
        $this->form->due_at = now()->addDays(7)->format('Y-m-d');
    }
    
    public function save() 
    {
        $this->authorize('create', [Task::class, $this->workspace]);
        
        $task = $this->form->store($this->workspace);
        
        $this->form->reset();

        $this->dispatch('task-created', message: 'Task created successfully!');
    }

    public function render()
    {
        return view('livewire.tasks.create');
    }
} 