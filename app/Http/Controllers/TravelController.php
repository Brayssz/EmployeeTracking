<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travel;

class TravelController extends Controller
{
    public function show(Request $request)
    {
        $query = Travel::query();

        if ($request->has('search')) {
            $query->where('purpose', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);
            if (count($dates) === 2) {
                $query->whereDate('start_date', '>=', $dates[0])
                      ->whereDate('end_date', '<=', $dates[1]);
            } elseif (count($dates) === 1) {
                $query->whereDate('start_date', '<=', $dates[0])
                      ->whereDate('end_date', '>=', $dates[0]);
            }
        }

        $travels = $query->paginate(10);

        return view('contents.travel-management', compact('travels'));
    }
}
