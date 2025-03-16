<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function show(Request $request)
    {
        $query = Department::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $departments = $query->paginate(10);

        return view('contents.department-management', compact('departments'));
    }
   
}
