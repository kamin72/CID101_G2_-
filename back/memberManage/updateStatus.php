<?php
$data = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../front/connectDataBase.php");
    $sql = "UPDATE member SET status = :status WHERE no = :no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":status", $data["status"]);
    $stmt->bindValue(":no", $data["no"]);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "修改成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>