<?php

$name = $_POST['name'];
$psw = $_POST['password'];
$access = $_POST['access'];
$account = $_POST['account'];
$updateDate = date("Y-m-d H:i:s");
$status = $_POST['status'];


try {
    //連線mysql
    require_once("../../front/connectDataBase.php");
    $index = $_GET['index'];

    $querySql = "SELECT admin_no FROM admin LIMIT $index, 1";
    $querySql = $pdo->query($querySql);
    $querySqlColumn = $querySql->fetchColumn();

    if ($querySqlColumn != 0) {
        // 檢查是否有重複的管理員帳號
        $checkSql = "SELECT admin_ac FROM admin WHERE NOT admin_no = $querySqlColumn";
        $checkStmt = $pdo->query($checkSql);

        if ($account == "" && $psw == "" && $name == "") {
            $result = ['error' => true, 'msg' => '表格欄位不得為空白，請重新填寫表格'];
        } else if ($checkStmt->fetchColumn() == $account) {
            $result = ['error' => true, 'msg' => '帳號名稱重複，請重新設定!'];
        } else {
            $Sql = "UPDATE admin SET admin_ac = :admin_ac, admin_pw = :admin_pw, admin_name = :admin_name, admin_access = :admin_access, update_date = :update_date , admin_status = :admin_status 
            WHERE admin_no = $querySqlColumn";

            $adminData = $pdo->prepare($Sql);
            $adminData->bindValue(':admin_ac', $account);
            $adminData->bindValue(':admin_pw', $psw);
            $adminData->bindValue(':admin_name', $name);
            $adminData->bindValue(':admin_access', $access);
            $adminData->bindValue(':update_date', $updateDate);
            $adminData->bindValue(':admin_status', $status);
            $adminData->execute();

            $result = ['error' => false, 'msg' => '資料修改成功'];
        }
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
