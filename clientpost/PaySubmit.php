<?php
/**
 * Created by PhpStorm.
 * User: hoter.zhang
 * Date: 2017/9/8
 * Time: 10:18
 */

namespace xinyeweb\asiapay\clientpost;


class PaySubmit
{
    public $pay_config;

    public $post_url = "https://www.paydollar.com/b2c2/eng/payment/payForm.jsp";

    public function __construct($pay_config)
    {
        $this->pay_config = $pay_config;
    }

    function buildRequestForm($method="POST", $button_name="Submit") {
        $sHtml = "<form id='pay-submit' name='pay-submit' action='".$this->post_url."' method='".$method."'>";
        while (list ($key, $val) = each ($this->pay_config)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
        //submit按钮控件请不要含有name属性
        //$sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";
        $sHtml = $sHtml."正在為您跳轉到支付,請稍後...";
        $sHtml = $sHtml."<script>document.forms['pay-submit'].submit();</script>";
        return $sHtml;
    }
}