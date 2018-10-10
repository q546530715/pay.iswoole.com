<?php

namespace xh\library;

use xh\unity\encrypt;
use xh\unity\cog;

//系统函数支持库
class functions
{
    //json解析
    static public function json($Code, $Msg, $array = null)
    {
        header('Content-type: application/json;charset=utf-8');
        exit(json_encode(array("code" => $Code, "msg" => $Msg, "data" => $array), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    //pwd算法
    static public function pwd($pass, $token)
    {
        return substr(md5(md5($pass) . md5($token)), 0, 23);
    }

    // 生成分类树
    static public function category($data, $pId = 0, $pidName = 'pid')
    {
        $tree = array();

        foreach ($data as $k => $v) {
            if ($v[$pidName] == $pId) {
                $v['child'] = self::CATEGORY($data, $v['id']);
                $tree[] = $v;
            }
        }

        return $tree;
    }

    //检测是否手机号
    static public function isMobile($mobile)
    {
        if (preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/", $mobile)) {
            return true;
        }

        return false;
    }

    //检测是否为邮箱
    static public function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    //sign算法
    //$key_id 商户KEY
    //$array = array('amount'=>'1.00','out_trade_no'=>'2018123645787452');
    static public function sign($key_id, $array)
    {
        $data = md5(sprintf("%.2f", $array['amount']) . $array['out_trade_no']);
        $cipher = '';
        $key[] = "";
        $box[] = "";
        $pwd_length = strlen($key_id);
        $data_length = strlen($data);
        for ($i = 0; $i < 256; $i++) {
            $key[$i] = ord($key_id[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $data_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;

            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;

            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }

        return md5($cipher);
    }

    //json-text
    static public function str_json($type, $Code, $Msg, $array = null)
    {
        if ($type == 'json') {
            header('Content-type: application/json;charset=utf-8');
            exit(json_encode(array("code" => $Code, "msg" => $Msg, "data" => $array), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            exit($Msg);
        }
    }

    //json解析_加密
    static public function json_encode($Code, $Msg, $array = null, $type = true)
    {
        header('Content-type: application/json;charset=utf-8');
        exit((new encrypt())->Encode(json_encode(array("code" => $Code, "msg" => $Msg, "data" => $array)), cog::read("server")['key']));
    }

    //json解析_加密
    static public function json_encode_pc($Code, $Msg, $array = null, $type = true)
    {
        header('Content-type: application/json;charset=utf-8');
        exit((new encrypt())->Encode(json_encode(array("code" => $Code, "msg" => $Msg, "data" => $array)), PC_KEY));
    }

    static public function getPayUrl($natapp_url, $amount, $mark, $types = 1)
    {
        $type = [
            1 => 'wechat',
            2 => 'alipay'
        ];
        $url = $natapp_url . 'getpay?money=' . $amount . '&mark=' . $mark . '&type=' . $type[$types];

        return json_decode(functions::pay_curl($url));
    }

    static function pay_curl($url, $data = '')
    {
        $ch = curl_init($url);
        $header[] = 'Mozilla/5.0 (Linux; U; Android 7.1.2; zh-cn; GiONEE F100 Build/N2G47E) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';
        if (!empty($data)) {
            curl_setopt($ch, 47, 1);
            curl_setopt($ch, 10015, $data);
        }
        curl_setopt($ch, 10023, $header);
        curl_setopt($ch, 64, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, 81, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, 19913, true);
        curl_setopt($ch, 19914, true);
        curl_setopt($ch, 52, 1);
        curl_setopt($ch, 13, 60);
        ob_start();
        @$data = curl_exec($ch);
        ob_end_clean();
        curl_close($ch);

        return $data;
    }

    static function getAndroidHeartbeatNowTime()
    {
        return time() - 180;
    }

    static function getRedisConfig()
    {
        return [
            'port' => REDIS_PORT,
            'host' => REDIS_HOST,
            'auth' => REDIS_AUTH
        ];

    }
}