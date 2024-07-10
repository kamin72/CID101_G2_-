<?php

require_once ("../../front/connectDataBase.php");
//準備sql指令
$sql1 = "DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `prod_id` int NOT NULL COMMENT 'not null(PK)',
  `prod_name` varchar(50) NOT NULL COMMENT 'not null',
  `prod_ename` varchar(50) NOT NULL COMMENT 'not null',
  `prod_category` varchar(50) NOT NULL COMMENT 'not null',
  `prod_variety` varchar(50) NOT NULL COMMENT 'not null',
  `prod_year` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'not null, 例如:2014年',
  `prod_price` int NOT NULL COMMENT 'not null, 批發商價格打8折',
  `prod_describe` varchar(1000) NOT NULL COMMENT 'not null',
  `prod_img` varchar(50) NOT NULL COMMENT 'not null',
  `bg_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'not null',
  `prod_state` tinyint(1) NOT NULL COMMENT '0:下架 1:上架',
  `prod_item` tinyint(1) NOT NULL COMMENT '0:一般商品 1:精選商品',
  `isChecked` tinyint(1) NOT NULL DEFAULT '0',
  `isOpen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:下拉選單打開狀態 1: 隱藏狀態',
  `isMenuVisible` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:篩選按鈕旁邊箭頭往上 1:往下',
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$result = $pdo->exec($sql1);

