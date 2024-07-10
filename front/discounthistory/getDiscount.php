<?php

try {
    // 連接到MySQL資料庫
    require_once ("../connectDataBase.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $no = $_POST['no'];

        $sql = "SELECT discount_got.dis_got_serial, discount_got.member_no, discount_got.dis_got_date, discount_got.dis_use_date, discount_type.dis_name, dis_set_date FROM discount_got LEFT JOIN discount_type on discount_got.dis_serial = discount_type.dis_serial WHERE member_no=$no";

        //編譯sql指令(若上述資料有未知數)
        //代入資料
        //執行sql指令
        $discounts = $pdo->query($sql);

        //執行
        //如果找到資料，取回資料，送出JSON
        if ($discounts->rowCount() > 0) {
            $discountsRow = $discounts->fetchAll(PDO::FETCH_ASSOC);
            $result = ['error' => false, 'msg' => '', 'discounts' => $discountsRow];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $result = ['error' => true, 'msg' => '尚無資料', 'discounts' => []];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }

    }
} catch (PDOException $e) {
    // 資料庫錯誤處理
    $msg = '資料庫錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    // 一般錯誤處理
    $msg = '系統錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
}
?>