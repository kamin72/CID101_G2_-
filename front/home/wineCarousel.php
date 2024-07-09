<?php

try{
    require_once("../connectDataBase.php");
    //準備sql指令
    $sql = "SELECT * FROM product WHERE prod_item = 1";
    //編譯sql指令(若上述資料有未知數)
    //代入資料
    //執行sql指令
    $wine = $pdo->query($sql);
  
    //如果找得資料，取回資料，送出json
    if($wine->rowCount() > 0) {
      $wineRows = $wine->fetchAll(PDO::FETCH_ASSOC);
      $result = ["error" => false, "msg" => "", "wine" => $wineRows];
    } else {
      $result = ["error" => false, "msg" => "無商品資料", "wine" => []];
    }
  } catch(PDOException $e) {
        $msg = "錯誤原因 : " . $e->getMessage(). ", "
           . "錯誤行號 : " . $e->getLine() ;
      //$msg = "系統錯誤, 請通知系統維護人員";
      $result = ["error" => true, "msg" => $mdg];
  
  }
  echo json_encode($result, JSON_NUMERIC_CHECK);

?>