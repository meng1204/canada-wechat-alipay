<?php
/**
 * Author: Nico Chen
 * Date: 2018-12-04 meng8859@gmail.com
 */

namespace AlphaPay;

class AlphaPay{

    /**
     * Variables for Creating order
     */
    public $description;
    
    public $price;

    public $currency;

    public $notify_url;

    public $operator;

    public $channel;

    public $customer_id;

    public $appid;

    public $system;

    public $version;
    
    /**
     * Variables for Refund
     */
    public $fee;

    public $refund_id;


    public $order_id;

    public $PARTNER_CODE;

    public $CREDENTIAL_CODE;



    /**
     * Pay and Refund
     */
    public $pay;


    /**
     * Query Order stutas
     */
    public $commonApi;



    public function __construct($args = [])
    {
        $this->PARTNER_CODE = isset($args['PARTNER_CODE']) ? $args['PARTNER_CODE'] : null;
        $this->CREDENTIAL_CODE = isset($args['CREDENTIAL_CODE']) ? $args['CREDENTIAL_CODE'] : null; 

        $this->description = isset($args['description']) ? $args['description'] : null;
        $this->price = isset($args['price']) ? $args['price'] : null;
        $this->notify_url = isset($args['notify_url']) ? $args['notify_url'] : null;
        $this->operator = isset($args['operator']) ? $args['operator'] : 'admin';
        $this->channel = isset($args['channel']) ? $args['channel'] : "Wechat";
        $this->currency = isset($args['currency']) ? $args['currency'] : 'CAD';

        $this->customer_id = isset($args['customer_id']) ? $args['customer_id'] : '';
        $this->appid = isset($args['appid']) ? $args['appid'] : '';
        $this->system = isset($args['system']) ? $args['system'] : '';
        $this->version = isset($args['version']) ? $args['version'] : '';

        $this->order_id = isset($args['order_id']) ? $args['order_id'] : null;
        $this->nonce_str = isset($args['nonce_str']) ? $args['nonce_str'] : null;
        $this->time = isset($args['time']) ? $args['time'] : null;
        $this->sign = isset($args['sign']) ? $args['sign'] : null;
        
        $this->pay = new Pay($this);
        $this->commonApi = new CommonApi($this);

        return $this;
    }

    public function getMillisecond()
    {
        //获取毫秒的时间戳
        $time = explode(" ", microtime());
		$millisecond = "000".($time[0] * 1000);
		$millisecond2 = explode(".", $millisecond);
		$millisecond = substr($millisecond2[0],-3);
        $time = $time[1] . $millisecond;
        return $time;
    }

    /**
     *
     * 产生随机字符串，不长于30位
     * @param int $length
     * @return $str 产生的随机字符串
     */
    public function getNonceStr($length = 30)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    public function urlForm($urlObj){
        $buff = "";

        foreach ($urlObj as $k => $v) {
            if ($v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");

        return $buff;
        
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用setSign方法赋值
     */
    public function makeSign($args){

        //签名步骤一：构造签名参数
        $string = "";
        $string = $this->PARTNER_CODE . '&' . $args['time'] . '&' . $args['nonce_str'] . '&' . $this->CREDENTIAL_CODE;

        //签名步骤三：SHA256加密
        $string = hash('sha256', utf8_encode($string));

        //签名步骤四：所有字符转为小写
        $result = strtolower($string);

        return $result;

    }

    //return object contain (time,nonce_str, sign)
    public function UrlObjForm(){
        $signObj = [
            'time' => $this->getMillisecond(),
            'nonce_str'=> $this->getNonceStr(),
        ];

        $urlObj = [
            'time'=> $signObj['time'],
            'nonce_str'=> $signObj['nonce_str'],
        ];
        $urlObj['sign'] = $this->makeSign($signObj);

        return $urlObj;
    }


    /**
     * PAY URL RETURN
     */
    public function ReturnURL($pay_url){
        $urlObj = $this->alphapay->UrlObjForm();
        return $pay_url . '?' . self::urlForm($urlObj);
    }
    
}