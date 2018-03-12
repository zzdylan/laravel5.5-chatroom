<?php

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['middleware' => ['serializer:array', 'cors'], 'namespace' => 'App\Http\Controllers\Api'], function ($api) {
    #用户注册接口
    $api->post('/register', ['uses' => 'AuthController@register']);
    #用户登录接口
    $api->post('/login', ['uses' => 'AuthController@login']);
    $api->group(['middleware' => ['auth:api']], function ($api) {
        #获取用户个人信息
        $api->post('/me', ['uses' => 'UserController@me']);
        $api->post('/bind',['uses'=>'ChatController@bind']);
        $api->post('/send_text',['uses'=>'ChatController@sendText']);
//        $api->post('/sendImage',['uses'=>'ChatController@sendImage']);
    });
    $api->post('/send_image',['uses'=>'ChatController@sendImage']);
});
