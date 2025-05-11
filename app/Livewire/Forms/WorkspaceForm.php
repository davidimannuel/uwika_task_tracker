<?php

namespace App\Livewire\Forms;

use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class WorkspaceForm extends Form
{
    #[Rule('required', 'string', 'min:3')]
    public string $name = '';

    #[Rule('nullable', 'string')]
    public ?string $description = '';

    public function store()
    {
        $validated = $this->validate();

        $user = Auth::user();

        $workspace = Workspace::create([
            ...$validated,
            'created_by' => $user->id,
        ]);

        // Create member with owner role
        $workspace->members()->create([
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $this->reset();

        session()->flash('success-create', "Workspace created successfully.");

        return $workspace;
    }

    public function update(Workspace $workspace)
    {
        // You might want different validation rules for update vs create.
        // For example, if a name must be unique but can be the same as the current one.
        // #[Rule(['required', 'string', 'min:3', Rule::unique('workspaces')->ignore($workspace->id)])]
        // public string $name = '';

        $validated = $this->validate(); // This will use the rules defined on the properties

        // Ensure only fillable attributes are updated
        // If 'name' is the only updatable field via this form:
        $workspace->fill($validated);
        $workspace->save();

        $this->reset(); // Reset form after successful update

        return $workspace;
    }
}
