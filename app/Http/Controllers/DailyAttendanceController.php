<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyAttendance;
use App\Models\Department;
use App\Models\User;

class DailyAttendanceController extends Controller
{
    public function show(Request $request)
    {
        $query = DailyAttendance::whereHas('user', function ($q) {
            $q->where('status', 'active');
        });

        if ($request->filled('search')) {
            $query->where('status', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%{$request->search}%"]);
                  });
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', now()->toDateString());
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('department')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $users = User::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        $dailyAttendances = $query->paginate(10);

        return view('contents.daily-attendance', compact('dailyAttendances', 'users', 'departments'));
    }
}
