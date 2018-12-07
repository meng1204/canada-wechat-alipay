<?php

namespace AlphaPay;




class Pay extends Base{


    //JSAPI
    public function Jsapi($timeOut = 10){

        $partnerCode = $this->alphapay->PARTNER_CODE;

        $orderId = $this->alphapay->order_id;

        $url = "https://pay.alphapay.ca/api/v1.0/wechat_jsapi_gateway/partners/$partnerCode/orders/$orderId";


        $urlObj = $this->alphapay->UrlObjForm();

        $bodyObj = [
            'description' => $this->alphapay->description,
            'price'=> $this->alphapay->price,
            'channel' => $this->alphapay->channel,
            'currency' => $this->alphapay->currency,
            'notify_url' => $this->alphapay->notify_url,
            'operation'=> $this->alphapay->operation,
        ];


        $response = self::putJsonCurl($url, $urlObj, $bodyObj, $timeOut);

        $result = json_decode($response,true);

        return $result;

    }

    //QR CODE
    public function Qr($timeOut = 10){

        $partnerCode = $this->alphapay->PARTNER_CODE;

        $orderId = $this->alphapay->order_id;

        $url = "https://pay.alphapay.ca/api/v1.0/gateway/partners/$partnerCode/orders/$orderId";

        $urlObj = $this->alphapay->UrlObjForm();

        $bodyObj = [
            'description' => $this->alphapay->description,
            'price'=> $this->alphapay->price,
            'channel' => $this->alphapay->channel,
            'currency' => $this->alphapay->currency,
            'notify_url' => $this->alphapay->notify_url,
            'operation'=> $this->alphapay->operation,
        ];


        $response = self::putJsonCurl($url, $urlObj, $bodyObj, $timeOut);

        $result = json_decode($response,true);

        return $result;

    }

    // H5
    public function H5($timeOut = 10){

        $partnerCode = $this->alphapay->PARTNER_CODE;

        $orderId = $this->alphapay->order_id;

        $url = "hhttps://pay.alphapay.ca/api/v1.0/h5_payment/partners/$partnerCode/orders/$orderId";


        $urlObj = $this->alphapay->UrlObjForm();

        $bodyObj = [
            'description' => $this->alphapay->description,
            'price'=> $this->alphapay->price,
            'channel' => 'Alipay',
            'currency' => $this->alphapay->currency,
            'notify_url' => $this->alphapay->notify_url,
            'operation'=> $this->alphapay->operation,
        ];


        $response = self::putJsonCurl($url, $urlObj, $bodyObj, $timeOut);

        $result = json_decode($response,true);

        return $result;

    }

    public function refund($timeOut = 10){
        $partnerCode = $this->alphapay->PARTNER_CODE;

        $orderId = $this->alphapay->order_id;

        $refundId = $this->alphapay->refund_id;

        $url = "https://pay.alphapay.ca/api/v1.0/gateway/partners/$partnerCode/orders/$orderId/refunds/$refundId";


        $urlObj = $this->alphapay->UrlObjForm();

        $bodyObj = [
            'fee' => $this->alphapay->fee,
        ];


        $response = self::putJsonCurl($url, $urlObj, $bodyObj, $timeOut);


        $result = json_decode($response,true);

        return $result;
    }


    public function putJsonCurl($url, $urlObj, $bodyObj, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        // //如果有配置代理这里就设置代理
        
        // curl_setopt($ch, CURLOPT_PROXY, "0.0.0.0");
        // curl_setopt($ch, CURLOPT_PROXYPORT, 0);

        $url .= '?' . $this->alphapay->urlForm($urlObj);



        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        //PUT提交方式
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyObj));

        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);


            return $data;
        } else {
            $error = curl_errno($ch);


            curl_close($ch);
        }
    }

}