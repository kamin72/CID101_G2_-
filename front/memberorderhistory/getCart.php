<?php

// try {
//     // 連接到MySQL資料庫
//     require_once("../connectDataBase.php");

//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $no = $_POST['no'];

//         $sql = "SELECT *,CASE (cart_status) 
//         WHEN 0 THEN '未處理' 
//         WHEN 1 THEN '處理中' 
//         WHEN 2 THEN '已備貨' 
//         WHEN 3 THEN '已取件' 
//         WHEN 4 THEN '請求取消' 
//         WHEN 5 THEN '已取消' 
//         ELSE '未知'  END as 'cart_status_ch' 
//         FROM carts WHERE no = $no";


//         // 編譯sql指令(若上述資料有未知數)
//         // 代入資料
//         // 執行sql指令
//         $carts = $pdo->query($sql);

//         // 執行

//         // 如果找到資料，取回資料，送出JSON
//         if ($carts->rowCount() > 0) {
//             $cartsRow = $carts->fetchAll(PDO::FETCH_ASSOC);
//             $result = ['error' => false, 'msg' => '', 'carts' => $cartsRow];
//             echo json_encode($result, JSON_NUMERIC_CHECK);
//         } else {
//             $result = ['error' => true, 'msg' => '尚無資料', 'carts' => []];
//             echo json_encode($result, JSON_NUMERIC_CHECK);
//         }

//     }
// } catch (PDOException $e) {
//     // 資料庫錯誤處理
//     $msg = '資料庫錯誤，請稍後再試。';
//     $result = ["error" => true, "msg" => $msg];
// } catch (Exception $e) {
//     // 一般錯誤處理
//     $msg = '系統錯誤，請稍後再試。';
//     $result = ["error" => true, "msg" => $msg];
// }

?>
<?php

try {
    // 連接到MySQL資料庫
    require_once ("../connectDataBase.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $no = $_POST['no'];

        $sql = "SELECT 
            c.cart_id, c.build_date, c.cart_paidamount, c.cart_status, c.cart_name, c.phone, c.email, c.cart_payableamount, c.cart_discount
            FROM carts c
            JOIN member m ON m.no = c.no
            WHERE c.no = :no";

        // 編譯SQL指令
        $stmt = $pdo->prepare($sql);

        // 代入資料
        $stmt->bindValue(':no', $no);

        // 執行SQL指令
        $stmt->execute();

        // 如果找到資料，取回資料，送出JSON
        if ($stmt->rowCount() > 0) {
            $cartsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = ['error' => false, 'msg' => '', 'carts' => $cartsRow];
            echo json_encode($result);
        } else {
            $result = ['error' => true, 'msg' => '尚無資料', 'carts' => []];
            echo json_encode($result);
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