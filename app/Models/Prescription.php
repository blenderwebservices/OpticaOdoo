<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_name',
        'sph_od',
        'cyl_od',
        'axis_od',
        'add_od',
        'sph_os',
        'cyl_os',
        'axis_os',
        'add_os',
        'pd',
        'issue_date',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
