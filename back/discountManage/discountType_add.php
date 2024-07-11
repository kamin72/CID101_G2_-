<?php
header("Access-Control-Allow-Origin:*");
$data = json_decode(file_get_contents("php://input"), true);

try {

    require_once("../../front/connectDataBase.php");
    $sql = "INSERT INTO discount_type(dis_name, dis_amount, dis_set_date) VALUES(:dis_name, :dis_amount, :dis_set_date)";
    $disStmt = $pdo->prepare( $sql );
    $disStmt->bindValue(":dis_name", $data["dis_name"]);
    $disStmt->bindValue(":dis_amount", $data["dis_amount"]);
    $disStmt->bindValue(":dis_set_date", $data["dis_set_date"]);
    $disStmt->execute();
    $dis = $data;

    echo json_encode(["error" => false, "msg" => "新增成功", "discount" => $dis]);

} catch (PDOException $e) {
	$result = ["error" => true, "msg" => $e->getMessage()];
	echo json_encode($result);
}
?>
