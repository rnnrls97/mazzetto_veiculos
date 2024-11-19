<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    public function getCities(State $state)
    {
        return response()->json($state->cities);
    }

    public function stateCities()
    {
        $states = State::with('cities')->get();
        return response()->json($states);
    }
}
