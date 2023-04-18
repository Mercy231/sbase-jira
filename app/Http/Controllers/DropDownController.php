<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class DropDownController extends Controller
{
    public function index ()
    {
        $countries = Country::get(['name','id']);
        return view('register', ['countries' => $countries, 'error' => '']);
    }
    public function getStates (Request $request)
    {
        $states = State::where('country_id', '=', $request->country_id)->get(['name','id']);
        return response()->json(['success' => true, 'states' => $states]);
    }
    public function getCities (Request $request)
    {
        $cities = City::where('state_id', '=', $request->state_id)->get(['name','id']);
        return response()->json(['success' => true, 'cities' => $cities]);
    }
}
