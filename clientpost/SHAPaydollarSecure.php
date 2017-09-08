<?php
/**
 * Created by PhpStorm.
 * User: hoter.zhang
 * Date: 2017/9/8
 * Time: 9:12
 */

namespace xinyeweb\asiapay\clientpost;


class SHAPaydollarSecure implements PaydollarSecure
{

    public function generatePaymentSecureHash($merchantId, $merchantReferenceNumber, $currencyCode, $amount, $paymentType, $secureHashSecret)
    {

        $buffer = $merchantId . '|' . $merchantReferenceNumber . '|' . $currencyCode . '|' . $amount . '|' . $paymentType . '|' . $secureHashSecret;
        //echo $buffer;
        return sha1($buffer);

    }

    public function verifyPaymentDatafeed($src, $prc, $successCode, $merchantReferenceNumber, $paydollarReferenceNumber, $currencyCode, $amount, $payerAuthenticationStatus, $secureHashSecret, $secureHash)
    {

        $buffer = $src . '|' . $prc . '|' . $successCode . '|' . $merchantReferenceNumber . '|' . $paydollarReferenceNumber . '|' . $currencyCode . '|' . $amount . '|' . $payerAuthenticationStatus . '|' . $secureHashSecret;

        $verifyData = sha1($buffer);

        if ($secureHash == $verifyData) {
            return true;
        }

        return false;

    }
}