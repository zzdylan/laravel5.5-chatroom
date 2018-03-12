<?php

/**
 * 获取当前毫秒数
 * @return type
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

/**
 * 发送验证码短信
 * @param type $telphone 手机号码
 * @return type
 */
function sendSmsCode($telphone, $smsCode) {
    $jsonData = [
        "account" => "N3209638",
        "password" => "pD8HRot9xFb226",
        "msg" => "【253云通讯】您的验证码是：{$smsCode}",
        "phone" => $telphone
    ];
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'http://smssh1.253.com/msg/send/json', ['json' => $jsonData]);
    $res = json_decode((string) $response->getBody(), true);
    if ($res['code'] == 0) {
        return ['status' => 1, 'msg' => '短信发送成功!'];
    } else {
        return ['status' => 0, 'msg' => $res['errorMsg']];
    }
}

function checkSmsCode($telphone, $code) {
    if (Cache::get('sms_code.' . $telphone) == $code) {
        Cache::forget('sms_code.' . $telphone);
        return true;
    }
    return false;
}

function checkCaptcha($telphone, $code) {
    if (Cache::get('captcha.' . $telphone) == $code) {
        Cache::forget('captcha.' . $telphone);
        return true;
    }
    return false;
}

/**
 * 生成数字验证码
 * @param type $length
 * @return type
 */
function generate_code($length = 6) {
    return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

/**
 * 生成订单号
 * @return type
 */
function build_order_no() {
    return getMillisecond() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
 * 去除多维数组中的空值
 * @author 
 * @return mixed
 * @param $arr 目标数组
 * @param array $values 去除的值  默认 去除  '',null,false,0,'0',[]
 */
function filter_array($arr, $values = ['', null, false, 0, '0', []]) {
    foreach ($arr as $k => $v) {
        if (is_array($v) && count($v) > 0) {
            $arr[$k] = filter_array($v, $values);
        }
        foreach ($values as $value) {
            if ($v === $value) {
                unset($arr[$k]);
                break;
            }
        }
    }
    return $arr;
}

//递归获取分类树
function getTree($items, $pid = 0) {
    $tree = [];
    foreach ($items as $item) {
        if ($item['parent_id'] == $pid) {
            $item['childrens'] = getTree($items, $item['id']);
            $tree[] = $item;
            unset($item);
        }
    }
    return $tree;
}

/**
 *  根据身份证号码获取性别
 *  @param string $idcard    身份证号码
 *  @return int $sex 性别 1男 0女 
 */
function getSex($idcard) {
    if (empty($idcard))
        return null;
    $sexint = (int) substr($idcard, 16, 1);
    return $sexint % 2 === 0 ? 0 : 1;
}

/**
 *  根据身份证号码计算年龄
 *  @param string $idcard    身份证号码
 *  @return int $age
 */
function getAge($idcard) {
    if (empty($idcard))
        return null;
    #  获得出生年月日的时间戳 
    $date = strtotime(substr($idcard, 6, 8));
    #  获得今日的时间戳 
    $today = strtotime('today');
    #  得到两个日期相差的大体年数 
    $diff = floor(($today - $date) / 86400 / 365);
    #  strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比 
    $age = strtotime(substr($idcard, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;
    return $age;
}
