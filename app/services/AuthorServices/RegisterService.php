<?php

namespace App\services\AuthorServices;

use App\Models\Author;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterService
{
    protected $model;
    function __construct()
    {
        $this->model = new Author();
    }

    function register($request)
    {
        try {
            DB::beginTransaction();
            $data = $this->validation($request);
            $author = $this->store($data , $request);

            $this->model = $author;
            $storeToken = $this->generateToken($author->email);

            $this->sendEmail();
            DB::commit();

            return response()->json([
                "message" => "account has been created check your email"
            ]);
        }catch (Exception $e){
            DB::rollBack();

            return response()->json(["error" => $e->getMessage()], 400);
        }



    }

    public function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        return $validator;
    }
    function store($data , $request)
    {
        $author = $this->model->create(array_merge(
            $data->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return $author;
    }
    function generateToken($email)
    {
        $token = substr(md5( rand(0 , 9) . $email . time()) , 0 , 32);
        $this->model->verification_token = $token;
        $this->model->save();

        return $token;
    }

    function sendEmail()
    {

    }
}
