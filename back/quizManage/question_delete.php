<?php

try {
    require_once ("../../front/connectDataBase.php");
    $q_no = $_GET['q_no'];

    $sql = "DELETE FROM question WHERE q_no = :q_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":q_no", $q_no);
    $stmt->execute();

    echo json_encode(["error" => false, "msg" => "刪除成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>