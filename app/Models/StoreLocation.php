<?php

namespace App\Models;

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
        'location_name',
        'store_code',
        'managers_name',
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
}
