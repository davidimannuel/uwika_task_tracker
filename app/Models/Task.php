<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',
        'title',
        'description',
        'status',
        'scheduled_at',
        'due_at',
        'assigned_to',
        'created_by',
    ];

    protected $attributes = [
        'status' => 'todo',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Handle status changes
     */
    public function updateStatus(string $newStatus): void
    {
        DB::transaction(function () use ($newStatus) {
            $oldStatus = $this->status;
            $this->status = $newStatus;

            // Update timestamps based on status change
            switch ($newStatus) {
                case 'in_progress':
                    $this->started_at = now();
                    break;
                case 'done':
                    $this->finished_at = now();
                    break;
                case 'closed':
                    $this->closed_at = now();
                    break;
            }

            $this->save();
        });
    }
}
