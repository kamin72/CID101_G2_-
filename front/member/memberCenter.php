<?php
try {
    // 連接到MySQL資料庫
    require_once ("../connectDataBase.php");

    // 更新會員資料
    if(isset($_POST['action']) && $_POST['action']=="updateMember"){
        $account = $_POST['account'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $sql = "UPDATE member SET phone = :phone,email = :email WHERE account = :account " ;
        // 編譯並執行 SQL 指令
        $stmt = $pdo->prepare($sql);
        $update= $stmt->execute([
            ':account' => $account,
            ':phone' => $phone,
            ':email' => $email
        ]);
        $result = ['error' => false, 'msg' => '', 'update' => $update ];
        echo json_encode($result);
    }
} catch (PDOException $e) {
    // 資料庫錯誤處理
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    // echo "系統暫時不能正常運行，請稍後再試<br>";
    $result = ['error' => true, 'msg' => $msg];
}
?>