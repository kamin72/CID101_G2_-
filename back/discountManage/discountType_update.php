<?php
$data = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../front/connectDataBase.php");
    $sql = "UPDATE discount_type SET dis_name = :dis_name, dis_amount = :dis_amount, dis_set_date = :dis_set_date WHERE dis_serial = :dis_serial";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":dis_name", $data["dis_name"]);
    $stmt->bindValue(":dis_amount", $data["dis_amount"]);
    $stmt->bindValue(":dis_set_date", $data["dis_set_date"]);
    $stmt->bindValue(":dis_serial", $data["dis_serial"]);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "修改成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>