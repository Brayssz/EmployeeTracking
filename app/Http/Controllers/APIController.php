<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\TravelUser;
use App\Models\Travel;
use App\Models\Department;

class APIController extends Controller
{
    public function login(Request $request){

        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => collect($e->errors())->flatten()->first(),
                'data' => []
            ], 422);
        }
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->where('position', 'Employee')->first();

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => []
            ], 200);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid password',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [$user]
            ]
        );
    }

    public function getUserTravels(Request $request) 
    {
        $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $request->input('user_id');

        $travels = TravelUser::where('user_id', $userId)
            ->whereNull('date_recorded')
            ->with(['travel' => function ($query) {
                $query->select('travel_id', 'purpose'); // Only select the travel_id and purpose
            }])
            ->get()
            ->map(function ($travelUser) {
                return [
                    'travel_user_id' => $travelUser->id, // Include the travel user ID
                    'purpose' => $travelUser->travel->purpose ?? null, // Include the purpose
                ];
            })
            ->filter(function ($travel) {
                return $travel['purpose'] !== null; // Filter out null purposes
            });

        return response()->json([
            'status' => 'success',
            'message' => 'User travel purposes retrieved successfully',
            'data' => $travels->values()
        ]);
    }

    public function recordTravel(Request $request)
    {
        $request->validate([
            'travel_user_id' => 'required|integer',
            'coordinates' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $travelUser = TravelUser::find($request->input('travel_user_id'));

        if (!$travelUser) {
            return response()->json([
                'status' => 'error',
                'message' => 'Travel user not found',
                'data' => []
            ], 404);
        }

        $travelUser->update([
            'coordinates' => $request->input('coordinates'),
            'remarks' => $request->input('remarks'),
            'time_recorded' => now(),
            'date_recorded' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Travel recorded successfully',
            'data' => [$travelUser]
        ]);
    }
}
