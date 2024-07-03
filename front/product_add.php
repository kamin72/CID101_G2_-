<?php
header("Access-Control-Allow-Origin:*");
$data = json_decode(file_get_contents("php://input"), true);

try {

    require_once("./connectDataBase.php");
    $sql = "INSERT INTO product(prod_name, prod_ename, prod_category, prod_variety, prod_year, prod_price, prod_describe, prod_img, bg_img) VALUES(:prod_name, :prod_ename, :prod_category, :prod_variety, :prod_year, :prod_price, :prod_describe, :prod_img, :bg_img)";
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
    $prod = $data;

    echo json_encode(["error" => false, "msg" => "新增成功", "products" => $prod]);

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	echo json_encode($result);
}
?>
