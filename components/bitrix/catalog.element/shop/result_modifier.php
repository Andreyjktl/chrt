<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]))
{
	$basePriceType = CCatalogGroup::GetBaseGroup();
	$basePriceTypeName = $basePriceType["NAME"];

	$arOffersIblock = CIBlockPriceTools::GetOffersIBlock($arResult["IBLOCK_ID"]);
	$OFFERS_IBLOCK_ID = is_array($arOffersIblock)? $arOffersIblock["OFFERS_IBLOCK_ID"]: 0;
	$dbOfferProperties = CIBlock::GetProperties($OFFERS_IBLOCK_ID, Array(), Array("!XML_ID" => "CML2_LINK"));
	$arIblockOfferProps = array();
	$offerPropsExists = false;
	while($arOfferProperties = $dbOfferProperties->Fetch())
	{
		if (!in_array($arOfferProperties["CODE"],$arParams["OFFERS_PROPERTY_CODE"]))
			continue;
		$arIblockOfferProps[] = array("CODE" => $arOfferProperties["CODE"], "NAME" => $arOfferProperties["NAME"]);
		$offerPropsExists = true;
	}
	
	$arOfferIDs = array();
	foreach($arResult["OFFERS"] as $arOffer) { $arOfferIDs[] = $arOffer["ID"]; }
	$dbRes = CIBlockElement::GetList(Array("SORT"=>"ASC"),Array("ID"=>$arOfferIDs),false,false, Array("ID", "NAME"));
	while ($res=$dbRes->GetNext())
	{	
		foreach($arResult["OFFERS"] as $key=>$arOffer) 
		{ 
			if ($res["ID"]==$arOffer["ID"]) 
			{ 
				$arResult["OFFERS"][$key]["NAME"] = $res["NAME"]; 
			}
		}
	}
	

	$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
	$arNotify = unserialize($notifyOption);

	$arSku = array();
	$arResult["OFFERS_CATALOG_QUANTITY"] = 0;

	$strBaseCurrency = '';
	$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']);

	if (!$boolConvert)
		$strBaseCurrency = CCurrency::GetBaseCurrency();

	foreach($arResult["OFFERS"] as $arOffer)
	{		
		$arResult["OFFERS_CATALOG_QUANTITY"]  += $arOffer["CATALOG_QUANTITY"];
        /*foreach($arOffer["PRICES"] as $code=>$arPrice)
        {
            if($arPrice["CAN_ACCESS"])
            {
                if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"])
                {
                    $minOfferPrice = $arPrice["DISCOUNT_VALUE"];
                    $minOfferPriceFormat = $arPrice["PRINT_DISCOUNT_VALUE"];
                }
                else
                {
                    $minOfferPrice = $arPrice["VALUE"];
                    $minOfferPriceFormat = $arPrice["PRINT_VALUE"];
                }

                if ($minItemPrice > 0 && $minOfferPrice < $minItemPrice)
                {
                    $minItemPrice = $minOfferPrice;
                    $minItemPriceFormat = $minOfferPriceFormat;
                }
                elseif ($minItemPrice == 0)
                {
                    $minItemPrice = $minOfferPrice;
                    $minItemPriceFormat = $minOfferPriceFormat;
                }
            }
        }*/
		$arSkuTmp = array();
		
		if ($arParams["SKU_SHOW_PICTURES"]=="Y")
		{
			if ($arOffer["PREVIEW_PICTURE"])
			{
				$arSkuTmp["PREVIEW_PICTURE"] = CFile::GetFileArray($arOffer["PREVIEW_PICTURE"]);
			}
			elseif ($arOffer["DETAIL_PICTURE"])
			{
				$arSkuTmp["DETAIL_PICTURE"] = CFile::GetFileArray($arOffer["DETAIL_PICTURE"]);
			}	
		}
		
		$arSkuTmp["NAME"] = $arOffer["NAME"];
		$arSkuTmp["CATALOG_MEASURE"] = $arOffer["CATALOG_MEASURE"];
		$arSkuTmp["CATALOG_QUANTITY"] = $arOffer["CATALOG_QUANTITY"];
		if ($offerPropsExists)
		{
			foreach($arIblockOfferProps as $key => $arCode)
			{
				if (!array_key_exists($arCode["CODE"], $arOffer["PROPERTIES"]))
				{
					$arSkuTmp[] = GetMessage("EMPTY_VALUE_SKU");
					continue;
				}
				if (empty($arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]))
					$arSkuTmp[] = GetMessage("EMPTY_VALUE_SKU");
				elseif (is_array($arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]))
					$arSkuTmp[] = implode("/", $arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]);
				else
					$arSkuTmp[] = $arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"];
			}
		}
		else
		{
			if (in_array("NAME", $arParams["OFFERS_FIELD_CODE"]))
				$arSkuTmp[] = $arOffer["NAME"];
			else
				break;
		}
		$arSkuTmp["ID"] = $arOffer["ID"];
		if (is_array($arOffer["PRICES"][$basePriceTypeName]))
		{
			if ($arOffer["PRICES"][$basePriceTypeName]["DISCOUNT_VALUE"] < $arOffer["PRICES"][$basePriceTypeName]["VALUE"])
			{
				$arSkuTmp["PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_VALUE"];
				$arSkuTmp["DISCOUNT_PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_DISCOUNT_VALUE"];
			}
			else
			{
				$arSkuTmp["PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_VALUE"];
				$arSkuTmp["DISCOUNT_PRICE"] = "";
			}
		}
		if (CModule::IncludeModule('sale'))
		{
			$dbBasketItems = CSaleBasket::GetList(
				array(
					"ID" => "ASC"
				),
				array(
					"PRODUCT_ID" => $arOffer['ID'],
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
				),
				false,
				false,
				array()
			);
			$arSkuTmp["CART"] = "";
			if ($arBasket = $dbBasketItems->Fetch())
			{
				if($arBasket["DELAY"] == "Y")
					$arSkuTmp["CART"] = "delay";
				elseif ($arBasket["SUBSCRIBE"] == "Y" &&  $arNotify[SITE_ID]['use'] == 'Y')
					$arSkuTmp["CART"] = "inSubscribe";
				else
					$arSkuTmp["CART"] = "inCart";
			}
		}
		$arSkuTmp["CAN_BUY"] = $arOffer["CAN_BUY"];
		$arSkuTmp["ADD_URL"] = htmlspecialcharsback($arOffer["ADD_URL"]);
		$arSkuTmp["SUBSCRIBE_URL"] = htmlspecialcharsback($arOffer["SUBSCRIBE_URL"]);
		$arSkuTmp["COMPARE"] = "";
		if (isset($_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$arOffer["ID"]]))
			$arSkuTmp["COMPARE"] = "inCompare";
		$arSkuTmp["COMPARE_URL"] = htmlspecialcharsback($arOffer["COMPARE_URL"]);
		$arSku[] = $arSkuTmp;
	}
	
   /* $arResult["MIN_PRODUCT_OFFER_PRICE"] = $minItemPrice;
    $arResult["MIN_PRODUCT_OFFER_PRICE_PRINT"] = $minItemPriceFormat;*/

    /*set min_price*/
	$arMinPriceOffer=CIShop::getMinPriceFromOffersExt($arResult["OFFERS"], $boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency);
	$arResult["MIN_PRICE_OFFER"]=$arMinPriceOffer;


	if ((!is_array($arIblockOfferProps) || empty($arIblockOfferProps)) && is_array($arSku) && !empty($arSku))
		$arIblockOfferProps[] = array("CODE" => "TITLE", "NAME" => GetMessage("CATALOG_OFFER_NAME"));
	$arResult["SKU_ELEMENTS"] = $arSku;
	$arResult["SKU_PROPERTIES"] = $arIblockOfferProps;
}

