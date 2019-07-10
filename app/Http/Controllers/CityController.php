<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = City::all();
        return responder()->success($cities)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function show(Request $request)
    {
        $cities = City::all()->where('country_id', $request['country_id']);

        return responder()->success($cities)->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities(Request $request)
    {
        $cities = City::whereIn('country_id', $request['country_id'])->get();
        return responder()->success($cities)->respond();
    }


}
