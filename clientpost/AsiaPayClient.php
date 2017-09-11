<?php
/**
 * Created by PhpStorm.
 * User: hoter.zhang
 * Date: 2017/9/8
 * Time: 9:15
 */

namespace xinyeweb\asiapay\clientpost;


use Yii;

class AsiaPayClient
{
    public $secret;
    public $debug;

    public $merchantId;
    //public $orderRef;//'商家訂單編號'
    public $currCode;
    // +----------------------------------------------------------------------
    //    “344” – HKD
    //    “840” – USD
    //    “702” – SGD
    //    “156” – CNY (RMB)
    //    “392” – JPY
    //    “901” – TWD
    //    “036” – AUD
    //    “978” – EUR
    //    “826” – GBP
    //    “124” – CAD
    // +----------------------------------------------------------------------
    //public $amount;
    public $paymentType;//N(正常支付) H
    public $mpsMode;
    // +----------------------------------------------------------------------
    //“NIL” or not provide – Disable MPS (merchant not using MPS) 禁用MPS
    //“SCP” – Enable MPS with ‘Simple Currency Conversion’ 简单的货币转换
    //“DCC” – Enable MPS with ‘Dynamic Currency Conversion’ 动态货币转换
    //“MCP” – Enable MPS with ‘Multi Currency Pricing’ 多货币定价
    // +----------------------------------------------------------------------
    public $payMethod;
    // +----------------------------------------------------------------------
    //“ALL” – All the available payment method
    //“CC” – Credit Card Payment
    //“PPS” – PayDollar PPS Payment
    //“PAYPAL” – PayPal By PayDollar Payment
    //“CHINAPAY” – China UnionPay By PayDollar Payment
    //“ALIPAY” – ALIPAY By PayDollar Payment
    //“TENPAY” – TENPAY BY PayDollar Payment
    //“99BILL” – 99BILL BY PayDollar Payment
    // +----------------------------------------------------------------------
    public $lang;
    // +------------------------------------------------------------------------
    // “C” – Traditional Chinese
    // “E” – English
    // “X” – Simplified Chinese
    // “K” – Korean
    // “J” – Japanese
    // “T” – Thai
    // +------------------------------------------------------------------------
    //public $successUrl;
    //public $failUrl;
    //public $cancelUrl;
    //Optional Parameter for connect to our payment page
    //public $remark;//备注字段，用于存储不在事务Web页面上显示的其他数据。
    //public $redirect;
    //public $oriCountry;
    // +-----------------------------------------------------------------------
    // 来源国家代码
    // 344 – “HK”
    // 840 – “US”
    // +-----------------------------------------------------------------------
    //public $destCountry;
    // +------------------------------------------------------------------------
    // 目的國家
    // 344 – “HK”
    // 840 – “US”
    // +------------------------------------------------------------------------

    public function __construct($merchantId, $debug=false, $secret=null, $currCode="446", $paymentType="N", $mpsMode="NIL", $payMethod="ALL", $lang="C")
    {
        $this->debug = $debug;
        $this->secret = is_null($secret) ? md5('WJISC_ASIA_PAY') : $secret;
        $this->merchantId = $merchantId;
        $this->currCode = $currCode;
        $this->paymentType = $paymentType;
        $this->mpsMode = $mpsMode;
        $this->payMethod = $payMethod;
        $this->lang = $lang;
    }

    // 發起請求
    public function requestPay($orderRef, $amount, $successUrl, $failUrl, $cancelUrl, $remark="", $redirect="", $oriCountry="", $destCountry="")
    {
        //生成簽名HASH
        //參數$merchantId, $orderRef, $currCode, $amount, $paymentType, $secureHashSecret
        $paydollarSecure = new SHAPaydollarSecure();
        $secureHashSecret = Yii::$app->security->generateRandomString();
        $secureHash = $paydollarSecure->generatePaymentSecureHash($this->merchantId, $orderRef, $this->currCode, $amount, $this->paymentType, $secureHashSecret);

        $pay_config = [
            'merchantId' => $this->merchantId,
            'amount' => $amount,
            'orderRef' => $orderRef,
            'currCode' => $this->currCode,
            'successUrl' => $successUrl,
            'failUrl' => $failUrl,
            'cancelUrl' => $cancelUrl,
            'payType' => $this->paymentType,
            'lang' => $this->lang,
            'mpsMode' => $this->mpsMode,
            'payMethod' => $this->payMethod,
            'secureHash' => $secureHash,
            'remark' => $remark,
            'redirect' => $redirect,
            'oriCountry' => $oriCountry,
            'destCountry' => $destCountry
        ];

        $submit = new PaySubmit($pay_config, $this->debug);
        echo $submit->buildRequestForm();
    }
}