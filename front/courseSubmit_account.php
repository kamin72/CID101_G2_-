<?php

try {
    // 連接到資料庫
    require_once ("../connectDataBase.php");

    // 從 HTTP 請求中讀取 JSON 數據並轉換為 PHP 陣列
    $data = json_decode(file_get_contents("php://input"), true);

    // 準備預約課程訂單相關資料
    $bookDate = date('Y-m-d H:i:s');  // 獲取當前日期和時間
    $courseId = $data['courseId'];  // 課程ID
    $courseName = $data['courseName'];  // 課程名稱
    $coursePrice = $data['coursePrice'];  // 課程價格
    $bookAmount = $data['participantCount'];  // 參加人數
    $bookPayableAmount = $data['courseSum'];  // 應付金額
    $disAmount = $data['discount'];  // 折扣金額
    $bookPaidAmount = $data['actualPaid'];  // 實際支付金額
    $customerId = $data['customerId'];  // 客戶ID
    $disSerial = $data['discountSerial'] ?? null;  // 折扣序號（如果有的話）
    $bookOrderStatus = '已完成';  // 訂單狀態，可以根據實際情況調整
    $bookTradingStatus = '已付款';  // 交易狀態，可以根據實際情況調整
    $bookRemark = $data['otherRequirements'];  // 其他需求/備註

    // 開始資料庫事務
    $pdo->beginTransaction();

    // 插入新的預約訂單
    $sql = "INSERT INTO course_bookings (
                book_date, book_course_id, book_course_name, book_course_price,
                book_amount, book_payable_amount, dis_amount, book_paid_amount,
                book_customer_id, dis_serial, book_order_status, book_trading_status, book_remark
            ) VALUES (
                :bookDate, :courseId, :courseName, :coursePrice,
                :bookAmount, :bookPayableAmount, :disAmount, :bookPaidAmount,
                :customerId, :disSerial, :bookOrderStatus, :bookTradingStatus, :bookRemark
            )";
        
    // 準備並執行 SQL 語句
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':bookDate', $bookDate);
    $stmt->bindValue(':courseId', $courseId);
    $stmt->bindValue(':courseName', $courseName);
    $stmt->bindValue(':coursePrice', $coursePrice);
    $stmt->bindValue(':bookAmount', $bookAmount);
    $stmt->bindValue(':bookPayableAmount', $bookPayableAmount);
    $stmt->bindValue(':disAmount', $disAmount);
    $stmt->bindValue(':bookPaidAmount', $bookPaidAmount);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->bindValue(':disSerial', $disSerial);
    $stmt->bindValue(':bookOrderStatus', $bookOrderStatus);
    $stmt->bindValue(':bookTradingStatus', $bookTradingStatus);
    $stmt->bindValue(':bookRemark', $bookRemark);
    $stmt->execute();

    $bookId = $pdo->lastInsertId();  // 獲取新插入預約的 ID

    // 準備預約訂單資訊陣列
    $booking = [
        'book_id' => $bookId,
        'book_date' => $bookDate,
        'book_course_id' => $courseId,
        'book_course_name' => $courseName,
        'book_course_price' => $coursePrice,
        'book_amount' => $bookAmount,
        'book_payable_amount' => $bookPayableAmount,
        'dis_amount' => $disAmount,
        'book_paid_amount' => $bookPaidAmount,
        'book_customer_id' => $customerId,
        'dis_serial' => $disSerial,
        'book_order_status' => $bookOrderStatus,
        'book_trading_status' => $bookTradingStatus,
        'book_remark' => $bookRemark
    ];

    // 提交事務
    $pdo->commit();

    // 準備成功回應
    $result = ["error" => false, "msg" => "課程預約成功", "booking" => $booking];
} catch (PDOException $e) {
    // 資料庫錯誤處理
    $pdo->rollback();  // 回滾事務
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    // 其他錯誤處理
    $pdo->rollback();  // 回滾事務
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
}

// 將結果轉換為 JSON 並輸出
echo json_encode($result, JSON_NUMERIC_CHECK);