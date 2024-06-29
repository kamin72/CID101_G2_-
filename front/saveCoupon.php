<?php
// saveCoupon.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5174'); // 設定允許的跨域來源
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// 启用错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 連線 mysql
    require_once ("./connectDataBase.php");

    // 解析前端發來的 JSON 數據
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['memberInfo'])) {
        $memberInfo = $input['memberInfo'];
        $memberId = intval($memberInfo[0]['id']);
        $coupons = $memberInfo[0]['coupons'];

        // 準備 SQL 指令
        $sql = "INSERT INTO discount_got (member_id, amount, date) VALUES (:memberId, :amount, :date)";
        
        // 編譯並執行 SQL 指令
        $stmt = $pdo->prepare($sql);
        
        foreach ($coupons as $coupon) {
            $stmt->execute([
                ':memberId' => $memberId,
                ':amount' => $coupon['amount'],
                ':date' => $coupon['date']
            ]);
        }

        $result = ['success' => true];
        echo json_encode($result);
    } else {
        $result = ['success' => false, 'msg' => 'Invalid input'];
        echo json_encode($result);
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['success' => false, 'msg' => $msg];
    echo json_encode($result);
} catch (Exception $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['success' => false, 'msg' => $msg];
    echo json_encode($result);
}
?>
