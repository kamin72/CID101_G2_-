<?php
$memNo = $_GET['memberNo'];

try {
    //連線mysql
    require_once("../connectDataBase.php");

    $coupon = "SELECT dg.dis_got_serial, dt.dis_name, dt.dis_amount, dg.member_no, dg.dis_got_date, dg.dis_serial, dg.dis_use_date FROM discount_got dg JOIN discount_type dt ON dg.dis_serial = dt.dis_serial WHERE dg.member_no = :member_no";
    $coupon = $pdo->prepare($coupon);
    $coupon->bindValue(':member_no', $memNo);
    $coupon->execute();

    if ($coupon->rowCount() > 0) {
        $couponData = $coupon->fetchAll(PDO::FETCH_ASSOC);
        $result = ['error' => false, 'couponData' => $couponData];
    } else {
        $result = ['error' => true, 'msg' => '查無該會員的優惠券資料'];
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
}

echo json_encode($result);
