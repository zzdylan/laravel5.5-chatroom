<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\CaptchaRequest;

class CaptchasController extends BaseController {

    //图形验证码
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder) {
        $telphone = $request->telphone;
        $captcha = $captchaBuilder->build();

        //有效期
        $expiredAt = now()->addMinutes(2);
        //将图形验证码的值保存到缓存中
        \Cache::put('captcha.' . $telphone, $captcha->getPhrase(), $expiredAt);

        $result = [
            'telphone' => $telphone,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()//图形验证码二进制
        ];
        return $this->response->array($result)->setStatusCode(201);
    }

}
