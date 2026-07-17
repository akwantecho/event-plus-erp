<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'issue_date' => 'date',
        'event_from' => 'date',
        'event_to' => 'date',
        'timeline' => 'array',
        'notices' => 'array',
        'installments' => 'array',
        'approved_at' => 'datetime',
        'grand_total' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class)->orderBy('position');
    }

    /** Grand total = sum of the cost rows' totals. */
    public function getComputedTotalAttribute(): float
    {
        return (float) $this->items->sum('total');
    }
}
