<?php
try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");
    $index = $_GET['index'];

    $querySql = "SELECT admin_no FROM admin LIMIT $index, 1";
    $querySql = $pdo->query($querySql);
    $querySqlColumn = $querySql->fetchColumn();

    if ($querySqlColumn != 0) {
        $Sql = "DELETE FROM admin WHERE admin_no = $querySqlColumn";
        $adminData = $pdo->query($Sql);

        $result = ['error' => false, 'msg' => '資料刪除成功'];

    }

} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
?>