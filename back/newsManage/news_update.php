<?php
header("Access-Control-Allow-Origin:*");
try {
    // 获取传递的 news_id
    $news_id = $_POST["news_id"];

    // 检查上传图片的错误代码
    if (isset($_FILES["news_img"]) && $_FILES["news_img"]["error"] === UPLOAD_ERR_OK) {
        // 设置存储目录
        $dir = "../../image/news";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // 获取文件扩展名并生成新的文件名
        $fileExt = pathinfo($_FILES["news_img"]["name"], PATHINFO_EXTENSION);
        $filename = "$news_id.$fileExt";
        $from = $_FILES["news_img"]["tmp_name"];
        $to = "$dir/$filename";

        // 移动上传文件到目标目录
        move_uploaded_file($from, $to);
    } else {
        // 如果没有上传新图片，使用原始图片路径
        $filename = $_POST["original"];
    }

    // 连接数据库
    require_once("../connectDataBase.php");

    // 准备更新 SQL 语句
    $sql = "UPDATE news SET 
                news_title = :news_title, 
                news_content = :news_content, 
                news_date = :news_date, 
                news_active = :news_active,
                news_img = :news_img 
            WHERE news_id = :news_id";
    $news = $pdo->prepare($sql);

    // 绑定参数
    $news->bindValue(":news_title", $_POST["news_title"]);
    $news->bindValue(":news_content", $_POST["news_content"]);
    $news->bindValue(":news_date", $_POST["news_date"]);
    $news->bindValue(":news_active", $_POST["news_active"]);
    $news->bindValue(":news_id", $_POST["news_id"]);
    $news->bindValue(":news_img", $filename);

    // 执行更新操作
    $news->execute();

    // 返回结果
    $newsData = $_POST;
    $newsData["news_img"] = $filename;
    $result = ["error" => false, "msg" => "修改成功", "news" => $newsData];
} catch (PDOException $e) {
    // 捕获异常并返回错误信息
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 返回 JSON 格式的响应
echo json_encode($result, JSON_NUMERIC_CHECK);
?>
