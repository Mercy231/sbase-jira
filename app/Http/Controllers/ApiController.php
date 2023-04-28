<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function weather ()
    {
        return view('api.weather');
    }
    public function getWeather (Request $request)
    {
        if (!$request->country || !$request->city) {
            return response()->json(["error" => "Country and city fields required"]);
        } else {
            $country = ucfirst(trim($request->country));
            $city = ucfirst(trim($request->city));
        }

        if (!$request->dateFrom && !$request->dateTo) {
            $dateFrom = Carbon::now()->format("Y-m-d");
            $dateTo = Carbon::now()->addDays(5)->format("Y-m-d");
        } elseif (!$request->dateFrom || !$request->dateTo) {
            return response()->json(["error" => "Invalid date fields, all required"]);
        } else {
            $dateFrom = $request->dateFrom;
            $dateTo = $request->dateTo;
        }

        if ($dateFrom < Carbon::now()->format("Y-m-d") ||
            $dateTo >  Carbon::now()->addDays(5)->format("Y-m-d")
        ) {
            return response()->json(["error" => "Invalid date fields"]);
        }

        $key = env('WEATHERMAP_KEY');
        $getCoordsUrl = "http://api.openweathermap.org/geo/1.0/direct?q=$city,$country&appid=$key";
        $cords = json_decode(file_get_contents($getCoordsUrl), true);
        $lat = $cords[0]["lat"];
        $lon = $cords[0]["lon"];

        $url = "http://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&appid=$key";
        $weather = json_decode(file_get_contents($url), true);
        $data = Array();
        foreach ($weather["list"] as $item) {
            if ($dateFrom > $dateTo) {
                break;
            } elseif ($item["dt_txt"] == $dateFrom . " 21:00:00") {
                $data[] = $item;
                $dateFrom = Carbon::parse($dateFrom)->addDays(1)->format("Y-m-d");
            }
        }
        $html = view("components.weatherDay")->with(["data" => $data])->render();
        return response()->json(["html" => $html]);
    }
}
