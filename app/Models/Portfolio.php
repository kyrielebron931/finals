<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'slug', 'full_name', 'profile_picture', 'email', 'contact_number',
    'address', 'about', 'education', 'skills', 'projects', 'experience', 'links', 'template',
])]
class Portfolio extends Model
{
    protected function casts(): array
    {
        return [
            'education' => 'array',
            'skills' => 'array',
            'projects' => 'array',
            'experience' => 'array',
            'links' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
