<?php
try {
    require_once ("./connectDataBase.php");

    // 檢查是否有傳入 id 參數
    if (isset($_GET['id'])) {
        $courseId = $_GET['id'];
        $sql = "SELECT * FROM course WHERE course_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // 如果沒有 id，則獲取所有課程
        $sql = "SELECT * FROM course";
        $stmt = $pdo->query($sql);
    }

    if ($stmt->rowCount() > 0) {
        $courseRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = ['error' => false, 'msg' => '', 'course' => $courseRow];
        echo json_encode($result, JSON_NUMERIC_CHECK);
    } else {
        $result = ['error' => true, 'msg' => '查無課程資料，請重新輸入', 'course' => []];
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . "," . "錯誤行號:" . $e->getLine() . "," . "錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
    echo json_encode($result, JSON_NUMERIC_CHECK);
}