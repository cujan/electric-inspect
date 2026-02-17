<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComponentParameter extends Model
{
    protected $fillable = [
        'component_id',
        'name',
        'label',
        'field_type',
        'is_required',
        'unit',
        'min_value',
        'max_value',
        'options',
        'order',
        'placeholder',
        'help_text',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'options' => 'json',
    ];

    /**
     * Get the component that owns this parameter.
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the inspection values for this parameter.
     */
    public function inspectionValues(): HasMany
    {
        return $this->hasMany(InspectionComponentValue::class);
    }

    /**
     * Scope: ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
