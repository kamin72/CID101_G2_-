<?php
try {
    //連線mysql
    require_once("../../front/connectDataBase.php");

    $admin_ac = $_POST['account'];
    $admin_pw = $_POST['password'];
    $admin_name = $_POST['name'];
    $admin_access = $_POST['access'];

    // 檢查是否有重複的管理員帳號
    $checkSql = "SELECT COUNT(*) FROM admin WHERE admin_ac = :admin_ac";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':admin_ac', $admin_ac);
    $checkStmt->execute();

    if ($checkStmt->fetchColumn() > 0) {
        $result = ['error' => true, 'msg' => '帳號名稱重複，請重新設定!'];
    } else if ($admin_ac == "" && $admin_pw == "" && $admin_name == "") {
        $result = ['error' => true, 'msg' => '表格欄位不得空白，請填寫表格'];
    } else {
        // 帳號不重複，繼續插入新記錄
        $sql = "INSERT INTO admin (admin_ac, admin_pw, admin_name, admin_access, build_date)
                VALUES (:admin_ac, :admin_pw, :admin_name, :admin_access, :build_date)";

        $admin = $pdo->prepare($sql);
        $admin->bindValue(':admin_ac', $admin_ac);
        $admin->bindValue(':admin_pw', $admin_pw);
        $admin->bindValue(':admin_name', $admin_name);
        $admin->bindValue(':admin_access', $admin_access);
        $admin->bindValue(':build_date', date('Y-m-d H:i:s'));

        $admin->execute();
        $id = $pdo->lastInsertId();

        $admin = [
            'admin_no' => $id,
            'admin_ac' => $admin_ac,
            'admin_pw' => $admin_pw,
            'admin_name' => $admin_name,
            'admin_access' => $admin_access,
            'build_date' => date('Y-m-d H:i:s'),
        ];

        $result = ['error' => false, 'msg' => '資料建立成功', 'admin' => $admin];
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
