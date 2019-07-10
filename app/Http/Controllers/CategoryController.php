<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::where('type_id', Category::PARENT)->get();

        return responder()->success($categories)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function show($category_id)
    {
        $category_id = filter_var($category_id, FILTER_SANITIZE_NUMBER_INT);
        $categories = Category::where('parent_id', $category_id)->get();

        return responder()->success($categories)->respond();
    }


}
