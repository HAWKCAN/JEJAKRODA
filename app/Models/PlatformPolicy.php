<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PlatformPolicy extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'type', 'is_active'];

    /**
     * Scope untuk hanya mengambil policy yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }
}