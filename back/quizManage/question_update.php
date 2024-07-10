<?php
$data = json_decode(file_get_contents('php://input'), true);

try {
    require_once ("../../front/connectDataBase.php");
    $sql = "UPDATE question SET q_name = :q_name, q_option_a = :q_option_a, q_option_b = :q_option_b, q_ans = :q_ans WHERE q_no = :q_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":q_name", $data["q_name"]);
    $stmt->bindValue(":q_option_a", $data["q_option_a"]);
    $stmt->bindValue(":q_option_b", $data["q_option_b"]);
    $stmt->bindValue(":q_ans", $data["q_ans"]);
    $stmt->bindValue(":q_no", $data["q_no"]);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "修改成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>