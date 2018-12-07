<?php

namespace AlphaPay;


class CommonApi extends Base{



    public function orderQuery($timeOut = 10){
        $partnerCode = $this->alphapay->PARTNER_CODE;

        $orderId = $this->alphapay->order_id;

        $url = "https://pay.alphapay.ca/api/v1.0/gateway/partners/$partnerCode/orders/$orderId";

        $urlObj = $this->alphapay->UrlObjForm();

        $response = self::getJsonCurl($url, $urlObj, $timeOut);

        $result = json_decode($response,true);

        return $result;

    }

    public function getJsonCurl($url, $urlObj, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        
        $url .= '?' . $this->alphapay->urlForm($urlObj);


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        //GET提交方式
        curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
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