<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'icon',
    ];

    /**
     * Get all aircraft belonging to this airline.
     */
    public function aircraft()
    {
        return $this->hasMany(Aircraft::class);
    }
}
