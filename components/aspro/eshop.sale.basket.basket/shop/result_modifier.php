<?
use Bitrix\Main\Loader;
static $catalogIncluded = null;

	$arElementsID = array();
	$arProductsToElements = array();
	$arMeasures = array();

	function getAvailableQuantity($arBasketItems)
	{
		if (empty($arBasketItems) || !is_array($arBasketItems))
			return array();
		if ($catalogIncluded === null)
			$catalogIncluded = Loader::includeModule('catalog');
		if (!$catalogIncluded)
			return false;

		$arElementId = array();
		$productMap = array();
		foreach ($arBasketItems as $key => $arItem)
		{
			$arElementId[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
			if (!isset($productMap[$arItem['PRODUCT_ID']]))
				$productMap[$arItem['PRODUCT_ID']] = array();
			$productMap[$arItem['PRODUCT_ID']][] = $key;
		}
		unset($key, $arItem);

		if (!empty($arElementId))
		{
			$productIterator = CCatalogProduct::GetList(
				array(),
				array('ID' => $arElementId),
				false,
				false,
				array('ID', 'QUANTITY')
			);
			while ($product = $productIterator->Fetch())
			{
				if (!isset($productMap[$product['ID']]))
					continue;
				foreach ($productMap[$product['ID']] as $key)
					$arBasketItems[$key]['AVAILABLE_QUANTITY'] = $product['QUANTITY'];
				unset($key);
			}
			unset($product, $productIterator);
		}
		unset($productMap, $arElementId);

		return $arBasketItems;
	}
	
	if ($arParams["SHOW_MEASURE"]=="Y")
	{
		$arIDs = array();
		
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key=>$arItem) { $arIDs[] = $arItem["PRODUCT_ID"]; }
		foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key=>$arItem) { $arIDs[] = $arItem["PRODUCT_ID"]; }
		foreach($arResult["ITEMS"]["nAnCanBuy"] as $key=>$arItem) { $arIDs[] = $arItem["PRODUCT_ID"]; }
		foreach($arResult["ITEMS"]["ProdSubscribe"] as $key=>$arItem) { $arIDs[] = $arItem["PRODUCT_ID"]; }
		
		$db_res = CCatalogProduct::GetList(array(), Array("ID"=>$arIDs), false, false, array("ID", "MEASURE"));
		while($res=$db_res->GetNext()) { $arMeasures[$res["ID"]] =  $res["MEASURE"];  }
		
		$db_res = CCatalogMeasure::getList(array(), array("ID"=>$arMeasures), false, false, array()); 
		while($res=$db_res->GetNext())
		{
			foreach ($arMeasures as $key=>$value) { if ($res["ID"]==$value) { $arMeasures[$key] = $res; } }
		}	

		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key=>$arItem) 
		{ 
			foreach ($arMeasures as $i=>$value) { if ($arItem["PRODUCT_ID"]==$i) { $arResult["ITEMS"]["AnDelCanBuy"][$key]["MEASURE"] = $value; } }
		}
		foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key=>$arItem) 
		{ 
			foreach ($arMeasures as $i=>$value) { if ($arItem["PRODUCT_ID"]==$i) { $arResult["ITEMS"]["DelDelCanBuy"][$key]["MEASURE"] = $value; } }
		}
		foreach($arResult["ITEMS"]["nAnCanBuy"] as $key=>$arItem) 
		{ 
			foreach ($arMeasures as $i=>$value) { if ($arItem["PRODUCT_ID"]==$i) { $arResult["ITEMS"]["nAnCanBuy"][$key]["MEASURE"] = $value; } }
		}
		foreach($arResult["ITEMS"]["ProdSubscribe"] as $key=>$arItem) 
		{ 
			foreach ($arMeasures as $i=>$value) { if ($arItem["PRODUCT_ID"]==$i) { $arResult["ITEMS"]["ProdSubscribe"][$key]["MEASURE"] = $value; } }
		}	
	}
		

	foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key => $val)
	{
		if (array_key_exists($val["PRODUCT_ID"], $arMeasures))
		{
			$arResult["ITEMS"]["AnDelCanBuy"][$key]["CATALOG_MEASURE"] = $arMeasures[$val["PRODUCT_ID"]];
		}
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
	if(function_exists(getMeasures)){
		$arResult["ITEMS"]["AnDelCanBuy"]=getMeasures($arResult["ITEMS"]["AnDelCanBuy"]);
	}
	if(function_exists(getRatio)){
		$arResult["ITEMS"]["AnDelCanBuy"]=getRatio($arResult["ITEMS"]["AnDelCanBuy"]);
	}
	$arResult["ITEMS"]["AnDelCanBuy"]=getAvailableQuantity($arResult["ITEMS"]["AnDelCanBuy"]);

	foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key => $val)
	{
		if ($arResult["ITEMS_IMG"][$val["ID"]])
		{
			$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
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
			$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
		}
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}
	
	foreach($arResult["ITEMS"]["ProdSubscribe"] as $key => $val)
	{
		if ($arResult["ITEMS_IMG"][$val["ID"]])
		{
			$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PICTURE"] = $arResult["ITEMS_IMG"][$val["ID"]];
		}
		if ($productId = CCatalogSku::GetProductInfo($val["PRODUCT_ID"]))
		{
			$arElementsID[] = $productId["ID"];
			$arProductsToElements[$productId["ID"]][] = $val["PRODUCT_ID"];
		}
	}

	$arElementsID = array_unique($arElementsID);

	$db_res = CIBlockElement::GetList(Array("SORT"=>"ASC"),  Array("ID"=>$arElementsID), false, false, Array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PREVIEW_PICTURE"));
	while($arElement = $db_res->GetNext())
	{
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key => $val)
		{
			if ($arProductsToElements && in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
				if (!$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"]["SRC"])
				{
					if (!$arResult["ITEMS"]["AnDelCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"])
					{
						$img = array();
						if ($arElement["DETAIL_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => "60", "height" => "60")); }
						elseif ($arElement["PREVIEW_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array("width" => "60", "height" => "60")); }
						if ($img["src"])  { foreach($img as $i=>$v) {$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"][strtoupper($i)]=$v;} }
					} else {$arResult["ITEMS"]["AnDelCanBuy"][$key]["DETAIL_PICTURE"]["SRC"] = $arResult["ITEMS"]["AnDelCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"];}
				}
			}
		}
		
		foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key => $val)
		{
			if ($arProductsToElements && in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
				if (!$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PICTURE"]["SRC"])
				{
					if (!$arResult["ITEMS"]["DelDelCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"])
					{
						$img = array();
						if ($arElement["DETAIL_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => "60", "height" => "60")); }
						elseif ($arElement["PREVIEW_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array("width" => "60", "height" => "60")); }
						if ($img["src"])  { foreach($img as $i=>$v) {$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PICTURE"][strtoupper($i)]=$v;} }
					} else {$arResult["ITEMS"]["DelDelCanBuy"][$key]["DETAIL_PICTURE"]["SRC"] = $arResult["ITEMS"]["DelDelCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"];}
				}
			}	
		}
		
		foreach($arResult["ITEMS"]["nAnCanBuy"] as $key => $val)
		{
			if ($arProductsToElements && in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
				
				if (!$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PICTURE"]["SRC"])
				{
					if (!$arResult["ITEMS"]["nAnCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"])
					{
						$img = array();
						if ($arElement["DETAIL_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => "60", "height" => "60")); }
						elseif ($arElement["PREVIEW_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array("width" => "60", "height" => "60")); }
						if ($img["src"])  { foreach($img as $i=>$v) {$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PICTURE"][strtoupper($i)]=$v;} }
					} else {$arResult["ITEMS"]["nAnCanBuy"][$key]["DETAIL_PICTURE"]["SRC"] = $arResult["ITEMS"]["nAnCanBuy"][$key]["PREVIEW_PICTURE"]["SRC"];}
				}
			}
		}
		
		foreach($arResult["ITEMS"]["ProdSubscribe"] as $key => $val)
		{
			if ($arProductsToElements && in_array($val["PRODUCT_ID"], $arProductsToElements[$arElement["ID"]]))
			{
				$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PAGE_URL"]=$arElement["DETAIL_PAGE_URL"];
				
				if (!$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PICTURE"]["SRC"])
				{
					if (!$arResult["ITEMS"]["ProdSubscribe"][$key]["PREVIEW_PICTURE"]["SRC"])
					{
						$img = array();
						if ($arElement["DETAIL_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], Array("width" => "60", "height" => "60")); }
						elseif ($arElement["PREVIEW_PICTURE"]) { $img = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], Array("width" => "60", "height" => "60")); }
						if ($img["src"])  { foreach($img as $i=>$v) {$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PICTURE"][strtoupper($i)]=$v;} }
					} else {$arResult["ITEMS"]["ProdSubscribe"][$key]["DETAIL_PICTURE"]["SRC"] = $arResult["ITEMS"]["ProdSubscribe"][$key]["PREVIEW_PICTURE"]["SRC"];}
				}
			}
		}
	}
?>