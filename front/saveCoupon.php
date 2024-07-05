<?php

try {
    // 連線 mysql
    require_once ("./connectDataBase.php");

    // 解析前端發來的 JSON 數據
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['memberInfo'])) {
        $memberInfo = $input['memberInfo'];
        $memberId = $memberInfo['no'];
        $serial = $memberInfo['dis_serial'];
       
        $gotDate = date('Y-m-d'); // 獲取當天日期

        

        // 查詢用戶當天是否已經領取過優惠券
        $sql_check = "SELECT COUNT(*) FROM discount_got WHERE member_no = :memberId AND dis_got_date = :gotDate";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindValue(":memberId", $memberId);
        $stmt_check->bindValue(":gotDate", $gotDate);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // 如果已經領取過，返回錯誤信息
            $result = ['success' => false, 'msg' => '今天已經領過囉!明天再來!'];
        } else {
            // 如果還未領取過，執行插入操作
            $sql_insert = "INSERT INTO discount_got (member_no, dis_serial, dis_got_date) VALUES (:memberId, :serial, :gotDate)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindValue(":memberId", $memberId);
            $stmt_insert->bindValue(":serial", $serial);
            $stmt_insert->bindValue(":gotDate", $gotDate);
            $stmt_insert->execute();

            $result = ['success' => true];
        }

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