$sql2 = "INSERT INTO `product` (`prod_id`, `prod_name`, `prod_ename`, `prod_category`, `prod_variety`, `prod_year`, `prod_price`, `prod_describe`, `prod_img`, `bg_img`, `prod_state`, `prod_item`, `isChecked`, `isOpen`, `isMenuVisible`) VALUES
(1, '典雅馥紅酒 2014', 'Elegant Red Wine 2014', '紅酒', '波爾多混釀', '2014年', 7500, '這款紅酒散發出迷人的紅櫻桃、覆盆子和玫瑰花香氣，伴隨著淡淡的香料和泥土氣息。入口細膩，口感絲滑，酸度明亮且平衡，展現出優雅的結構和層次感。餘味持久且清新，帶有一絲薄荷和甘草的回味。\r\n', 'Elegant-Red-Wine.png', 'Background-image.png', 1, 1, 0, 0, 0),
(2, '典雅馥紅酒 2013', 'Elegant Red Wine 2013', '紅酒', '波爾多混釀', '2013年', 7600, '這款紅酒散發出迷人的紅櫻桃、覆盆子和玫瑰花香氣，伴隨著淡淡的香料和泥土氣息。入口細膩，口感絲滑，酸度明亮且平衡，展現出優雅的結構和層次感。餘味持久且清新，帶有一絲薄荷和甘草的回味。', 'Elegant-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(3, '典雅馥紅酒 2012', 'Elegant Red Wine 2012', '紅酒', '波爾多混釀', '2012年', 8000, '這款紅酒散發出迷人的紅櫻桃、覆盆子和玫瑰花香氣，伴隨著淡淡的香料和泥土氣息。入口細膩，口感絲滑，酸度明亮且平衡，展現出優雅的結構和層次感。餘味持久且清新，帶有一絲薄荷和甘草的回味。', 'Elegant-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(4, '典雅馥紅酒 2011', 'Elegant Red Wine 2011', '紅酒', '波爾多混釀', '2011年', 8200, '這款紅酒散發出迷人的紅櫻桃、覆盆子和玫瑰花香氣，伴隨著淡淡的香料和泥土氣息。入口細膩，口感絲滑，酸度明亮且平衡，展現出優雅的結構和層次感。餘味持久且清新，帶有一絲薄荷和甘草的回味。', 'Elegant-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(5, '卡本內紅酒 2014', 'Cabernet Red Wine 2014', '紅酒', '卡本內蘇維濃', '2014年', 5200, '這款紅酒以其複雜的紅果和辛香料風味著稱，口感豐富且層次分明，是品酒愛好者的理想之選。', 'Cabernet-Red-Wine.png', 'Background-image.png', 1, 1, 0, 0, 0),
(6, '卡本內紅酒 2013', 'Cabernet Red Wine 2013', '紅酒', '卡本內蘇維濃', '2013年', 5400, '這款紅酒以其複雜的紅果和辛香料風味著稱，口感豐富且層次分明，是品酒愛好者的理想之選。', 'Cabernet-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(7, '卡本內紅酒 2012', 'Cabernet Red Wine 2012', '紅酒', '卡本內蘇維濃', '2012年', 5600, '這款紅酒以其複雜的紅果和辛香料風味著稱，口感豐富且層次分明，是品酒愛好者的理想之選。', 'Cabernet-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(8, '卡本內紅酒 2011', 'Cabernet Red Wine 2011', '紅酒', '卡本內蘇維濃', '2011年', 5800, '這款紅酒以其複雜的紅果和辛香料風味著稱，口感豐富且層次分明，是品酒愛好者的理想之選。', 'Cabernet-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(9, '梅洛紅酒 2014', 'Merlot Red Wine 2014', '紅酒', '希哈', '2014年', 7400, '這款紅酒展現了深邃的紅色，帶有豐富的黑莓和成熟水果的香氣。口感豐滿且平衡，帶有優雅的橡木陳年風味和柔和的單寧，適合與各種佳餚搭配，是品味生活的最佳選擇。', 'Merlot-Red-Wine.png', 'Background-image.png', 1, 1, 0, 0, 0),
(10, '梅洛內紅酒 2013', 'Merlot Red Wine 2013', '紅酒', '希哈', '2013年', 7800, '這款紅酒展現了深邃的紅色，帶有豐富的黑莓和成熟水果的香氣。口感豐滿且平衡，帶有優雅的橡木陳年風味和柔和的單寧，適合與各種佳餚搭配，是品味生活的最佳選擇。', 'Merlot-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(11, '梅洛紅酒 2012', 'Merlot Red Wine 2012', '紅酒', '希哈', '2012年', 8200, '這款紅酒展現了深邃的紅色，帶有豐富的黑莓和成熟水果的香氣。口感豐滿且平衡，帶有優雅的橡木陳年風味和柔和的單寧，適合與各種佳餚搭配，是品味生活的最佳選擇。', 'Merlot-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(12, '梅洛內紅酒 2011', 'Merlot Red Wine 2011', '紅酒', '希哈', '2011年', 8600, '這款紅酒展現了深邃的紅色，帶有豐富的黑莓和成熟水果的香氣。口感豐滿且平衡，帶有優雅的橡木陳年風味和柔和的單寧，適合與各種佳餚搭配，是品味生活的最佳選擇。', 'Merlot-Red-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(13, '珍珠白酒 2014', 'Pearl White Wine 2014', '白酒', '夏多內', '2014年', 3600, '這款白酒具有柑橘類水果和白桃的香氣，伴隨著一絲礦物質和海鹽的味道。口感清爽，酸度活潑，餘味悠長。是搭配海鮮的絕佳選擇。', 'Pearl-White-Wine.png', 'Background-image.png', 1, 1, 0, 0, 0),
(14, '珍珠白酒 2013', 'Pearl White Wine 2013', '白酒', '夏多內', '2013年', 4000, '這款白酒具有柑橘類水果和白桃的香氣，伴隨著一絲礦物質和海鹽的味道。口感清爽，酸度活潑，餘味悠長。是搭配海鮮的絕佳選擇。', 'Pearl-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(15, '珍珠白酒 2012', 'Pearl White Wine 2012', '白酒', '夏多內', '2012年', 4600, '這款白酒具有柑橘類水果和白桃的香氣，伴隨著一絲礦物質和海鹽的味道。口感清爽，酸度活潑，餘味悠長。是搭配海鮮的絕佳選擇。', 'Pearl-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(16, '珍珠白酒 2011', 'Pearl White Wine 2011', '白酒', '夏多內', '2011年', 5200, '這款白酒具有柑橘類水果和白桃的香氣，伴隨著一絲礦物質和海鹽的味道。口感清爽，酸度活潑，餘味悠長。是搭配海鮮的絕佳選擇。', 'Pearl-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(17, '水晶白酒 2014', 'Ice White Wine 2014', '白酒', '麗絲玲', '2014年', 8200, '這款白酒色澤澄清，散發出清新的花香和成熟水果的香氣，口感清爽宜人，呈現豐富的柑橘和蜜桃風味，酸度適中，餘韻悠長。這款白酒適合單獨享用，或是搭配海鮮、蔬菜沙拉和輕盈的烤肉料理。', 'Ice-White-Wine.png', 'Background-image.png', 1, 1, 0, 0, 0),
(18, '水晶白酒 2013', 'Ice White Wine 2013', '白酒', '麗絲玲', '2013年', 8600, '這款白酒色澤澄清，散發出清新的花香和成熟水果的香氣，口感清爽宜人，呈現豐富的柑橘和蜜桃風味，酸度適中，餘韻悠長。這款白酒適合單獨享用，或是搭配海鮮、蔬菜沙拉和輕盈的烤肉料理。', 'Ice-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(19, '水晶白酒 2012', 'Ice White Wine 2012', '白酒', '麗絲玲', '2012年', 9000, '這款白酒色澤澄清，散發出清新的花香和成熟水果的香氣，口感清爽宜人，呈現豐富的柑橘和蜜桃風味，酸度適中，餘韻悠長。這款白酒適合單獨享用，或是搭配海鮮、蔬菜沙拉和輕盈的烤肉料理。', 'Ice-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(20, '水晶白酒 2011', 'Ice White Wine 2011', '白酒', '麗絲玲', '2011年', 9400, '這款白酒色澤澄清，散發出清新的花香和成熟水果的香氣，口感清爽宜人，呈現豐富的柑橘和蜜桃風味，酸度適中，餘韻悠長。這款白酒適合單獨享用，或是搭配海鮮、蔬菜沙拉和輕盈的烤肉料理。', 'Ice-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(21, '星光白酒 2014', 'Starlight White Wine 2014', '白酒', '白蘇維濃', '2014年', 6500, '這款白酒帶有清新的柑橘和成熟桃子香氣，口感豐富平衡，橡木陳釀風味明顯。', 'Starlight-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(22, '星光白酒 2013', 'Starlight White Wine 2013', '白酒', '白蘇維濃', '2013年', 7000, '這款白酒帶有清新的柑橘和成熟桃子香氣，口感豐富平衡，橡木陳釀風味明顯。', 'Starlight-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(23, '星光白酒 2012', 'Starlight White Wine 2012', '白酒', '白蘇維濃', '2012年', 7400, '這款白酒帶有清新的柑橘和成熟桃子香氣，口感豐富平衡，橡木陳釀風味明顯。', 'Starlight-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0),
(24, '星光白酒 2011', 'Starlight White Wine 2011', '白酒', '白蘇維濃', '2011年', 8000, '這款白酒帶有清新的柑橘和成熟桃子香氣，口感豐富平衡，橡木陳釀風味明顯。', 'Starlight-White-Wine.png', 'Background-image.png', 1, 0, 0, 0, 0);
COMMIT;";

$result2 = $pdo->exec($sql2);

echo '新增成功'




    ?>