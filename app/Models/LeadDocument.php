<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'aadhaar_front',
        'aadhaar_back',
        'pan_front',
        'pan_back',
        'other_docs',
    ];

    // Relation: Document belongs to a Lead
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
