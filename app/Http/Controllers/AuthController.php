<?php
namespace App\Http\Controllers;
use App\Models\SmsVerification;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $code, $smsVerification, $request;

    function __construct(Request $request)
    {
        $this->smsVerifcation = new \App\Models\SmsVerification();
        $this->request = $request;

    }


    public function store(Request $request)
    {
        $code = rand(100000, 999999);
        $request['code'] = $code;
        $send = $this->sendSms($request);
        if(!$send){
            return responder()->error(400, 'Mesaage not sent!')->respond(400);
        }
        $sms = SmsVerification::create($request->all());
        return responder()->success($sms)->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyContact(Request $request)
    {
        $smsVerifcation = $this->smsVerifcation::where('code','=', $request->code)
                ->latest()
                ->first();
        if($smsVerifcation) {
            $request["status"] = SmsVerification::VERIFIED;
            $smsVerifcation->updateModel($request);
            $user = User::where('phone', $request['phone'])->first();
            if (!$user) {
                return responder()->success([
                    'phone' => $request->phone,
                    'registration' => true
                ])->respond(202);
            }
              return  responder()->success(['token' => $this->jwt($user)])->respond();
        } else {
            return responder()->error(400, 'Code is invalid!')->respond(400);
        }
    }


    public function sendSms($request)
    {
        //Todo Connect sms api
        return $request['code'];
    }


    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 365 * 24 * 60 * 60 // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

//        public function userAuthenticate(User $user) {
//            $this->validate($this->request, [
//                'phone'     => 'required',
//            ]);
//            $user = User::where('phone', $this->request['phone'])->first();
//            if (!$user) {
//                return response()->json([
//                    'error' => 'User does not exist.'
//                ], 400);
//            }
//            if ($user) {
//                return response()->json([
//                    'status'  => 200,
//                    'message' => 'Login Successful',
//                    'data'    => ['token' => $this->jwt($user) ]
//                ], 200);
//            }
//            return response()->json([
//                'error' => 'Login details provided does not exit.'
//            ], 400);
//        }

}
