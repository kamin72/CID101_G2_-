<?php

try {
    // 連線 mysql
    require_once ("./connectDataBase.php");
    // $pdo->beginTransaction();
    // print_r($pdo);
    // 解析前端發來的 JSON 數據
    $input = json_decode(file_get_contents('php://input'), true);
    // print_r($input);

    if (isset($input['memberInfo'])) {
        $memberInfo = $input['memberInfo'];
        // $memberId = intval($memberInfo[0]['no']);
        // $coupons = $memberInfo[0]=>'coupons';

    //     // 準備 SQL 指令
        $sql = "INSERT INTO discount_got  (member_no,  dis_serial) VALUES (:memberId,  :serial)";
        ;
        
    //     // 編譯並執行 SQL 指令
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(":memberId", $input=>"no");
        $stmt->bindValue(":serial", $input=>"dis_serial");

        $stmt->execute();
        // $dis_got_serial = $pdo->lastInsertId();
        // $stmt=[
        //     'dis_got_serial' => $dis_got_serial,
        //     'member_no' => $memberId,
        //     'dis_got_date' => $coupon['date'],
        //     'dis_serial' => $coupon['serial'],
        //     'dis_use_date' => $coupon['useDate']
        // ]
        // $pdo->commit(); 

        // foreach ($coupons as $coupon) {
        //     $stmt->execute([
        //         ':memberId' => $memberId,
        //         ':date' => $coupon['date'],
        //         ':serial' => $coupon['serial'],
        //         ':useDate' => $coupon['useDate'] ?? null
        //     ]);
        // }

        $result = ['success' => true];
        // print_r($result);
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
