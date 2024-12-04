<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'created_by_user_id'
    ];

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
}
