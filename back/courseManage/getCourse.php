<?php
header('Content-Type: application/json');
require_once ("../../front/connectDataBase.php");

$response = ['success' => false, 'message' => '', 'course' => null];

if (isset($_GET['id'])) {
    $courseId = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM course WHERE course_id = :id");
        $stmt->execute(['id' => $courseId]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($course) {
            $response['success'] = true;
            $response['course'] = $course;
        } else {
            $response['message'] = '未找到指定課程';
        }
    } catch (PDOException $e) {
        $response['message'] = '數據庫錯誤：' . $e->getMessage();
    }
} else {
    $response['message'] = '未提供課程 ID';
}

echo json_encode($response);
?>