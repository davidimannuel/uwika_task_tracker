<?php

namespace App\Livewire\Tasks;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use App\Models\Workspace;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public Workspace $workspace;
    public TaskForm $form;
    public ?Task $taskToDuplicate = null;
    
    public function mount()
    {
        if ($this->taskToDuplicate) {
            $this->form->fill([
                'title' => $this->taskToDuplicate->title,
                'description' => $this->taskToDuplicate->description,
                'assigned_to' => $this->taskToDuplicate->assigned_to,
                'scheduled_at' => $this->taskToDuplicate->scheduled_at?->format('Y-m-d'),
                'due_at' => $this->taskToDuplicate->due_at?->format('Y-m-d'),
            ]);
        } else {
            $this->form->scheduled_at = now()->format('Y-m-d');
            $this->form->due_at = now()->addDays(7)->format('Y-m-d');
        }
    }
    
    public function save() 
    {
        $this->authorize('create', [Task::class, $this->workspace]);
        
        $task = $this->form->store($this->workspace);
        
        $this->form->reset();

        $this->dispatch('task-created', message: 'Task created successfully!');
    }

    #[On('populate-create-form')]
    public function populateForm($data)
    {
        $this->form->fill([
            'title' => $data['title'],
            'description' => $data['description'],
            'assigned_to' => $data['assigned_to'],
            'scheduled_at' => $data['scheduled_at'],
            'due_at' => $data['due_at'],
        ]);
    }

    #[On('show-create-form')]
    public function initializeForm($data)
    {
        if (isset($data['task'])) {
            $this->form->fill($data['task']);
        }
    }

    public function close()
    {
        $this->dispatch('close-create-form');
    }

    public function render()
    {
        return view('livewire.tasks.create');
    }
} 