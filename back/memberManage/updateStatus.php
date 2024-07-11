<?php
$data = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../front/connectDataBase.php");

    // 开始事务
    $pdo->beginTransaction();

    // 更新状态
    $sql = "UPDATE member SET status = :status WHERE no = :no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":status", $data["status"]);
    $stmt->bindValue(":no", $data["no"]);
    $stmt->execute();

    // 如果是批发商会员，更新额外信息
    if (isset($data["company_name"])) {
        $sqlRetailer = "UPDATE member_retailer 
                        SET company_name = :company_name,
                            tax_id = :tax_id, 
                            address = :address
                        WHERE no = :no";
        $stmtRetailer = $pdo->prepare($sqlRetailer);
        $stmtRetailer->bindValue(":company_name", $data["company_name"]);
        $stmtRetailer->bindValue(":tax_id", $data["tax_id"]);
        $stmtRetailer->bindValue(":address", $data["address"]);
        $stmtRetailer->bindValue(":no", $data["no"]);
        $stmtRetailer->execute();
    }

    // 提交事务
    $pdo->commit();

    echo json_encode(["error" => false, "msg" => "更新資料成功"]);
} catch (PDOException $e) {
    // 回滚事务
    $pdo->rollBack();
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}

?>