<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionComponent extends Model
{
    protected $fillable = [
        'inspection_id',
        'component_id',
        'notes',
        'status',
    ];

    /**
     * Get the inspection that owns this component measurement.
     */
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    /**
     * Get the component being measured.
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the parameter values for this component.
     */
    public function values(): HasMany
    {
        return $this->hasMany(InspectionComponentValue::class);
    }

    /**
     * Get all measured parameters with their values.
     */
    public function parametersWithValues()
    {
        return $this->component->parameters()->with(['inspectionValues' => function ($query) {
            $query->where('inspection_component_id', $this->id);
        }]);
    }
}
