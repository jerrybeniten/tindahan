<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'created_by_user_id'
    ];
}
