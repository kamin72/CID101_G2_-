<?php

try{
  require_once("../../front/connectDataBase.php");
    //準備sql指令
    $sql = "select * from product";
    //編譯sql指令(若上述資料有未知數)
    //代入資料
    //執行sql指令
    $products = $pdo->query($sql);
  
    //如果找得資料，取回資料，送出json
    if($products->rowCount() > 0) {
      $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
      $result = ["error" => false, "msg" => "", "products" => $prodRows];
    } else {
      $result = ["error" => false, "msg" => "無商品資料", "products" => []];
    }
  } catch(PDOException $e) {
        $msg = "錯誤原因 : " . $e->getMessage(). ", "
           . "錯誤行號 : " . $e->getLine() ;
      //$msg = "系統錯誤, 請通知系統維護人員";
      $result = ["error" => true, "msg" => $mdg];
  
  }
  echo json_encode($result, JSON_NUMERIC_CHECK);

?>
