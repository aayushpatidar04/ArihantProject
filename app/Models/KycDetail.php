<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_registration_id', 'pan_number', 'aadhaar_number',
        'address', 'city', 'state', 'pincode',
        'income_proof_type', 'income_proof_path',
        'photo_path', 'signature_path',
        'validation_status', 'validation_notes'
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}
