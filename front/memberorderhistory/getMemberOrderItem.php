<?php
try {
    //連線mysql
    require_once ("../connectDataBase.php");

    if ($_GET['cartId']) {
        $sql = 'SELECT ci.cart_id, p.prod_name, ci.price, ci.amount FROM cartitems ci 
        JOIN product p ON ci.item_id = p.prod_id 
        where ci.cart_id = :cart_id';



        $orderItem = $pdo->prepare($sql);
        $orderItem->bindValue(':cart_id', $_GET['cartId']);
        $orderItem->execute();
    }


    if ($orderItem->rowCount() == 0) {
        $result = ["error" => true, "msg" => "", "orderItem" => null];
    } else {
        $orderItemRow = $orderItem->fetchAll(PDO::FETCH_ASSOC);
        $result = ["error" => false, "msg" => "", "orderItem" => $orderItemRow];
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
}
echo json_encode($result, JSON_NUMERIC_CHECK);
