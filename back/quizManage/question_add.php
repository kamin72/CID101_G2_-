<?php
$data = json_decode(file_get_contents("php://input"), true);

try {
    require_once ("../../front/connectDataBase.php");
    $sql = "INSERT INTO question(q_name, q_option_a, q_option_b, q_ans) VALUES(:q_name, :q_option_a, :q_option_b, :q_ans)";
    $disStmt = $pdo->prepare($sql);
    $disStmt->bindValue(":q_name", $data["q_name"]);
    $disStmt->bindValue(":q_option_a", $data["q_option_a"]);
    $disStmt->bindValue(":q_option_b", $data["q_option_b"]);
    $disStmt->bindValue(":q_ans", $data["q_ans"]);
    $disStmt->execute();
    $q_no = $pdo->lastInsertId();

    $disStmt = [
        'q_no' => $q_no,
        'q_name' => $data["q_name"],
        'q_option_a' => $data["q_option_a"],
        'q_option_b' => $data["q_option_b"],
        'q_ans' => $data["q_ans"]
    ];

    echo json_encode(["error" => false, "msg" => "新增成功", "question" => $disStmt]);

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    echo json_encode($result);
}
?>