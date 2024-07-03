<?php

try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");

    $sql = "DELETE FROM carts WHERE cart_id = :cart_id";
    $orderStatus = $pdo->prepare($sql);
    $orderStatus->bindValue(':cart_id', $_GET['cart_id']);
    $orderStatus->execute();



    $result = ["error" => false, "msg" => '訂單刪除成功'];
} catch (PDOException $e) {
    $pdo->rollback();
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    $pdo->rollback();
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
}
echo json_encode($result);
