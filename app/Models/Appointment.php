<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'optometrist_id',
        'patient_name',
        'email',
        'phone',
        'appointment_date',
        'time_slot',
        'status',
        'reason',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function optometrist()
    {
        return $this->belongsTo(User::class, 'optometrist_id');
    }
}
