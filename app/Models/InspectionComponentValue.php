<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionComponentValue extends Model
{
    protected $fillable = [
        'inspection_component_id',
        'component_parameter_id',
        'value',
        'unit',
    ];

    /**
     * Get the inspection component that owns this value.
     */
    public function inspectionComponent(): BelongsTo
    {
        return $this->belongsTo(InspectionComponent::class);
    }

    /**
     * Get the parameter definition.
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(ComponentParameter::class, 'component_parameter_id');
    }
}
