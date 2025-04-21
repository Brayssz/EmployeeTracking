<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelUser;
use App\Models\Travel;
use App\Models\Department;

class TravelAttendanceController extends Controller
{
    public function show(Request $request)
    {
        $query = TravelUser::query();

        if ($request->filled('search')) {
            $query->where('remarks', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%')
              ->orWhereHas('travel', function ($q) use ($request) {
                  $q->where('purpose', 'like', '%' . $request->search . '%');
              })
              ->orWhereHas('user', function ($q) use ($request) {
                $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%{$request->search}%"]);
              });
        }   
        
        if ($request->filled('department_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        if ($request->filled('travel_id')) {
            $query->where('travel_id', $request->travel_id);
        }

        $travels = Travel::all();
        $departments = Department::where('status', 'active')->get();
        $travelUsers = $query->paginate(10);

        return view('contents.travel-attendance', compact('travelUsers', 'travels', 'departments'));
    }
}
