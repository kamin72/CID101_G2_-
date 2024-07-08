<?php
header('Content-Type: application/json');

try {
    require_once("../connectDataBase.php");
    $dis_serial = $_GET['dis_serial'];

    $sql = "DELETE FROM discount_type WHERE dis_serial = :dis_serial";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":dis_serial", $dis_serial);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "刪除成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
