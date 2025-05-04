<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TravelUser;
use App\Models\Travel;
use App\Models\UserLocation;

class Tracking extends Component
{

    public function getTravelAttendance($travel_id)
    {
        $user_locations = UserLocation::query()
            ->whereHas('user', function ($query) {
                $query->whereNotIn('status', ['onleave']);
            })
            ->with('user');

        // if ($travel_id) {
        //     $user_locations = $user_locations->where('travel_id', $travel_id);
        // }

        return $user_locations->get()->map(function ($item) {
            return [
                'name' => $item->user->name ?? null,
                'lat' => $item->latitude ?? null,
                'lng' => $item->longitude ?? null,
                'status' => $item->user->status ?? null,
            ];
        });
    }

    public function render()
    {
        return view('livewire.tracking');
    }
}
