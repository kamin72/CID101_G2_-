<?php

try {
    // 連接到MySQL資料庫
    require_once("../connectDataBase.php");
    $cartId=$_GET['cartId'];

    $sql = "SELECT 
        carts.*, 
        member.*, 
        cartitems.*, 
        product.*, 
        CASE carts.cart_status 
            WHEN 0 THEN '未處理' 
            WHEN 1 THEN '處理中' 
            WHEN 2 THEN '已備貨' 
            WHEN 3 THEN '已取件' 
            WHEN 4 THEN '請求取消' 
            WHEN 5 THEN '已取消' 
            ELSE '未知'  
            END as cart_status_ch 
                FROM carts 
                LEFT JOIN member ON member.no = carts.no
                LEFT JOIN cartitems ON carts.cart_id = cartitems.cart_id
                LEFT JOIN product ON cartitems.item_id = product.prod_id
                WHERE carts.no = :no";    

        // 編譯SQL指令
        $stmt = $pdo->prepare($sql);

        // 代入資料
        $stmt->bindValue(':no', $cartId);

        // 執行SQL指令
        $stmt->execute();

        // 如果找到資料，取回資料，送出JSON
        if ($stmt->rowCount() > 0) {
            $cartsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = ['error' => false, 'msg' => '', 'carts' => $cartsRow];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $result = ['error' => true, 'msg' => '尚無資料', 'carts' => []];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    
    }
} catch (PDOException $e) {
    // 資料庫錯誤處理
    $msg = '資料庫錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
    echo json_encode($result);
} catch (Exception $e) {
    // 一般錯誤處理
    $msg = '系統錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
    echo json_encode($result);
}
?>