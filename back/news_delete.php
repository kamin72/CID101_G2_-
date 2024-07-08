<?php
header("Access-Control-Allow-Origin:*");

try {
    require_once("./connectDataBase.php");
    $news_id = $_GET['news_id'];

    $sql = "DELETE FROM news WHERE news_id = :news_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":news_id", $news_id);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "刪除成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
