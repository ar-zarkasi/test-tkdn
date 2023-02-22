<?php

namespace App\Services;

use App\Interfaces\CustomerInterface;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\{
    Hash,
    Validator,
    Auth,
    Password,
    DB
};
use App\Http\Resources\{CustomersResource, CustomerDetailResource};

use App\Traits\ReturnServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Customers
{
    use ReturnServices;

    private $regex_email = '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$';
    private $regex_phone = '^(?:(?:\+|00) [1-9] [0-9]{0,2}|0)[1-9][0-9]{9}$';
    /**
     * The auth repository instance.
     *
     * @var \App\Repositories\AuthRepository
     */
    protected $authRepository;

    /**
     * Create a new service instance.
     *
     * @param  \App\Repositories\AuthRepository  $authRepository
     * @return void
     */
    public function __construct(CustomerInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Attempt to log the user in.
     *
     * @param  array  $credentials
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->authRepository->getUserByEmail($request->only('email'));
        // Check if the user exists
        if(!$user->id) {
            $message = 'User Not Registered!';
            return $this->response(['user'=>$message],$message,true,422);
        }
        // if the password is correct
        if (!Hash::check($request->only('password'), $user->password)) {
            $message = 'Invalid credentials';
            return $this->response(['password'=>$message],true,422);
        }

        // Generate a JWT token
        $expired = Carbon::now()->addMinutes(env('SESSION_LIFETIME',120)); // time expired
        $data = (new CustomersResource($user))->jsonSerialize();
        $data['client'] = $request->header('tn-client');

        // store a generate token and add to cache
        $token = $user->createToken($user->uuid,['*'],$expired);
        $data['token'] = $token->plainTextToken;
        $data['expired_at'] = $expired->toDateTimeString();
        
        // Return the token
        return $this->response($data,'Successfully Login');
    }

    public function validationLogin(Request $request)
    {
        $rules = [
            'username' => 'required_without_all:email,phone',
            'email' => 'required_without_all:username,phone|email',
            'phone' => "required_without_all:username,email|regex:$this->regex_phone",
            'password' => 'required',
            'deviceos' => 'nullable',
            'devicedata' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $error = $this->errorValidation($validator);
            return $this->response($validator->errors()->getMessages(),$error,true,422);
        }

        return $this->response();
    }

    public function get_all_data($params)
    {
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        
        try {
            $data = $this->authRepository->getAllUsers($limit);
            $data = CustomersResource::collection($data)->jsonSerialize();
            return $this->response($data, 'Fetch All Data Successfully');
        } catch (\Throwable $th) {
            return $this->response([], $th->getMessage(), true, 500);
        }
    }

    public function get_single_customer(string $uid)
    {
        $user = $this->authRepository->getUserByUuid($uid);
        if(!$user->id){
            return $this->response([], "User Not Found!", true, 404);
        }
        $data = (new CustomerDetailResource($user))->jsonSerialize();
        return $this->response($data,"Data $user->name Received");
    }

    public function store_data($params)
    {
        DB::beginTransaction();
        try {
            $params['password'] = Hash::make($params['password']);
            unset($params['confirm_password']);
            $stored = $this->authRepository->store($params);
            $resource = (new CustomersResource($stored))->jsonSerialize();
            DB::commit();
            return $this->response($resource, 'Succesfully Created Customers',false, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response([], $th->getMessage(), true, 500);
        }
    }

    public function update_data($id, $params)
    {
        DB::beginTransaction();
        try {
            $user = $this->authRepository->getUserByUuid($id);
            if(!$user->id){
                DB::rollBack();
                return $this->response([], "User with $id, Not Found!", true, 404);
            }
            $updated = $this->authRepository->update($user, $params);
            $resource = (new CustomersResource($updated))->jsonSerialize();
            DB::commit();
            return $this->response($resource, 'Succesfully Update Customers');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response([], $th->getMessage(), true, 500);
        }
    }
    
    public function delete_data(string $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->authRepository->getUserByUuid($id);
            if(!$user->id){
                DB::rollBack();
                return $this->response([], "User with $id, Not Found!", true, 404);
            }
            $deleted = $this->authRepository->destroy($user->id);
            if(!$deleted) {
                throw new \Exception('Gagal Menghapus Data Customer '.$id);
            }
            DB::commit();
            return $this->response(null, 'Succesfully Delete Customers');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response([], $th->getMessage(), true, 500);
        }
    }
}
