<?php
/**
 * Created by PhpStorm.
 * User: hoter.zhang
 * Date: 2017/9/8
 * Time: 9:13
 */

namespace xinyeweb\asiapay\clientpost;


interface PaydollarSecure
{

    public function generatePaymentSecureHash($merchantId,
                                              $merchantReferenceNumber, $currencyCode, $amount,
                                              $paymentType, $secureHashSecret);


    public function verifyPaymentDatafeed($src, $prc, $successCode,
                                          $merchantReferenceNumber, $paydollarReferenceNumber,
                                          $currencyCode, $amount,
                                          $payerAuthenticationStatus, $secureHashSecret,
                                          $secureHash);
}