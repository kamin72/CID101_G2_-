<?php
header("Access-Control-Allow-Origin:*");
try {
    require_once("./connectDataBase.php");

    // 先啟動交易管理
    $pdo->beginTransaction();

    // 新增一筆新聞資料
    $sql = "INSERT INTO news(news_title, news_content, news_date, news_active, news_img) VALUES 
    (:news_title, :news_content, :news_date, :news_active, :news_img)";
    $news = $pdo->prepare($sql);

    $news->bindValue(":news_title", $_POST["news_title"]);
    $news->bindValue(":news_content", $_POST["news_content"]);
    $news->bindValue(":news_date", $_POST["news_date"]);
    $news->bindValue(":news_active", $_POST["news_active"]);
    $news->bindValue(":news_img", '');
    $news->execute();

    $news_id = $pdo->lastInsertId();

    // 取得上傳檔案
    if ($_FILES["news_img"]["error"] === 0) {
        $dir = "../../image/news";
        if (!file_exists($dir)) {
            mkdir($dir, 0777 , true);
        }
        $fileExt = pathinfo($_FILES["news_img"]["name"], PATHINFO_EXTENSION);
        $filename = "$news_id.$fileExt";
        $from = $_FILES["news_img"]["tmp_name"];
        $to = "$dir/$filename";
        copy($from, $to);
    } else {
        throw new Exception("檔案上傳失敗,$to");
    }

    // 修改剛寫入的圖檔
    $sql = "UPDATE news SET news_img='$filename' WHERE news_id=$news_id";
    if($pdo->exec($sql) != 1) {
        throw new Exception("圖片寫入失敗");
    } else {
        $pdo->commit();
    }

    $news = $_POST;
    $news["news_id"] = $news_id;
    $news["news_img"] = $filename;
    $result = ["error" => false, "msg" => "新增成功", "news" => $news];
} catch (PDOException $e) {
    $pdo->rollback();
    $result = ["error" => true, "msg" => $e->getMessage()];
} catch (Exception $e) {
    $pdo->rollback();
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result, JSON_NUMERIC_CHECK);
?>
