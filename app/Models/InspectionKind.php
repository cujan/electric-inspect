<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionKind extends Model
{
    protected $fillable = [
        'inspection_type_id',
        'name',
        'description',
        'order',
    ];

    /**
     * Get the inspection type that owns this kind.
     */
    public function inspectionType(): BelongsTo
    {
        return $this->belongsTo(InspectionType::class);
    }

    /**
     * Get the fields for this inspection kind.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(InspectionKindField::class)->orderBy('order');
    }

    /**
     * Get the inspections of this kind.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    /**
     * Scope: ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
