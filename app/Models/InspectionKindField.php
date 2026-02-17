<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionKindField extends Model
{
    protected $fillable = [
        'inspection_kind_id',
        'name',
        'label',
        'field_type',
        'is_required',
        'order',
        'options',
        'placeholder',
        'help_text',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'options' => 'json',
    ];

    /**
     * Get the inspection kind that owns this field.
     */
    public function inspectionKind(): BelongsTo
    {
        return $this->belongsTo(InspectionKind::class);
    }

    /**
     * Get the values for this field.
     */
    public function values(): HasMany
    {
        return $this->hasMany(InspectionKindValue::class);
    }

    /**
     * Scope: ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
