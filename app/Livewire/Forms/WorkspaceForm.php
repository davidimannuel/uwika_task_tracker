<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class WorkspaceForm extends Form
{
    #[Rule('required', 'string', 'min:3')]
    public string $name = '';

    public function store()
    {
        $validated = $this->validate();

        $user = Auth::user();

        $workspace = $user->workspaces()->create($validated);

        $this->reset();

        session()->flash('success-create', "Workspace {$workspace->name} created successfully.");
    }
}
