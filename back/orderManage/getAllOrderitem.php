<?php
try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");
    $data = json_decode(file_get_contents("php://input"), true);
    $category = $data['category'] ?? '0';
    $variety = $data['variety'] ?? '0';
    $identity = $data['identity'] ?? '0';


    // if ($category == 0 || $variety == 0 || $identity == 0) {
    //     $sql = 'SELECT p.prod_category, p.prod_variety, p.prod_name, m.identity, ci.price, ci.amount 
    //             FROM cartitems ci 
    //             JOIN product p ON ci.item_id = p.prod_id 
    //             JOIN carts c ON ci.cart_id = c.cart_id 
    //             JOIN member m ON c.no = m.no';
    //     $orderItemAll = $pdo->query($sql);
    // } else 
    if ($category != 0) {
        $sql = "SELECT p.prod_category, p.prod_variety, p.prod_name, m.identity, ci.price, ci.amount, c.build_date 
                FROM cartitems ci 
                JOIN product p ON ci.item_id = p.prod_id 
                JOIN carts c ON ci.cart_id = c.cart_id 
                JOIN member m ON c.no = m.no
                WHERE p.prod_category = '$category'";
    } else if ($variety != 0) {
        $sql = "SELECT p.prod_category, p.prod_variety, p.prod_name, m.identity, ci.price, ci.amount, c.build_date 
                FROM cartitems ci 
                JOIN product p ON ci.item_id = p.prod_id 
                JOIN carts c ON ci.cart_id = c.cart_id 
                JOIN member m ON c.no = m.no
                WHERE p.prod_variety = '$variety'";
    } else if ($identity != 0) {
        $sql = "SELECT p.prod_category, p.prod_variety, p.prod_name, m.identity, ci.price, ci.amount, c.build_date 
                FROM cartitems ci 
                JOIN product p ON ci.item_id = p.prod_id 
                JOIN carts c ON ci.cart_id = c.cart_id 
                JOIN member m ON c.no = m.no
                WHERE m.identity = '$identity'";
    } else {
        $sql = 'SELECT p.prod_category, p.prod_variety, p.prod_name, m.identity, ci.price, ci.amount, c.build_date 
                FROM cartitems ci 
                JOIN product p ON ci.item_id = p.prod_id 
                JOIN carts c ON ci.cart_id = c.cart_id 
                JOIN member m ON c.no = m.no';
    }

    $orderItemAll = $pdo->query($sql);


    if ($orderItemAll->rowCount() > 0) {
        $orderItemAllRow = $orderItemAll->fetchAll(PDO::FETCH_ASSOC);
        $result = ["error" => false, "msg" => "", "orderItemAll" => $orderItemAllRow];
    } else {
        $result = ["error" => false, "msg" => "查無相關資料"];
    }


} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
}
echo json_encode($result, JSON_NUMERIC_CHECK);
