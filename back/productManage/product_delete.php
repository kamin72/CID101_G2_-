<?php


try {
    require_once ("../../front/connectDataBase.php");
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