<?php
$status = $_GET['status'];
$admin_no = $_GET['admin_no'];


try {
    //連線mysql
    require_once("../../front/connectDataBase.php");


    $Sql = "UPDATE admin SET admin_status = :admin_status WHERE admin_no = :admin_no ";
    $adminData = $pdo->prepare($Sql);
    $adminData->bindValue(':admin_status', $status);
    $adminData->bindValue(':admin_no', $admin_no);
    $adminData->execute();

    $result = ['error' => false, 'msg' => '帳號狀態更改成功'];
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
