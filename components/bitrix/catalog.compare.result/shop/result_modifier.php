<?

$arInfo = CCatalogSKU::GetInfoByProductIBlock($arParams["IBLOCK_ID"]);


if ($arInfo)
{
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
	
	
	foreach( $arResult["ITEMS"] as $key => $arItem )
	{
		$rsOffers = CIBlockElement::GetList(array(),array("IBLOCK_ID" => $arInfo["IBLOCK_ID"], "PROPERTY_".$arInfo["SKU_PROPERTY_ID"] => $arItem["ID"]), false, false, array("ID", "CATALOG_QUANTITY"));
		
		$arOffers = CIBlockPriceTools::GetOffersArray(
			$arParams["IBLOCK_ID"]
			,$arItem["ID"]
			,array(
				$arParams["OFFERS_SORT_FIELD"] => $arParams["OFFERS_SORT_ORDER"],
				"ID" => "DESC",
			)
			,$arParams["OFFERS_FIELD_CODE"]
			,$arParams["OFFERS_PROPERTY_CODE"]
			,$arParams["OFFERS_LIMIT"]
			,$arResult["PRICES"]
			,$arParams['PRICE_VAT_INCLUDE']
			,$arConvertParams
		);

		foreach ($arOffers as $arOffer )
		{
			
			$arResult["ITEMS"][$key]["OFFERS"][] = $arOffer;
			$dbProductDiscounts = CCatalogDiscount::GetList(array(), array("PRODUCT_ID" => $arOffer["ID"]));
			if ($dbProductDiscounts && $dbProductDiscounts->SelectedRowsCount()>0)
			{
				while( $arProductDiscounts = $dbProductDiscounts->GetNext() )
				{
					if( $arProductDiscounts["VALUE_TYPE"] == "F" )
					{
						echo "f";
						$i = 0;
						foreach( $arResult["ITEMS"][$key]["OFFERS"] as $item_offer )
						{
							$j = 0;
							foreach( $item_offer["PRICES"] as $item_prices )
							{
								$arResult["ITEMS"][$key]["OFFERS"][$i]["PRICES"][$j]["DISCOUNT_PRICE"] = $item_prices["PRICE"] - $arProductDiscounts["VALUE"];
								$j++;
							}
							$i++;
						}
					}
					elseif( $arProductDiscounts["VALUE_TYPE"] == "P" )
					{
						echo "p";
						$i = 0;
						foreach( $arResult["ITEMS"][$key]["OFFERS"] as $item_offer )
						{
							$j = 0;
							foreach( $item_offer["PRICES"] as $item_prices )
							{
								$arResult["ITEMS"][$key]["OFFERS"][$i]["PRICES"][$j]["DISCOUNT_PRICE"] = $item_prices["PRICE"] - ( $item_prices["PRICE"] / 100 * $arProductDiscounts["VALUE"] );
								$j++;
							}
							$i++;
						}
					}
				}
			}		
		}
	}
}


$prop = array();
$prop_arr = array();

foreach( $arResult["ITEMS"] as $arItem ):
	foreach( $arItem["DISPLAY_PROPERTIES"] as $arProp ):
		if( !empty($arProp["VALUE"]) ):
			$prop_arr[$arProp["ID"]] = $arProp["ID"];
		endif;
	endforeach;
endforeach;

foreach( $arResult["ITEMS"] as $arItem ):
	foreach( $arItem["DISPLAY_PROPERTIES"] as $arProp ):
		if( array_key_exists($arProp["ID"], $prop_arr) ):
			$prop[$arProp["CODE"]]["NAME"] = $arProp["NAME"];
			$prop[$arProp["CODE"]]["ITEMS"][$arItem["ID"]] = $arProp;
		endif;
	endforeach;
endforeach;

$arResult["DISPLAY_PROPERTIES"] = $prop;

$arResult["START_POSITION"] = 1;
$arResult["END_POSITION"] = 4;
?>