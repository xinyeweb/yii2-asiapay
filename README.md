AsiaPay
=======
AsiaPay Hong Kong

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xinyeweb/yii2-asiapay "dev-master"
```

or add

```
"xinyeweb/yii2-asiapay": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :
```php
    $asiaPay = new AsiaPayClient('商戶號');
    //$orderRef, $amount, $successUrl, $failUrl, $cancelUrl, $remark="", $redirect="", $oriCountry="", $destCountry=""
    $asiaPay->requestPay(time(), 10, 'https://www.xinyeweb.com', 'https://www.xinyeweb.com', 'https://www.xinyeweb.com');
```
注意：需要在商戶後台設定好返回鏈接(數據反饋)，不要在支付結果頁面更新業務邏輯