if ($arParams['USE_COMPARE'])
{
	$delimiter = strpos($arParams['COMPARE_URL'], '?') ? '&' : '?';

	//$arResult['COMPARE_URL'] = str_replace("#ACTION_CODE#", "ADD_TO_COMPARE_LIST",$arParams['COMPARE_URL']).$delimiter."id=".$arResult['ID'];

	$arResult['COMPARE_URL'] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_TO_COMPARE_LIST&id=".$arResult['ID'], array("action", "id")));
}

if ($arParams["SHOW_KIT_PARTS"]=="Y")
{
	//const TYPE_SET = 1;
	//const TYPE_GROUP = 2;
	$arSetItems = array();
	$arResult["SET_ITEMS_IDS"] = array();
	$arSets = CCatalogProductSet::getAllSetsByProduct($arResult["ID"], 1);
	if(is_array($arSets) && $arSets){
		foreach( $arSets as $key => $set) { 
			foreach($set["ITEMS"] as $i=>$val) { 
				$arSetItems[] = $val["ITEM_ID"];  $arResult["SET_ITEMS_IDS"][$val["ITEM_ID"]] = $val; 
			}
		}
		
		$arResultPrices = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);
		
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE");
		foreach($arResultPrices as &$value)
		{
			if ($value['CAN_VIEW'] && $value['CAN_BUY']) { $arSelect[] = $value["SELECT"]; }
		}
		if (!empty($arSetItems))
		{
			$db_res = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("ID"=>$arSetItems), false, false, $arSelect);
			while ($res = $db_res->GetNext()) { $arResult["SET_ITEMS"][] = $res; }
			
		}
			
		$arConvertParams = array();
		if ('Y' == $arParams['CONVERT_CURRENCY'])
		{
			if (!CModule::IncludeModule('currency'))
			{
				$arParams['CONVERT_CURRENCY'] = 'N';
				$arParams['CURRENCY_ID'] = '';
			}
			else
			{
				$arResultModules['currency'] = true;
				$arCurrencyInfo = CCurrency::GetByID($arParams['CURRENCY_ID']);
				if (!(is_array($arCurrencyInfo) && !empty($arCurrencyInfo)))
				{
					$arParams['CONVERT_CURRENCY'] = 'N';
					$arParams['CURRENCY_ID'] = '';
				}
				else
				{
					$arParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
					$arConvertParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
				}
			}
		}
		
		$bCatalog = CModule::IncludeModule('catalog');
		
		foreach($arResult["SET_ITEMS"] as $key => $setItem)
		{
			if($arParams["USE_PRICE_COUNT"])
			{
				if($bCatalog)
				{
					$arResult["SET_ITEMS"][$key]["PRICE_MATRIX"] = CatalogGetPriceTableEx($arResult["SET_ITEMS"][$key]["ID"], 0, $arPriceTypeID, 'Y', $arConvertParams);
					foreach($arResult["SET_ITEMS"][$key]["PRICE_MATRIX"]["COLS"] as $keyColumn=>$arColumn)
						$arResult["SET_ITEMS"][$key]["PRICE_MATRIX"]["COLS"][$keyColumn]["NAME_LANG"] = htmlspecialcharsbx($arColumn["NAME_LANG"]);
				}
			}
			else
			{
				$arResult["SET_ITEMS"][$key]["PRICES"] = CIBlockPriceTools::GetItemPrices($arParams["IBLOCK_ID"], $arResultPrices, $arResult["SET_ITEMS"][$key], $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
				if (!empty($arResult["SET_ITEMS"][$key]["PRICES"]))
				{
					foreach ($arResult["SET_ITEMS"][$key]['PRICES'] as &$arOnePrice)
					{ if ('Y' == $arOnePrice['MIN_PRICE']) { $arResult["SET_ITEMS"][$key]['MIN_PRICE'] = $arOnePrice; break;} }
					unset($arOnePrice);
				}

			}

			if (($arParams["SHOW_MEASURE"]=="Y")&&($setItem["CATALOG_MEASURE"]))
			{ 
				$arResult["SET_ITEMS"][$key]["MEASURE"] = CCatalogMeasure::getList(array(), array("ID"=>$setItem["CATALOG_MEASURE"]), false, false, array())->GetNext(); 			
			}

		}
	}	
	
}

/*$cp = $this->__component;
if (is_object($cp))
{
	$cp->arResult["SECTION_FULL"] =$db_res;
	$cp->SetResultCacheKeys("SECTION_FULL");
}*/
?>
<?
if($arResult["DETAIL_PICTURE"]["SRC"]){
	$APPLICATION->AddHeadString('<link rel="image_src" href="'.$arResult["DETAIL_PICTURE"]["SRC"].'"  />', true);
}
?>