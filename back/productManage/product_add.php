<?php

try {

  require_once ("../../front/connectDataBase.php");

  # 檢查商品圖是否上傳成功
  if ($_FILES['prod_img']['error'] === UPLOAD_ERR_OK) {

    $file = $_FILES['prod_img']['tmp_name'];
    $dest = '../../images' . $_FILES['prod_img']['name'];

    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);

  } else {
    echo '錯誤代碼：' . $_FILES['prod_img']['error'] . '<br/>';
  }


  # 檢查背景圖是否上傳成功
  if ($_FILES['bg_img']['error'] === UPLOAD_ERR_OK) {

    $file = $_FILES['bg_img']['tmp_name'];
    $dest = '../../images' . $_FILES['bg_img']['name'];

    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);

  } else {
    echo '錯誤代碼：' . $_FILES['bg_img']['error'] . '<br/>';
  }

  // 準備 SQL 語句
  $sql = "INSERT INTO product(prod_id, prod_name, prod_ename, prod_category, prod_variety, prod_year, prod_price, prod_describe, prod_img, bg_img) VALUES(:prod_id, :prod_name, :prod_ename, :prod_category, :prod_variety, :prod_year, :prod_price, :prod_describe, :prod_img, :bg_img)";

  $prodStmt = $pdo->prepare($sql);


  $prodStmt->bindValue(":prod_id", $_POST["prod_id"]);
  $prodStmt->bindValue(":prod_name", $_POST["prod_name"]);
  $prodStmt->bindValue(":prod_ename", $_POST["prod_ename"]);
  $prodStmt->bindValue(":prod_category", $_POST["prod_category"]);
  $prodStmt->bindValue(":prod_variety", $_POST["prod_variety"]);
  $prodStmt->bindValue(":prod_year", $_POST["prod_year"]);
  $prodStmt->bindValue(":prod_price", $_POST["prod_price"]);
  $prodStmt->bindValue(":prod_describe", $_POST["prod_describe"]);
  $prodStmt->bindValue(":prod_img", $_FILES['prod_img']['name']);
  $prodStmt->bindValue(":bg_img", $_FILES['bg_img']['name']);
  $prodStmt->execute();

  echo json_encode(["error" => false, "msg" => "新增成功", "products" => $prodStmt]);

} catch (PDOException $e) {
  $result = ["error" => true, "msg" => $e->getMessage()];
  echo json_encode($result);
}
?>
