<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

try {
    require_once("./connectDataBase.php");
    $sql = "UPDATE product SET prod_name = :prod_name, prod_ename = :prod_ename, prod_category = :prod_category, prod_variety = :prod_variety, prod_year = :prod_year, prod_price = :prod_price, prod_describe = :prod_describe, prod_img = :prod_img, bg_img = :bg_img WHERE prod_id = :prod_id";
    $prodStmt = $pdo->prepare($sql);
    $prodStmt->bindValue(":prod_name", $data["prod_name"]);
    $prodStmt->bindValue(":prod_ename", $data["prod_ename"]);
    $prodStmt->bindValue(":prod_category", $data["prod_category"]);
    $prodStmt->bindValue(":prod_variety", $data["prod_variety"]);
    $prodStmt->bindValue(":prod_year", $data["prod_year"]);
    $prodStmt->bindValue(":prod_price", $data["prod_price"]);
    $prodStmt->bindValue(":prod_describe", $data["prod_describe"]);
    $prodStmt->bindValue(":prod_img", $data["prod_img"]);
    $prodStmt->bindValue(":bg_img", $data["bg_img"]);
    $prodStmt->execute();

    echo json_encode(["error" => false, "msg" => "修改成功"]);
} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
