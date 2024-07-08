<?php
header("Access-Control-Allow-Origin:*");
try {
	require_once("./connectDataBase.php");
	$sql = "select * from news";
	$news = $pdo->query($sql);
	$newsRows = $news->fetchAll(PDO::FETCH_ASSOC);
	$result = ["error" => false, "msg" => "", "news" => $newsRows];
} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result, JSON_NUMERIC_CHECK);
?>