<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class StoreLocation extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    // The attributes that are mass assignable
    protected $fillable = [
        'uuid',
        'store_id',
        'location_name',
        'store_code',
        'manager_name',
        'email',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'is_active',
        'opening_hours'
    ];

    // Enable soft delete timestamps
    protected $dates = ['deleted_at'];

    // Accessor to return human-readable date and time
    public function getCreatedAtAttribute($value)
    {
        $carbonDate = Carbon::parse($value); // Parse only once

        $diff = $carbonDate->diffForHumans(); // Get the relative time
        $dateTime = $carbonDate->format('l, F j, Y g:i A'); // Get the full date-time

        return $diff . ': ' . $dateTime; // Combine them
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
