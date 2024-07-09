<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  // 允許跨域請求，根據需要調整

try {
    //連線mysql
    require_once ("../../front/connectDataBase.php");

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = 'SELECT b.*, m.name, m.email, m.phone
            FROM booked_course b
            JOIN member m ON b.book_customer_id = m.no';

    if ($search) {
        $sql .= ' WHERE b.book_course_name LIKE :search 
                  OR m.name LIKE :search 
                  OR m.phone LIKE :search 
                  OR m.email LIKE :search 
                  OR b.book_id LIKE :search';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $result = ["error" => true, "msg" => "No orders found", "orderItem" => null];
    } else {
        $orderItemRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = ["error" => false, "msg" => "", "orderItem" => $orderItemRow];
    }

} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];

} catch (Exception $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ["error" => true, "msg" => $msg];
}

echo json_encode($result, JSON_NUMERIC_CHECK);
?>