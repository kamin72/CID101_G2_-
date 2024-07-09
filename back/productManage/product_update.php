<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {

  require_once("../../front/connectDataBase.php");

  # 檢查商品圖是否上傳成功
  if( isset($_POST["prod_img"])) {
    $prod_img = $_POST["prod_img"];

  } else if ($_FILES['prod_img']['error'] === UPLOAD_ERR_OK){
  
      $file = $_FILES['prod_img']['tmp_name'];
      $dest = '../../images' . $_FILES['prod_img']['name'];
  
      # 將檔案移至指定位置
      move_uploaded_file($file, $dest);
      $prod_img = $_FILES['prod_img']['name'];

} else {
  echo '錯誤代碼：' . $_FILES['prod_img']['error'] . '<br/>';
}

  # 檢查背景圖是否上傳成功
  if( isset($_POST["bg_img"])) {
    $bg_img = $_POST["bg_img"];

  } else if ($_FILES['bg_img']['error'] === UPLOAD_ERR_OK){
  
      $file = $_FILES['bg_img']['tmp_name'];
      $dest = '../../images' . $_FILES['bg_img']['name'];
  
      # 將檔案移至指定位置
      move_uploaded_file($file, $dest);
      $bg_img = $_FILES['bg_img']['name'];

} else {
  echo '錯誤代碼：' . $_FILES['bg_img']['error'] . '<br/>';
} 


    // 準備 SQL 語句
      $sql = "UPDATE product SET 
              prod_name = :prod_name, 
              prod_ename = :prod_ename, 
              prod_category = :prod_category, 
              prod_variety = :prod_variety, 
              prod_year = :prod_year, 
              prod_price = :prod_price, 
              prod_describe = :prod_describe,
              prod_img = :prod_img,
              bg_img = :bg_img
              WHERE prod_id = :prod_id";

    $prodStmt = $pdo->prepare($sql);

    // 綁定 SQL 語句的參數
    $prodStmt->bindValue(":prod_id", $_POST["prod_id"]);
    $prodStmt->bindValue(":prod_name", $_POST["prod_name"]);
    $prodStmt->bindValue(":prod_ename", $_POST["prod_ename"]);
    $prodStmt->bindValue(":prod_category", $_POST["prod_category"]);
    $prodStmt->bindValue(":prod_variety", $_POST["prod_variety"]);
    $prodStmt->bindValue(":prod_year", $_POST["prod_year"]);
    $prodStmt->bindValue(":prod_price", $_POST["prod_price"]);
    $prodStmt->bindValue(":prod_describe", $_POST["prod_describe"]);
    $prodStmt->bindValue(":prod_img", $prod_img);
    $prodStmt->bindValue(":bg_img", $bg_img);
    $prodStmt->execute();

    echo json_encode(["error" => false, "msg" => "修改成功"]);

    } catch (PDOException $e) {
     echo json_encode(["error" => true, "msg" => $e->getMessage()]);
    }
?>
