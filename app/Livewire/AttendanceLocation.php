<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TravelUser;

class AttendanceLocation extends Component
{
    public function getTravelAttendance($travel_id)
    {
        $travel_user = TravelUser::query()->whereNotNull('coordinates')->with('user')->where('id', $travel_id);

        return $travel_user->get()->map(function ($item) {
            $coordinates = explode(',', $item->coordinates);
            return [
                'name' => $item->user->name ?? null,
                'lat' => isset($coordinates[0]) ? (float) trim($coordinates[0]) : null,
                'lng' => isset($coordinates[1]) ? (float) trim($coordinates[1]) : null,
            ];
        });
    }

    public function render()
    {
        return view('livewire.attendance-location');
    }
}
