<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Travel extends Model
{
    use HasFactory;

    protected $primaryKey = 'travel_id';
    protected $fillable = ['user_id', 'remarks', 'purpose', 'location_coordinates', 'travel_date', 'status'];

    /**
     * Get the user that owns the travel.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}