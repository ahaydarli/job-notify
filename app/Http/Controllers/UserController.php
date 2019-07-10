<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Transformers\UserTransformer;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 365 * 24 * 60 * 60 // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function me(Request $request)
    {
        return responder()->success($request->auth, UserTransformer::class)->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $rules = [
            'email'                 => 'email|required|unique:users',
            'name'                  => 'required|max:100',
            'category'              => 'required',
            'subcategory'           => 'required',
            'phone'                 => 'required',
            'country'               => 'required',
            'city'                  => 'required',
            'user_agreement'        => 'required|in:1',
//            'salary_min'            => 'required',
//            'date_of_birth'         => 'required',
//            'education'             => 'required',
//            'experience'             => 'required',
        ];
        $validatorResponse = $this->validateRequest($request, $rules);
        if ($validatorResponse !== true) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'data' => $validatorResponse
            ]);
        }
        $request['is_activated'] = 1;
        $request['uid'] = Uuid::uuid4();
        $user = User::create($request->all());
        if (!$user instanceof User) {
            return responder()->error('500', 'Error occurred on creating User')->respond();
        }
        //Todo country all cities all-id
        $user->category()->sync($request['category']);
        $user->subCategory()->sync($request['subcategory']);
        $user->country()->sync($request['country']);
        $user->city()->sync($request['city']);

        return responder()->success(['token' => $this->jwt($user)])->respond();
    }


    public function companyRegistration(Request $request)
    {
        $rules = [
            'email'                 => 'email|required|unique:users',
            'name'                  => 'required|max:100',
            'phone'                 => 'required|max:20',
            'password'              => 'required|min:5',
            'user_agreement'        => 'required|in:1',
        ];
        $validatorResponse = $this->validateRequest($request, $rules);
        if ($validatorResponse !== true) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'data' => $validatorResponse
            ]);
        }
        $request['is_activated'] = 1;
        $request['uid'] = Uuid::uuid4();
        $request['is_company'] = User::IS_COMPANY;
        $user = User::create($request->all());
        if (!$user instanceof User) {
            return responder()->error('500', 'Error occurred on creating User')->respond();
        }
        return responder()->success(['token' => $this->jwt($user)])->respond();
    }

    //Todo User profile edit and image upload

}
