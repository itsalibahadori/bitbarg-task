<?php

namespace App\Models;

use App\Enums\V1\TaskEnums;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'title',
        'status',
        'user_id',
        'due_date',
    ];

    /**
     * Get the user's first name.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => TaskEnums::from($value)->name,
            set: fn ($value) => TaskEnums::fromLabel($value)->value,
        );
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
