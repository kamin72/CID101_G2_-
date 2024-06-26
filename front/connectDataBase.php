<?php
// 允許從 Vue 應用的域名訪問
header("Access-Control-Allow-Origin: http://localhost:5173");
// 允許的請求方法
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// 允許的請求頭
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// 允許攜帶認證信息（如 cookies）
header("Access-Control-Allow-Credentials: true");

// 處理預檢請求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$dbname = "cid101_g2";
$user = "root";
$password = "";

$dsn = "mysql:host=localhost;port=3306;dbname=$dbname;charset=utf8";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE => PDO::CASE_LOWER);

//建立pdo物件
$pdo = new PDO($dsn, $user, $password, $options);
?>