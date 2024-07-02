<?php
try {
    // 連線mysql
    require_once ("./connectDataBase.php");

    if(isset($_POST['action']) && $_POST['action']=="getMember"){
        $account = $_POST['account'];
        // 準備sql指令
        $sql = "select * from member where account='".$account."'";
    // 編譯sql指令(若上述資料有未知數)
    // 代入資料
    // 執行sql指令
        $member = $pdo->query($sql);
        if ($member->rowCount() > 0) {
            $memberRow = $member->fetchAll(PDO::FETCH_ASSOC);
            $result = ['error' => false, 'msg' => '', 'member' => $memberRow];
            //json_encode 把陣列變成json格式
            echo json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $result = ['error' => false, 'msg' => '', 'member' => []];
            //json_encode 把陣列變成json格式
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    }

    if(isset($_POST['action']) && $_POST['action']=="setMember"){
        $account = $_POST['account'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "INSERT INTO member (account,password,name,phone,email) VALUES (:account,:password,:name,:phone,:email)";

        // 編譯並執行 SQL 指令
        $stmt = $pdo->prepare($sql);
        
        $created= $stmt->execute([
            ':account' => $account,
            ':password' => $password,
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            // ':register_date' => $registerDate, // 將註冊日期加入到 INSERT 語句中
        ]);

        $result = ['error' => false, 'msg' => '', 'created' => $created ];
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    
/*

    //如果找到資料，取回資料，送出JSON
    if ($member->rowCount() > 0) {
        $memberRow = $member->fetchAll(PDO::FETCH_ASSOC);
        $result = ['error' => false, 'msg' => '', 'member' => $memberRow];
        echo json_encode($result, JSON_NUMERIC_CHECK);
    } else {
        $result = ['error' => true, 'msg' => '查無會員帳號或密碼錯誤，請重新輸入', 'member' => []];
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
*/
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    // echo "系統暫時不能正常運行，請稍後再試<br>";
    $result = ['error' => true, 'msg' => $msg];
    echo json_encode($result, JSON_NUMERIC_CHECK);
}
?>