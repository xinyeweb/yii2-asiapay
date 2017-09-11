<?php
/**
 * Created by PhpStorm.
 * User: hoter.zhang
 * Date: 2017/9/11
 * Time: 12:03
 */

namespace xinyeweb\asiapay\clientpost;


use Yii;

class AsiaPayNotify
{
    public $secret;

    public function __construct($secret=null)
    {
        $this->secret = is_null($secret) ? md5('WJISC_ASIA_PAY') : $secret;
        echo "OK";// 表示服務器接受到通知
    }

    public function verifyDataFeed($secureHash, $src, $prc, $code, $ref, $payRef, $cur, $amt, $payerAuth){
        $secret = $this->secret;
        $secureHashArray = explode(',', $secureHash);
        $payDollarSecure = new SHAPaydollarSecure();
        $verifyResult = true;
        while (list(, $value) = each($secureHashArray)) {
            $verifyResult = $payDollarSecure->verifyPaymentDatafeed($src, $prc, $code, $ref, $payRef, $cur, $amt, $payerAuth, $secret, $value);
            if (!$verifyResult) break; //檢測到有一項不通過，測跳出循環
        }
        return $verifyResult;
    }

    /**
     * 數據驗證
     */
    public function verify()
    {
        if (empty($_POST)) { //沒有POST的值
            Yii::info('沒有POST的值', 'AsiaPayLog');
            return false;
        } else { // 有POST的值
            //做數據驗證
            if (!$this->verifyDataFeed($_POST['secureHash'], $_POST['src'], $_POST['prc'], $_POST['successcode'], $_POST['Ref'], $_POST['PayRef'], $_POST['Cur'], $_POST['Amt'], $_POST['payerAuth'])) {
                Yii::info('數據驗證失敗', 'AsiaPayLog');
                return false;
            } else {
                if ($_POST['successcode'] == '0') {
                    return true;
                } else {
                    return false;
                }
            }

        }
    }

    public function verifyCode(){
        if (empty($_POST)) {
            Yii::info('沒有POST的值', 'AsiaPayLog');
            return false;
        } else {
            if ($_POST['successcode'] == '0') {
                return true;
            } else {
                return false;
            }
        }
    }
}