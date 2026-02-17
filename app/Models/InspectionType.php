<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionType extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'icon',
        'color',
        'order',
    ];

    /**
     * Get the organization that owns the inspection type.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the inspection kinds for this type.
     */
    public function kinds(): HasMany
    {
        return $this->hasMany(InspectionKind::class)->orderBy('order');
    }

    /**
     * Scope: ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
