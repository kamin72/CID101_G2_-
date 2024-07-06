<?php
// 引入數據庫連接文件
require_once './connectDataBase.php';

// 獲取會員 ID（假設通過 GET 參數傳遞）
$memberId = isset($_GET['memberId']) ? intval($_GET['memberId']) : 0;

try {
    // 準備 SQL 查詢
    $sql = "SELECT g.dis_serial, g.dis_use_date, t.dis_serial, t.dis_amount, t.dis_name 
            FROM discount_got g JOIN discount_type t ON g.dis_serial = t.dis_serial
            WHERE g.member_no = :memberId AND g.dis_use_date IS NULL";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':memberId', $memberId, PDO::PARAM_INT);
    $stmt->execute();

    $discounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 返回 JSON 格式的結果
    echo json_encode(["error" => false, "discounts" => $discounts]);
} catch (PDOException $e) {
    // 錯誤處理
    echo json_encode(["error" => true, "message" => $e->getMessage()]);
} finally {
    // 關閉連接
    $pdo = null;
}
?>