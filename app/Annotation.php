<?php
namespace App;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
/**
 * @SWG\Swagger(
 *     basePath="/",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API documentation for Job Notify",
 *         @SWG\Contact(
 *             email=""
 *         ),
 *     )
 * )
 */
/**
 * @SWG\Post(
 *   path="/registration",
 *   summary="Version",
 *     @SWG\Parameter(name="name",in="query",description="Name",required=true,type="string"),
 *     @SWG\Parameter(name="email",in="query",description="Email",required=true,type="string"),
 *     @SWG\Parameter(name="phone",in="query",description="Phone",required=true,type="string"),
 *     @SWG\Parameter(name="password",in="query",description="Password",required=true,type="string"),
 *     @SWG\Parameter(name="country",in="query",description="Country ids",required=true,type="array",@SWG\Items(type="integer")),
*   @SWG\Response(
 *     response=200,
 *     description="Working"
 *   ),
 *   @SWG\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   )
 * )
 */

class Annotation extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
}
