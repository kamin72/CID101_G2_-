<?php
header("Access-Control-Allow-Origin: *");
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;

require __DIR__ . '/../../../../vendor/autoload.php';


// 獲取 URL 參數
$merchantTradeNo = isset($_POST['MerchantTradeNo']);
$totalAmount = isset($_POST['TotalAmount']);
$tradeDesc = isset($_POST['TradeDesc']);
$itemName = isset($_POST['ItemName']);


$factory = new Factory([
    'hashKey' => 'pwFHCqoQZGmho4w6',
    'hashIv' => 'EkRm7iFT261dpevs',
]);
$autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

$input = [
    'MerchantID' => '3002607',
    'MerchantTradeNo' => $merchantTradeNo . time(),
    'MerchantTradeDate' => date('Y/m/d H:i:s'),
    'PaymentType' => 'aio',
    'TotalAmount' => settype($totalAmount, "integer"),
    'TradeDesc' => UrlService::ecpayUrlEncode($tradeDesc),
    'ItemName' => $itemName,
    'ChoosePayment' => 'Credit',
    'EncryptType' => 1,

    // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
    'ReturnURL' => 'http://localhost:5173/cart_comp/pay_info?method=0',
    'OrderResultURL' => 'http://localhost:5173/cart_comp/cart_finish',
];
$action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

echo $autoSubmitFormService->generate($input, $action);
