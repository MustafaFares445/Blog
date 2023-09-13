<?php

namespace App\services\AdminServices;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
class LoginService
{
    protected Author $model;
    function __construct()
    {
        $this->model = new Author();
    }

    public function login($request): \Illuminate\Http\JsonResponse
    {
        $validator = $this->validation($request);
        $token = $this->isValidData($validator);

        return $this->createNewToken($token);
    }


    public function validation($request): \Illuminate\Validation\Validator|\Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }

    function isValidData($data): \Illuminate\Http\JsonResponse|bool
    {
        if (! $token = auth()->guard('admin')->attempt($data->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $token;
    }

    protected function createNewToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('admin')->user()
        ]);
    }

}
