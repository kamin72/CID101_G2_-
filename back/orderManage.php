<?php

try {
    //連線mysql
    require_once("../connectDataBase.php");

    //查詢carts表格中的訂單資料
    if ($_GET['identity'] == 0) {
        $sql = "select * from carts";
        $order = $pdo->query($sql);
    }else{
        $sql = "select c.cart_id, c.cart_name, c.phone from carts c JOIN member m on c.no = m.no where identity = 1"
        $order=$pdo->
    }




    //如果新增一筆資料，送出JSON
    $result = ["error" => false, "msg" => "新增商品成功", "order" => $order];
    // $result = ["error" => false, "msg" => "新增商品成功", "no:" => $no];
} catch (PDOException $e) {
    $pdo->rollback();
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
    // $result = ["error" => true, "msg" => $msg, "no:" => $no];
} catch (Exception $e) {
    $pdo->rollback();
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
    // $result = ["error" => true, "msg" => $msg, "no:" => $no];
}
echo json_encode($result);
