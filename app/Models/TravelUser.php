<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelUser extends Model
{
    use HasFactory;

    protected $table = 'travel_users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'travel_id',
        'user_id',
        'status',
        'coordinates',
        'time_recorded',
        'date_recorded',
        'remarks',
    ];

    // Relationship: TravelUser belongs to a Travel
    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id', 'travel_id');
    }

    // Relationship: TravelUser belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
