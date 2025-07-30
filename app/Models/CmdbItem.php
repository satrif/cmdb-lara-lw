<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CmdbItem extends Model
{
    protected $fillable = ['name', 'type', 'description'];

    public function attributes(): HasMany
    {
        return $this->hasMany(CmdbAttribute::class);
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(CmdbItem::class, 'cmdb_relationships', 'parent_id', 'child_id')
            ->withPivot('relationship_type')
            ->withTimestamps();
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(CmdbItem::class, 'cmdb_relationships', 'child_id', 'parent_id')
            ->withPivot('relationship_type')
            ->withTimestamps();
    }
}
