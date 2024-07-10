<?php
header("Access-Control-Allow-Origin:*");
header('Content-Type: application/json');
require_once ("../../front/connectDataBase.php");

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['course_id'])) {
        $courseId = $input['course_id'];

        try {
            $stmt = $pdo->prepare("DELETE FROM course WHERE course_id = :id");
            $result = $stmt->execute(['id' => $courseId]);

            if ($result) {
                $response['success'] = true;
                $response['message'] = '課程已成功刪除';
            } else {
                $response['message'] = '刪除課程失敗';
            }
        } catch (PDOException $e) {
            $response['message'] = '數據庫錯誤：' . $e->getMessage();
        }
    } else {
        $response['message'] = '未提供課程 ID';
    }
} else {
    $response['message'] = '無效的請求方法';
}

echo json_encode($response);
?>