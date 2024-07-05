<?php
header("Access-Control-Allow-Origin: *");
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;

require __DIR__ . '/../../../../vendor/autoload.php';


// 獲取 URL 參數
// $merchantTradeNo = $_POST['MerchantTradeNo'];
$totalAmount = $_POST['itemPrice'];
$itemName = $_POST['itemName'];
// $totalAmount = $_POST['TotalAmount'];
// $itemName = $_POST['ItemName'];


$factory = new Factory([
    'hashKey' => 'pwFHCqoQZGmho4w6',
    'hashIv' => 'EkRm7iFT261dpevs',
]);
$autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

$input = [
    'MerchantID' => '3002607',
    'MerchantTradeNo' => 'Test' . time(),
    'MerchantTradeDate' => date('Y/m/d H:i:s'),
    'PaymentType' => 'aio',
    'TotalAmount' => $totalAmount,
    'TradeDesc' => UrlService::ecpayUrlEncode("信用卡一次付清"),
    'ItemName' => $itemName,
    'ChoosePayment' => 'Credit',
    'EncryptType' => 1,
    'CheckMacValue' => '59B085BAEC4269DC1182D48DEF106B431055D95622EB285DECD400337144C698',

    // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
    'ReturnURL' => 'https://tibamef2e.com/cid101/g2/api/SKD_PHP-master/example/Payment/Aio/GetCheckoutResponse.php',
    // 'OrderResultURL' => 'https://tibamef2e.com/cid101/g2/front',
];
$action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

echo $autoSubmitFormService->generate($input, $action);
