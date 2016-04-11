<?
	$arElementsID = array();
	$arProductsToElements = array();

	foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key => $val)
	{
		if ($arResult["ITEMS_IMG"][$val["ID"]])
		{
			$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
		}
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}
	
	foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key => $val)
	{
		if ($arResult["ITEMS_IMG"][$val["ID"]])
		{
			$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
		}
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}
	
	foreach($arResult["ITEMS"]["nAnCanBuy"] as $key => $val)
	{
		if ($arResult["ITEMS_IMG"][$val["ID"]])
		{
			$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
		}
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}
	
	foreach($arResult["ITEMS"]["ProdSubscribe"] as $key => $val)
	{
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}

	$arElementsID = array_unique($arElementsID);

	$db_res = CIBlockElement::GetList(Array("SORT"=>"ASC"),  Array("ID"=>$arElementsID), false, false, Array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL"));
	while($arElement = $db_res->GetNext())
	{
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key => $val)
		{
			if (in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
			}
		}
		
		foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key => $val)
		{
			if (in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
			}
		}
		
		foreach($arResult["ITEMS"]["nAnCanBuy"] as $key => $val)
		{
			if (in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
			}
		}
		
		foreach($arResult["ITEMS"]["ProdSubscribe"] as $key => $val)
		{
			if (in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
			}
		}
	}
?>