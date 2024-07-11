<?php
try {
	require_once("../../front/connectDataBase.php");
	// $sql = "SELECT * FROM member";
    $sql = "SELECT *
            FROM member m
            LEFT JOIN member_retailer mr ON m.no = mr.no
            JOIN member a ON m.no = a.no
            ";
    $members = $pdo->query($sql);
    $membersRows = $members->fetchAll(PDO::FETCH_ASSOC);

    $result = ["error" => false, "msg" => "", "members" => $membersRows];
    } catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
    }

    echo json_encode($result);
    ?>