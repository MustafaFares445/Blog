<?php

namespace App\services\UserServices;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
class LoginService
{
    protected $model;
    function __construct()
    {
        $this->model = new Author();
    }

    public function login($request)
    {
        $validator = $this->validation($request);
        $token = $this->isValidData($validator);

        return $this->createNewToken($token);
    }


    public function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }


    function isValidData($data)
    {
        if (! $token = auth()->guard('user')->attempt($data->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $token;
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('user')->user()
        ]);
    }

}
