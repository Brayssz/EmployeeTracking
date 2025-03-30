<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'travels';
    protected $primaryKey = 'travel_id';
    public $timestamps = true;

    protected $fillable = [
        'purpose',
        'description',
        'start_date',
        'end_date',
    ];

    public function participants()
    {
        return $this->hasMany(TravelUser::class, 'travel_id', 'travel_id');
    }
}