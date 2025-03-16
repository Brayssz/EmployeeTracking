<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $query = User::with('department');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $employees = $query->paginate(10);

        $departments = Department::where('status', 'active')->get();
        // return(em)
        return view('contents.user-management', compact('employees', 'departments'));
    }
}
