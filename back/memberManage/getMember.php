<?php

try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");


    $status = $_POST['status'];
    $identity = $_POST['identity'];
    //準備sql指令
    $sql = "select * from member where  status=$status and identity=$identity ";

    
    //編譯sql指令(若上述資料有未知數)
    //代入資料
    //執行sql指令
    $members = $pdo->query($sql);

    //如果找得資料，取回資料，送出json
    if($members->rowCount() > 0) {
    $membersRows = $members->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg" => "", "members" => $membersRows];
    } else {
    $result = ["error" => false, "msg" => "無商品資料", "members" => []];
    }
    echo json_encode($result);
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
       // echo "系統暫時不能正常運行，請稍後再試<br>";
    $result = ['error' => true, 'msg' => $msg];
}

?>