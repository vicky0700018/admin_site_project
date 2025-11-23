<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'mobile',
        'dob',
        'gender',
    ];

    protected $casts = [
        'dob' => 'date',
    ];


    public function documents()
    {
        return $this->hasOne(LeadDocument::class);
    }
}
