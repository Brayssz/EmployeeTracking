<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Travel;

class TrackingController extends Controller
{
    public function show(Request $request) 
    {
        $departments = Department::where('status', 'active')->get();
        $travels = Travel::all();
        return view('contents.tracking', compact('departments', 'travels'));
    }
}
