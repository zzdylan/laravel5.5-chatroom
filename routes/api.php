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
$api->version('v1', ['middleware' => ['serializer:array', 'cors','bindings'], 'namespace' => 'App\Http\Controllers\Api'], function ($api) {

    $api->get('/test', ['uses' => 'TestController@test']);

    #用户注册接口
    $api->post('/register', ['uses' => 'AuthController@register']);
    #用户登录接口
    $api->post('/login', ['uses' => 'AuthController@login']);
    $api->group(['middleware' => ['auth:api']], function ($api) {
        #获取用户个人信息
        $api->post('/me', ['uses' => 'UserController@me']);
        #绑定client_id和uid
        $api->post('/bind',['uses'=>'ChatController@bind']);
        #发送文本消息
        $api->post('/send_text',['uses'=>'ChatController@sendText']);
        #发送图片
        $api->post('/send_image',['uses'=>'ChatController@sendImage']);

        #朋友圈列表
        $api->get('/friend_circles',['uses'=>'FriendCircleController@index']);
        #发布朋友圈
        $api->post('/friend_circles',['uses'=>'FriendCircleController@store']);
        #删除朋友圈
        $api->delete('/friend_circles/{friendCircle}',['uses'=>'FriendCircleController@destroy']);

        #评论列表
        $api->get('/friend_circles/{friendCircle}/comments',['uses'=>'CommentController@index']);
        #添加评论
        $api->post('/friend_circles/{friendCircle}/comments',['uses'=>'CommentController@store']);
        #删除评论
        $api->delete('/friend_circles/{friendCircle}/comments/{comment}',['uses'=>'CommentController@destroy']);

        #给朋友圈点赞
        $api->post('/friend_circles/{friendCircle}/favours',['uses'=>'FavourController@store']);
        #删除朋友圈点赞
        $api->delete('/friend_circles/{friendCircle}/favours/{favour}',['uses'=>'FavourController@destroy']);
    });
});
