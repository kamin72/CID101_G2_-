<?php
// 包含資料庫連接文件
require_once("./connectDataBase.php");

// 準備 SQL 查詢
$sql = "SELECT 
            book_id AS order_id,
            book_date AS order_date,
            book_course_name AS course_name,
            (SELECT customer_name FROM customers WHERE customer_id = book_customer_id) AS customer_name,
            book_amount AS quantity,
            book_payable_amount AS total_amount,
            book_order_status AS order_status,
            book_trading_status AS payment_status
        FROM 
            course_bookings
        ORDER BY 
            book_date DESC";

try {
    // 執行查詢
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // 獲取所有結果
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 將結果轉換為 JSON 格式
    echo json_encode($orders);
} catch(PDOException $e) {
    // 如果發生錯誤，返回錯誤信息
    echo json_encode(["error" => $e->getMessage()]);
}

// 關閉資料庫連接
$pdo = null;
?>