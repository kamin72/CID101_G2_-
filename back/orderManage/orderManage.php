<?php

try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");

    //查詢carts表格中的訂單資料
    if ($_GET['identity'] == 0) {
        $sql = "select * from carts";
        $order = $pdo->query($sql);
    } else {
        $sql = "select c.cart_id, c.cart_name, c.phone, c.email, c.cart_status from carts c JOIN member m on c.no = m.no where identity = ?";
        $order = $pdo->prepare($sql);
        $order->bindValue(1, $_GET["identity"]);
        $order->execute();
    }

    if ($order->rowCount() == 0) {
        $result = ["error" => true, "msg" => "", "order" => $orderRow];
    } else {
        $orderRow = $order->fetchAll(PDO::FETCH_ASSOC);
        $result = ["error" => false, "msg" => "", "order" => $orderRow];
    }
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
