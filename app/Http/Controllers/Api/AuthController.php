<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Transformers\UserTransformer;

class AuthController extends BaseController {

    public function register(RegisterRequest $request) {
        $input = $request->all();
        $identicon = new \Identicon\Identicon();
        $imageDataUri = $identicon->getImageDataUri($input['username']);
        $user = User::create([
                    'username' => $input['username'],
                    'password' => bcrypt($input['password']),
                    'avatar'=>$imageDataUri
        ]);
        //自动登陆并返回token
        $token = $this->guard()->login($user, true);
        return $this->response->item($user, new UserTransformer())
                        ->setMeta($this->respondWithToken($token))
                        ->setStatusCode(201);
    }

    public function login(LoginRequest $request) {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if (!$token = $this->guard()->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        return $this->response->item($this->guard()->user(), new UserTransformer())
                        ->setMeta($this->respondWithToken($token))
                        ->setStatusCode(201);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

}
