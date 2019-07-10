<?php
namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;

class JobController extends Controller
{
    /**
     * Store Request Validation Rules
     *
     * @param Request $request
     * @return array
     */
    private function storeRequestValidationRules(Request $request)
    {
        $rules = [
            'country_id'    =>  'required',
            'city_id'       =>  'required',
            'category_id'   =>  'required',
            'subcategory_id' => 'required',
            'salary_min'    =>  'required',
            'salary_max'    =>  'required',
            'age_min'       =>  'required',
            'age_max'       =>  'required',
            'description'   =>  'required',
            'employee_requirements'   =>  'required',
            'education_id'   =>  'required',
            'experience_id'   =>  'required',
            'company_name'   =>  'required',
            'contact_person'   =>  'required',
            'email'   =>  'required',
            'phone'   =>  'required',
        ];

        return $rules;
    }

    public function store(Request $request)
    {
        // Validation
        $user = Auth::user();
        if ($user instanceof User && $user->is_company !== User::IS_COMPANY) {
            return responder()->error(400,'User  must be company.')->respond();
        }
        $validatorResponse = $this->validateRequest($request, $this->storeRequestValidationRules($request));

        // Send failed response if validation fails
        if ($validatorResponse !== true) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'data' => $validatorResponse
            ]);
        }

        $job = Job::create($request->all());
        $job->company_id = Auth::user()->getAuthIdentifier();
        $job->save();
        if (!$job instanceof Job) {
            return responder()->error(500,'User  must be company.')->respond();
        }
        return responder()->success($job)->respond();
    }

    public function index()
    {
        $jobs = Job::all();
        return responder()->success($jobs)->respond();
    }

    public function show($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $job = Job::where('id', $id)->first();

        if (!$job instanceof Job) {
            return responder()->error(400,"he job with id {$id} doesn't exist")->respond();
        }
        return responder()->success($job)->respond();
    }


}
