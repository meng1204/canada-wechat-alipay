# Alpha Pay - Wechat Pay and Alipay

## 安装 Install
```php
composer required nicochen/canada-wechat-alipay
```

## 使用方法 How to use
```php

use AlphaPay;

$alphapay = new AlphaPay([
    'PARTNER_CODE' => '',
    'CREDENTIAL_CODE' => '',
    'description' => '',
    'price' => '',
    'notify_url' => '',
    'operation' => '',
    'currency' => '',
    'order_id' => '',
]);

$alphapay->pay->Jsapi();
$alphapay->pay->Qr();
$alphapay->pay->H5();
$alphapay->pay->refund();

$alphapay->commonApi->orderQuery();
```