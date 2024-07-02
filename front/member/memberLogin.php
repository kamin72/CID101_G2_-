<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }


$memId = $_POST["account"];
$memPsw = $_POST["password"];


try {
    //連線mysql
    require_once ("../connectDataBase.php");

    //準備sql指令
    $sql = "select * from member where account = :x and password = :y";

    //編譯sql指令(若上述資料有未知數)
    //代入資料
    //執行sql指令
    $member = $pdo->prepare($sql);
    $member->bindValue(':x', $memId);
    $member->bindValue(':y', $memPsw);

    //執行
    $member->execute();

    //如果找到資料，取回資料，送出JSON
    if ($member->rowCount() > 0) {
        $memberRow = $member->fetchAll(PDO::FETCH_ASSOC);
        $result = ['error' => false, 'msg' => '', 'member' => $memberRow];
        echo json_encode($result);
    } else {
        $result = ['error' => true, 'msg' => '查無會員帳號或密碼錯誤，請重新輸入', 'member' => []];
        echo json_encode($result);
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    // echo "系統暫時不能正常運行，請稍後再試<br>";
    $result = ['error' => true, 'msg' => $msg];
    echo json_encode($result, JSON_NUMERIC_CHECK);
}
?>