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

        // 準備 SQL 指令
        $sql = "INSERT INTO discount_got (member_no, dis_serial) VALUES (:memberId, :serial)";

        // 編譯並執行 SQL 指令
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":memberId", $memberId);
        $stmt->bindValue(":serial", $serial);
        $stmt->execute();

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
