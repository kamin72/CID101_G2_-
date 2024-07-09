<?php
header('Content-Type: application/json');
require_once ("../../front/connectDataBase.php");

try {
    $sql = "SELECT * FROM course ORDER BY course_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['error' => false, 'courses' => $courses]);
} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
?>