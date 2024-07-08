<?php
try {
    // 連線 mysql
    require_once ("../../front/connectDataBase.php");

    // 獲取當前頁碼和每頁項目數
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $itemsPerPage = isset($_GET['itemsPerPage']) ? max(1, (int) $_GET['itemsPerPage']) : 10;

    // 計算偏移量
    $offset = ($page - 1) * $itemsPerPage;

    // 獲取總記錄數
    $countSql = "SELECT COUNT(*) FROM carts";
    if (isset($_GET['identity']) && $_GET['identity'] != 0) {
        $countSql .= " c JOIN member m ON c.no = m.no WHERE identity = :identity";
    }
    $countStmt = $pdo->prepare($countSql);
    if (isset($_GET['identity']) && $_GET['identity'] != 0) {
        $countStmt->bindParam(':identity', $_GET['identity']);
    }
    $countStmt->execute();
    $totalItems = $countStmt->fetchColumn();

    // 準備 SQL 語句
    if (!isset($_GET['identity']) || $_GET['identity'] == 0) {
        $sql = "SELECT * FROM carts LIMIT :offset, :itemsPerPage";
        $stmt = $pdo->prepare($sql);
    } else {
        $sql = "SELECT c.cart_id, c.cart_name, c.phone, c.email, c.cart_status 
                FROM carts c JOIN member m ON c.no = m.no 
                WHERE identity = :identity LIMIT :offset, :itemsPerPage";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':identity', $_GET['identity']);
    }

    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    $itemsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 準備響應數據
    $response = [
        'items' => $itemsRow,
        'totalItems' => $totalItems,
        'currentPage' => $page,
        'itemsPerPage' => $itemsPerPage
    ];

    // 返回 JSON 格式的數據
    echo json_encode($response);

} catch (PDOException $e) {
    $msg = '錯誤原因:' . $e->getMessage() . ", 錯誤行號:" . $e->getLine() . ", 錯誤文件:" . $e->getFile();
    $result = ['error' => true, 'msg' => $msg];
    echo json_encode($result);
}
?>