<?php
header('Content-Type: application/json');

// 模擬資料庫連接
$host = 'localhost';
$dbname = 'your_database';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'msg' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// 取得POST資料
$data = json_decode(file_get_contents('php://input'), true);
$memberNo = $data['memberNo'];

// 當日日期
$today = date('Y-m-d');

// 檢查當日是否已領取過優惠券
try {
    $stmt = $pdo->prepare("SELECT * FROM discount_got WHERE member_no = :memberNo AND DATE(dis_got_date) = :today");
    $stmt->execute(['memberNo' => $memberNo, 'today' => $today]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        echo json_encode(['success' => true, 'couponAvailable' => false, 'msg' => '今天已領取過優惠券。']);
    } else {
        echo json_encode(['success' => true, 'couponAvailable' => true]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'msg' => 'Error checking coupon: ' . $e->getMessage()]);
}
?>
