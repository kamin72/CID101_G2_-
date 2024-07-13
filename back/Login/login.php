<?php
header('Content-Type: application/json');
try {
    // 連接到資料庫
    require_once("../../front/connectDataBase.php");

    // 獲取 POST 數據
    $postData = json_decode(file_get_contents('php://input'), true);
    $admin_ac = $postData['account'];
    $admin_pw = $postData['password'];

    // 查詢資料庫中的管理員帳號和密碼
    $sql = "SELECT * FROM admin WHERE admin_ac = :admin_ac AND admin_pw = :admin_pw";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':admin_ac', $admin_ac);
    $stmt->bindParam(':admin_pw', $admin_pw);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // 登錄成功
        $loginAdminData = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin_no = $loginAdminData['admin_no'];

        // 查詢最小的 admin_no
        $minSql = "SELECT MIN(admin_no) AS min_admin_no FROM admin";
        $minStmt = $pdo->prepare($minSql);
        $minStmt->execute();
        $minAdminNo = $minStmt->fetch(PDO::FETCH_ASSOC)['min_admin_no'];

        // 判斷當前管理員的 admin_no 是否為最小值
        $isSuperAdmin = $admin_no == $minAdminNo;

        $result = [
            'success' => true,
            'loginAdminData' => $loginAdminData,
            'isSuperAdmin' => $isSuperAdmin
        ];
    } else {
        // 登錄失敗
        $result = ['success' => false, 'msg' => '帳號或密碼錯誤'];
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['success' => false, 'msg' => $msg];
}

echo json_encode($result);
?>