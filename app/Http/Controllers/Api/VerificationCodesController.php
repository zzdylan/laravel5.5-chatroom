<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\SmsRegisterRequest;

class VerificationCodesController extends BaseController {

    //注册验证码
    public function store(SmsRegisterRequest $request) {
        $telphone = $request->telphone;
        $expiredAt = now()->addMinutes(10);
        $response = [
            'telphone' => $telphone,
            'expired_at' => $expiredAt->toDateTimeString(),
        ];
        $smsCode = generate_code();
        if (!config('sms.debug')) {
            $res = sendSmsCode($telphone, $smsCode);
            if (!$res['status']) {
                return $this->response->errorInternal($res['msg'] ?? '短信发送异常');
            }
        } else {
            $response['sms_code'] = $smsCode;
        }
        \Cache::put('sms_code.' . $telphone, $smsCode, $expiredAt);
        return $this->response->array($response)->setStatusCode(201);
    }

}
