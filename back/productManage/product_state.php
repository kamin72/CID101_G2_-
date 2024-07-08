<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// 獲取原始 POST 數據
$json = file_get_contents('php://input');
$data = json_decode($json, true);

try {
    require_once("../../front/connectDataBase.php");

    // 準備 SQL 語句
    $sql = "UPDATE product SET prod_state = :prod_state WHERE prod_id = :prod_id";

    $stmt = $pdo->prepare($sql);

    // 綁定 SQL 語句的參數
    $stmt->bindValue(':prod_id', $data["prod_id"]);
    $stmt->bindValue(':prod_state', $data["prod_state"]);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "商品狀態已更新"]);
   
} catch (PDOException $e) {
  echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
