<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use GatewayClient\Gateway;
use App\Http\Transformers\UserTransformer;
use App\Models\ChatRecord;
use zgldh\QiniuStorage\QiniuStorage;
use Image;
use App\Jobs\SendBotMessage;

class ChatController extends BaseController {

	public function bind(Request $request) {
        Gateway::$registerAddress = '127.0.0.1:1238';
        $user = $this->guard()->user();
        $uid = $user->id;
        $client_id = $request->input('client_id');
        Gateway::bindUid($client_id, $uid);
        Gateway::setSession($client_id, $user->toArray());
        $pushData = ['type' => 'inform', 'content' => "欢迎{$user->username}进入聊天室"];
        Gateway::sendToAll(json_encode($pushData, true));
        $pushData = ['type'=>'updateOnline','onlineCount'=>Gateway::getAllClientCount(),'onlineUser'=>Gateway::getAllClientSessions()];
        Gateway::sendToAll(json_encode($pushData));
        return $this->response->array(['msg' => "绑定成功,uid为$uid", 'client_id' => $client_id,'userinfo'=>(new UserTransformer())->transform($user)]);
    }

    public function sendText(Request $request) {
        Gateway::$registerAddress = '127.0.0.1:1238';
        $user = $this->guard()->user()->toArray();
        $uid = $user['id'];
        $content = $request->input('text');
        $pushData = ['type' => 'text', 'content' => $content, 'nickname' => $user['username'], 'avatar' => $user['avatar']];
        ChatRecord::create([
            'type'=> 1,
            'content'=> $content,
            'user_id'=> $uid
        ]);
        Gateway::sendToAll(json_encode($pushData), null, Gateway::getClientIdByUid($uid));
        if(config('chatroom.tuling.switch')){
            dispatch(new SendBotMessage($content,$uid));
        }
        return $this->response->array(['msg' => "发送成功"]);
    }

    public function sendImage(Request $request){
        Gateway::$registerAddress = '127.0.0.1:1238';
        $img = $request->file('image');
        $width = Image::make($img->getRealPath())->width();
        $image = Image::cache(function($image) use ($img, $width) {
            if ($width > 300) {
                $image->make($img->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image->make($img->getRealPath());
            }
        });
        $disk = QiniuStorage::disk('qiniu');
        $extension = $img->getClientOriginalExtension();
        $fileName = 'chatImage/' . uniqid('chatimage') . '.' . $extension;
        $disk->put($fileName, $image);
        $imageUrl = (string) $disk->downloadUrl($fileName);
        $user = $this->guard()->user();
        ChatRecord::create([
            'type'=> 2,
            'content'=> $imageUrl,
            'user_id'=> $user->id
        ]);
        $pushData = ['type' => 'image', 'content' => $imageUrl, 'nickname' => $user->username, 'avatar' => $user->avatar];
        Gateway::sendToAll(json_encode($pushData, true), null, Gateway::getClientIdByUid($user->id));
        return $this->response->array(['msg' => "发送成功",'imageUrl'=>$imageUrl]);
    }

}
