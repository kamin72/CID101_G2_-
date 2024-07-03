<?php
try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");

    if ($_GET['cart_id']) {
        $sql = 'SELECT c.cart_id, p.prod_name, c.price, c.amount FROM cartitems c JOIN product p ON c.item_id = p.prod_id where c.cart_id = :cart_id';
        $orderItem = $pdo->prepare($sql);
        $orderItem->bindValue(':cart_id', $_GET['cart_id']);
        $orderItem->execute();
    }


    if ($orderItem->rowCount() == 0) {
        $result = ["error" => true, "msg" => "", "orderItem" => null];
    } else {
        $orderItemRow = $orderItem->fetchAll(PDO::FETCH_ASSOC);
        $result = ["error" => false, "msg" => "", "orderItem" => $orderItemRow];
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
