<?php
header("Access-Control-Allow-Origin:*");
try {
	require_once("../connectDataBase.php");
	$sql = "SELECT * FROM course";
	$course = $pdo->query($sql);
	$courseRows = $course->fetchAll(PDO::FETCH_ASSOC);
	$result = ["error" => false, "msg" => "", "course" => $courseRows];
} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result, JSON_NUMERIC_CHECK);
?>