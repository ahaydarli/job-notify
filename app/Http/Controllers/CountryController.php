<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = Country::all();
        return responder()->success($cities)->respond();
    }

    public function getCities($country_id)
    {
        $country_id = filter_var($country_id, FILTER_SANITIZE_NUMBER_INT);
        $cities = City::where('country_id', $country_id)->get();
        return responder()->success($cities)->respond();

    }

}
