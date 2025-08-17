<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\City;
    use App\Models\Municipality;
    use App\Models\Parish;
    use Illuminate\Http\Request;

    class LocationController extends Controller
    {
        public function getCities($state_id)
        {
            $cities = City::where('state_id', $state_id)->get();
            return response()->json($cities);
        }

        public function getMunicipalities($city_id)
        {
            $municipalities = Municipality::where('city_id', $city_id)->get();
            return response()->json($municipalities);
        }

        public function getParishes($municipality_id)
        {
            $parishes = Parish::where('municipality_id', $municipality_id)->get();
            return response()->json($parishes);
        }
    }
