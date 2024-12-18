<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    use HasFactory, Notifiable, SoftDeletes;    

    // The attributes that are mass assignable
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'created_by_user_id'
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

    /**
     * Get the user that owns the store.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function storeLocations()
    {
        return $this->hasMany(StoreLocation::class, 'store_id');
    }
}
