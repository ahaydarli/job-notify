<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Auth;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('auth/send-sms', ['uses' => 'AuthController@store']);
$router->post('auth/verify-user',['uses' =>'AuthController@verifyContact']);
$router->post('user/registration',['uses' =>'UserController@store']);
$router->post('company/registration',['uses' =>'UserController@store']);
$router->get('country',  'CountryController@index');
$router->get('country/{id}',  'CountryController@getCities');
$router->get('category/{category_id}',  'CategoryController@show');
$router->get('category',  'CategoryController@index');
$router->get('job', 'JobController@index');
$router->get('job/{id}', 'JobController@show');
$router->group(['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\Models\User::all();
            return response()->json($users);
        });
        $router->get('me', [
            'uses' => 'UserController@me'
        ]);
        $router->post('job', 'JobController@store');

    }
);
