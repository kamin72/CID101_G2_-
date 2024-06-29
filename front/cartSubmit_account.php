<?php
$buildDate = date('Y/m/d H:i:s');
$memName = $_POST["name"];
$memAddress = $_POST["address"];
$memPhone = $_POST["phone"];
$memEmail = $_POST["email"];
$cartSum = $_POST['sum'];
$cartDiscount = $_POST['discount'];
$cartActualPaid = $_POST['actualPaid'];


try {
    //連線mysql
    require_once("./connectDataBase.php");


    // ------------先啟動交易管理
    $pdo->beginTransaction();

    //先查詢member表格中的會員編號
    $memberNo = $pdo->prepare("SELECT no FROM member WHERE name = :name");
    $memberNo->bindValue(':name', $memName);
    $memberNo->execute();
    $memberNoRow = $memberNo->fetch(PDO::FETCH_ASSOC);

    if (!$memberNoRow) {
        $sql = "insert into carts ( build_date, cart_name, address, phone, email, cart_payableamount, cart_discount, cart_paidamount) values( :date, :name, :address, :phone, :email, :sum, :discount, :actualPaid)";

        //編譯sql指令(若上述資料有未知數)
        //代入資料
        //執行sql指令
        $order = $pdo->prepare($sql);
        $order->bindValue(':date', $buildDate);
        $order->bindValue(':name', $memName);
        $order->bindValue(':address', $memAddress);
        $order->bindValue(':phone', $memPhone);
        $order->bindValue(':email', $memEmail);
        $order->bindValue(':sum', $cartSum);
        $order->bindValue(':discount', $cartDiscount);
        $order->bindValue(':actualPaid', $cartActualPaid);

        //執行
        $order->execute();
        $id = $pdo->lastInsertId();

        $order = [
            'cart_id' => $id,
            'build_date' => $buildDate,
            'cart_name' => $memName,
            'address' => $memAddress,
            'phone' => $memPhone,
            'email' => $memEmail,
            'cart_payableamount' => $cartSum,
            'cart_discount' => $cartDiscount,
            'cart_paidamount' => $cartActualPaid
        ];


        // 提交交易
        $pdo->commit();
    } else {

        //準備sql指令
        $sql = "insert into carts (no,build_date, cart_name, address, phone, email, cart_payableamount, cart_discount, cart_paidamount) values( :no, :date, :name, :address, :phone, :email, :sum, :discount, :actualPaid)";

        //編譯sql指令(若上述資料有未知數)
        //代入資料
        //執行sql指令
        $order = $pdo->prepare($sql);
        $order->bindValue(':no', $memberNoRow['no']);
        $order->bindValue(':date', $buildDate);
        $order->bindValue(':name', $memName);
        $order->bindValue(':address', $memAddress);
        $order->bindValue(':phone', $memPhone);
        $order->bindValue(':email', $memEmail);
        $order->bindValue(':sum', $cartSum);
        $order->bindValue(':discount', $cartDiscount);
        $order->bindValue(':actualPaid', $cartActualPaid);

        //執行
        $order->execute();
        $id = $pdo->lastInsertId();

        $order = [
            'cart_id' => $id,
            'build_date' => $buildDate,
            'cart_name' => $memName,
            'address' => $memAddress,
            'phone' => $memPhone,
            'email' => $memEmail,
            'cart_payableamount' => $cartSum,
            'cart_discount' => $cartDiscount,
            'cart_paidamount' => $cartActualPaid
        ];

        // 提交交易
        $pdo->commit();
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
