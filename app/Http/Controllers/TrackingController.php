<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class TrackingController extends Controller
{
    public function show(Request $request) 
    {
        $departments = Department::where('status', 'active')->get();
        return view('contents.tracking', compact('departments'));
    }
}
