<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionKindValue extends Model
{
    protected $fillable = [
        'inspection_id',
        'inspection_kind_field_id',
        'value',
    ];

    /**
     * Get the inspection that owns this value.
     */
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    /**
     * Get the field definition.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(InspectionKindField::class, 'inspection_kind_field_id');
    }
}
