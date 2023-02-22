<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\Customers as CustomerServices;

class CustomerController extends Controller
{
    protected $userService;

    public function __construct(CustomerServices $user)
    {
        $this->userService = $user;
    }
    
    public function login(Request $request)
    {
        $params = $request->all();
        $validate = $this->userService->validationLogin($request);
        if($validate['error']) {
            return $this->error($validate['message'],$validate['data'],$validate['code']);
        }

        $login = $this->userService->login($request);
        if($login['error']) {
            return $this->error($login['message'],$login['data'],$login['code']);
        }

        return $this->success($login['message'],$login['data']);
    }

    public function all(Request $request)
    {
        $params = $request->all();
        $usersdata = $this->userService->get_all_data($params);

        return $this->success($usersdata['message'], $usersdata['data']);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'name' => 'required|max:180',
            'email' => 'required|email|unique:App\Models\Customers,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'gender' => 'nullable|in:L,P',
            'is_married' => 'nullable|numeric|in:0,1',
            'address' => 'nullable|max:360'
        ]);
        if ($validator->fails()) {
            return $this->error('Unprocessable Entity', $validator->errors(), 422);
        }

        $execute = $this->userService->store_data($params);
        if($execute['error']){
            return $this->error($execute['message'], $execute['data'], $execute['code']);
        }

        return $this->success($execute['message'], $execute['data'], $execute['code']);
    }

    public function update(string $uid, Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'name' => 'nullable|max:180',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
            'is_married' => 'nullable|numeric|in:0,1',
            'address' => 'nullable|max:360'
        ]);
        if ($validator->fails()) {
            return $this->error('Unprocessable Entity', $validator->errors(), 422);
        }

        $execute = $this->userService->update_data($uid, $params);
        if($execute['error']){
            return $this->error($execute['message'], $execute['data'], $execute['code']);
        }

        return $this->success($execute['message'], $execute['data'], $execute['code']);
    }

    public function detail(string $uid)
    {
        $execute = $this->userService->get_single_customer($uid);
        if($execute['error']){
            return $this->error($execute['message'], $execute['data'], $execute['code']);
        }

        return $this->success($execute['message'], $execute['data'], $execute['code']);
    }

    public function destroy(string $uid)
    {
        $execute = $this->userService->delete_data($uid);
        if($execute['error']){
            return $this->error($execute['message'], $execute['data'], $execute['code']);
        }

        return $this->success($execute['message'], $execute['data'], $execute['code']);
    }
}
