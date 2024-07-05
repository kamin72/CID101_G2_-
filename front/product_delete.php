<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("./connectDataBase.php");
    $prod_id = $_GET['prod_id'];

    $sql = "DELETE FROM product WHERE prod_id = :prod_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":prod_id", $prod_id);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "刪除成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
