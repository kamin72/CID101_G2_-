<?php
header("Access-Control-Allow-Origin:*");
header('Content-Type: application/json');
require_once ("../../front/connectDataBase.php");

$input = json_decode(file_get_contents('php://input'), true);
$course_id = $input['course_id'];
$course_status = $input['course_status'];

try {
    $stmt = $pdo->prepare("UPDATE course SET course_status = :status WHERE course_id = :id");
    $result = $stmt->execute([
        ':status' => $course_status,
        ':id' => $course_id
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => '課程狀態更新成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '課程狀態更新失敗']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>