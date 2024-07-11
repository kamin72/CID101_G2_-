<?php

try {
    // 連接到MySQL資料庫
    require_once("../connectDataBase.php");

        $sql = "SELECT * FROM booked_course 
        LEFT JOIN member ON 
        member.no = booked_course.book_customer_id 
        LEFT JOIN course ON 
        booked_course.book_course_id = course.course_id";

        // 編譯sql指令(若上述資料有未知數)
        // 代入資料
        // 執行sql指令
        $booked_courses = $pdo->query($sql);

        // 執行

        // 如果找到資料，取回資料，送出JSON
        if ($booked_courses->rowCount() > 0) {
            $booked_coursesRow = $booked_courses->fetchAll(PDO::FETCH_ASSOC);
            $result = ['error' => false, 'msg' => '', 'booked_courses' => $booked_coursesRow];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $result = ['error' => true, 'msg' => '尚無資料', 'booked_courses' => []];
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    
} catch (PDOException $e) {
    // 資料庫錯誤處理
    $msg = '資料庫錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
} catch (Exception $e) {
    // 一般錯誤處理
    $msg = '系統錯誤，請稍後再試。';
    $result = ["error" => true, "msg" => $msg];
}
?>