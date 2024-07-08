<?php
try {
    //連線mysql
    require_once("../../front/connectDataBase.php");


    $Sql = "SELECT * FROM admin ";
    $adminData = $pdo->query($Sql);

    if ($adminData->rowCount() > 0) {
        $adminDataRow = $adminData->fetchAll(PDO::FETCH_ASSOC);
        $result = ['error' => false, 'adminData' => $adminDataRow];
    } else {
        $result = ['error' => true, 'msg' => '查無相關資料', 'adminData' => $adminDataRow];
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
