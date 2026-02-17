<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Component extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'icon',
        'order',
    ];

    /**
     * Get the organization that owns the component.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the parameters for this component.
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(ComponentParameter::class)->orderBy('order');
    }

    /**
     * Get the inspection components of this type.
     */
    public function inspectionComponents(): HasMany
    {
        return $this->hasMany(InspectionComponent::class);
    }

    /**
     * Scope: ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
