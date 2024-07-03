<?php

try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");

    $sql = "UPDATE carts SET cart_status = :status WHERE cart_id = :cart_id";
    $orderStatus = $pdo->prepare($sql);
    $orderStatus->bindValue(':status', $_GET['cart_ststus']);
    $orderStatus->bindValue(':cart_id', $_GET['cart_id']);
    $orderStatus->execute();

    $orderStatus = [
        'cart_status' => $_GET['cart_ststus']
    ];

    $result = ["error" => false, 'orderStatus' => $orderStatus];
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
