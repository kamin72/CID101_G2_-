<?php
header('Content-Type: application/json');

require_once ("../../front/connectDataBase.php");

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;
    $remark = isset($_POST['remark']) ? $_POST['remark'] : null;

    if ($book_id !== null && $remark !== null) {
        try {
            $sql = "UPDATE booked_course SET book_remark = :remark WHERE book_id = :book_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':remark', $remark, PDO::PARAM_STR);
            $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = '備註更新成功';
            } else {
                $response['message'] = '更新失敗';
            }
        } catch (PDOException $e) {
            $response['message'] = '資料庫錯誤：' . $e->getMessage();
        }
    } else {
        $response['message'] = '無效的請求數據';
    }
} else {
    $response['message'] = '無效的請求方法';
}

echo json_encode($response);
?>