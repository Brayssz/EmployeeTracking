<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Travel;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberToCarrierMapper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TrackingController extends Controller
{
    public function show(Request $request) 
    {
        $departments = Department::where('status', 'active')->get();
        $travels = Travel::all();
        return view('contents.tracking', compact('departments', 'travels'));
    }
}
