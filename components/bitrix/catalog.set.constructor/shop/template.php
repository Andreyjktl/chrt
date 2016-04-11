<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$intElementID = intval($arParams["ELEMENT_ID"]);
	CJSCore::Init(array("popup"));
	$countDefSetItems = count($arResult["SET_ITEMS"]["DEFAULT"]);
?>

<div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div>
<div class="bx_item_set_hor_container_big set_wrapp">
	<a class="button4 set_construct" onclick="OpenCatalogSetPopup('<?=$intElementID?>');"><span><?=GetMessage("CATALOG_SET_CONSTRUCT")?></span></a>
	<h4 class="char"><?=GetMessage("CATALOG_SET_BUY_SET")?></h4>
	<div style="clear: both;"></div>
	<div class="bx_item_set_hor" id="set_container">
		<div class="table_item bx_item_set_hor_item main" data-price="<?=$arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"]?>" data-old-price="<?=$arResult["ELEMENT"]["PRICE_VALUE"]?>" data-discount-diff-price="<?=$arResult["ELEMENT"]["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>">
			<div class="table_item_inner">
				<div class="image">
					<a href="<?=$arResult["ELEMENT"]["DETAIL_PAGE_URL"]?>" class="thumb_cat">
						<?if( !empty($arResult["ELEMENT"]["PREVIEW_PICTURE"]) ):?>
							<?$img = CFile::ResizeImageGet($arResult["ELEMENT"]["PREVIEW_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
							<img border="0" src="<?=$img["src"]?>" alt="<?=$arResult["ELEMENT"]["NAME"];?>" title="<?=$arResult["ELEMENT"]["NAME"];?>" />		
						<?elseif( !empty($arResult["ELEMENT"]["DETAIL_PICTURE"]) ):?>
							<?$img = CFile::ResizeImageGet($arResult["ELEMENT"]["DETAIL_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
							<img border="0" src="<?=$img["src"]?>" alt="<?=$arResult["ELEMENT"]["NAME"];?>" title="<?=$arResult["ELEMENT"]["NAME"];?>" />		
						<?else:?>
							<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage170.gif" alt="<?=$arResult["ELEMENT"]["NAME"]?>" title="<?=$arResult["ELEMENT"]["NAME"]?>" />
						<?endif;?>
					</a>
				</div>			
				<div class="marks">
					<?if( $arResult["ELEMENT"]["PROPERTIES"]["STOCK"]["VALUE"] == true ){?><span class="mark share"></span><?}?>
					<?if( $arResult["ELEMENT"]["PROPERTIES"]["HIT"]["VALUE"] == true ){?><span class="mark hit"></span><?}?>
					<?if( $arResult["ELEMENT"]["PROPERTIES"]["RECOMMEND"]["VALUE"] == true ){?><span class="mark like"></span><?}?>
					<?if( $arResult["ELEMENT"]["PROPERTIES"]["NEW"]["VALUE"] == true ){?><span class="mark new"></span><?}?>
				</div>
				<div class="info">
					<a class="desc_name" href="<?=$arResult["ELEMENT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["ELEMENT"]["NAME"]?></a>
					<div class="price_block">
						<?if (!($arResult["ELEMENT"]["PRICE_VALUE"] == $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])):?>
							<div class="price">										
								<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"]):?>
									<?$symb = substr($arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
									<span class="new bx_item_set_price"><?=str_replace($symb, "", $arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
									<span class="old bx_item_set_price"><?=str_replace($symb, "", $arResult["ELEMENT"]["PRICE_PRINT_VALUE"])."<small>".$symb."/".$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
								<?else:?>
									<span class="new bx_item_set_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></span>
									<span class="old bx_item_set_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></span>
								<?endif;?>
							</div>
						<?else:?>
							<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"]):?>
								<?$symb = substr($arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
								<div class="price"><span class="bx_item_set_price"><?=str_replace($symb, "", $arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"]."</small>";?></span></div>
							<?else:?>
								<div class="price"><span class="bx_item_set_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></span></div>
							<?endif;?>
						<?endif;?>
					</div>
				</div>	
			</div>			
			
		</div>

		<?foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem):?>
			<div class="table_item bx_item_set_hor_item  bx_default_set_items"
				data-price="<?=(($arItem["PRICE_CONVERT_DISCOUNT_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_VALUE"] : $arItem["PRICE_DISCOUNT_VALUE"])?>"
				data-old-price="<?=(($arItem["PRICE_CONVERT_VALUE"]) ? $arItem["PRICE_CONVERT_VALUE"] : $arItem["PRICE_VALUE"])?>"
				data-discount-diff-price="<?=(($arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"] : $arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"])?>">
				<div class="plus"></div>
				<div class="table_item_inner">
					<div class="image">
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb_cat">
							<?if( !empty($arItem["PREVIEW_PICTURE"]) ):?>
								<?$img = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
								<img border="0" src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>" />		
							<?elseif( !empty($arItem["DETAIL_PICTURE"]) ):?>
								<?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
								<img border="0" src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>" />		
							<?else:?>
								<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage170.gif" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
							<?endif;?>
						</a>
					</div>
					<div class="marks">
						<?if( $arItem["PROPERTIES"]["STOCK"]["VALUE"] == true ){?><span class="mark share"></span><?}?>
						<?if( $arItem["PROPERTIES"]["HIT"]["VALUE"] == true ){?><span class="mark hit"></span><?}?>
						<?if( $arItem["PROPERTIES"]["RECOMMEND"]["VALUE"] == true ){?><span class="mark like"></span><?}?>
						<?if( $arItem["PROPERTIES"]["NEW"]["VALUE"] == true ){?><span class="mark new"></span><?}?>
					</div>
					<div class="info">
						<a class="desc_name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						<div class="price_block">
							<?if (!($arItem["PRICE_VALUE"] == $arItem["PRICE_DISCOUNT_VALUE"])):?>
								<div class="price">							
									<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arItem["MEASURE"]["SYMBOL_RUS"]):?>
										<?$symb = substr($arItem["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arItem["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
										<span class="new bx_item_set_price"><?=str_replace($symb, "", $arItem["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
										<span class="old bx_item_set_price"><?=str_replace($symb, "", $arItem["PRICE_PRINT_VALUE"])."<small>".$symb."/".$arItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
									<?else:?>
										<span class="new bx_item_set_price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></span>
										<span class="old bx_item_set_price"><?=$arItem["PRICE_PRINT_VALUE"]?></span>
									<?endif;?>
								</div>
							<?else:?>
								<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arItem["MEASURE"]["SYMBOL_RUS"]):?>
									<?$symb = substr($arItem["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arItem["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
									<div class="price"><span class="bx_item_set_price"><?=str_replace($symb, "", $arItem["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span></div>
								<?else:?>
									<div class="price"><span class="bx_item_set_price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></span></div>
								<?endif;?>
							<?endif;?>							
						</div>
					</div>
					<div class="bx_item_set_del" title="<?=GetMessage("CATALOG_SET_DELETE")?>" onclick="catalogSetDefaultObj_<? echo $intElementID; ?>.DeleteItem(this.parentNode, '<?=$arItem["ID"]?>')"></div>
				</div>
			</div>
		<?endforeach?>

		<div class="result">
			<span class="bx_item_set_result_block">
				<table class="price_block<?if ($arResult["SET_ITEMS"]["OLD_PRICE"] && ($arResult["SET_ITEMS"]["PRICE"] != $arResult["SET_ITEMS"]["OLD_PRICE"])):?> top<?endif;?>" cellspacing="0" cellpadding="0"><tr>
					<td class="total_title"><?=GetMessage("CATALOG_SET_SUM")?>:&nbsp;&nbsp;&nbsp;</td>
					<td class="price">
						<?if ($arResult["SET_ITEMS"]["OLD_PRICE"] && ($arResult["SET_ITEMS"]["PRICE"] != $arResult["SET_ITEMS"]["OLD_PRICE"])):?>
								<span class="new bx_item_set_current_price"><?=$arResult["SET_ITEMS"]["PRICE"]?></span>
								<span class="old bx_item_set_old_price"><?=$arResult["SET_ITEMS"]["OLD_PRICE"]?></span>
						<?else:?>
							<span class="bx_item_set_price"><?=$arResult["SET_ITEMS"]["PRICE"]?></span>
						<?endif;?>
						<?if ($arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]):?>
							<span class="bx_item_set_economy_price"><?=GetMessage("CATALOG_SET_DISCOUNT_DIFF", array("#PRICE#" => $arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]))?></span>
						<?endif?>
					</td>
					<td class="shadow"><div>&nbsp;</div></td>
					<td><a rel="nofollow" onclick="catalogSetDefaultObj_<? echo $intElementID; ?>.Add2Basket();" class="button add_item"><span><?=GetMessage("CATALOG_SET_BUY")?></span></a></td>
					</tr>
				</table>
			</span>
		</div>

		<div style="clear: both;"></div>
	</div>
</div>

<?
$popupParams["AJAX_PATH"] = $this->GetFolder()."/ajax.php";
$popupParams["SITE_ID"] = SITE_ID;
$popupParams["CURRENT_TEMPLATE_PATH"] = $this->GetFolder();
$popupParams["MESS"] = array(
	"CATALOG_SET_POPUP_TITLE" => GetMessage("CATALOG_SET_POPUP_TITLE"),
	"CATALOG_SET_POPUP_DESC" => GetMessage("CATALOG_SET_POPUP_DESC"),
	"CATALOG_SET_BUY" => GetMessage("CATALOG_SET_BUY"),
	"CATALOG_SET_SUM" => GetMessage("CATALOG_SET_SUM"),
	"CATALOG_SET_DISCOUNT" => GetMessage("CATALOG_SET_DISCOUNT"),
	"CATALOG_SET_WITHOUT_DISCOUNT" => GetMessage("CATALOG_SET_WITHOUT_DISCOUNT"),
	"CATALOG_SET_MAIN_PRODUCT_BLOCK_TITLE" => GetMessage("CATALOG_SET_MAIN_PRODUCT_BLOCK_TITLE"),
	"CATALOG_SET_PRODUCTS_BLOCK_TITLE" => GetMessage("CATALOG_SET_PRODUCTS_BLOCK_TITLE"),
	"CATALOG_SET_DISCOUNT_POPUP_DIFF" => GetMessage("CATALOG_SET_DISCOUNT_POPUP_DIFF"),
);
$popupParams["ELEMENT"] = $arResult["ELEMENT"];
$popupParams["SET_ITEMS"] = $arResult["SET_ITEMS"];
$popupParams["DEFAULT_SET_IDS"] = $arResult["DEFAULT_SET_IDS"];
$popupParams["ITEMS_RATIO"] = $arResult["ITEMS_RATIO"];
$popupParams["SHOW_MEASURE"] = $arParams["SHOW_MEASURE"];
?>

<script>
	$('.bx_item_set_hor').ready(function()
	{
		$('.bx_item_set_hor').equalize({children: '.info', reset: true}); 		
	});

	BX.ajaxSiteDir = "<?=SITE_DIR?>";
	
	BX.message({
		setItemAdded2Basket: '<?=GetMessageJS("CATALOG_SET_ADDED2BASKET")?>',
		setButtonBuyName: '<?=GetMessageJS("CATALOG_SET_BUTTON_BUY")?>',
		setButtonBuyUrl: '<?=$arParams["BASKET_URL"]?>',
		setIblockId: '<?=$arParams["IBLOCK_ID"]?>',
		setOffersCartProps: <?=CUtil::PhpToJSObject($arParams["OFFERS_CART_PROPERTIES"])?>
	});

	BX.ready(function(){
		catalogSetDefaultObj_<?=$intElementID; ?> = new catalogSetConstructDefault(
			<?=CUtil::PhpToJSObject($arResult["DEFAULT_SET_IDS"])?>,
			'<? echo $this->GetFolder(); ?>/ajax.php',
			'<?=$arResult["ELEMENT"]["PRICE_CURRENCY"]?>',
			'<?=SITE_ID?>',
			'<?=$intElementID?>',
			'<?=($arResult["ELEMENT"]["DETAIL_PICTURE"]["src"] ? $arResult["ELEMENT"]["DETAIL_PICTURE"]["src"] : $this->GetFolder().'/images/no_foto.png')?>',
			<?=CUtil::PhpToJSObject($arResult["ITEMS_RATIO"])?>
		);
	});

	if (!window.arSetParams)
	{
		window.arSetParams = [{'<?=$intElementID?>' : <?echo CUtil::PhpToJSObject($popupParams)?>}];
	}
	else
	{
		window.arSetParams.push({'<?=$intElementID?>' : <?echo CUtil::PhpToJSObject($popupParams)?>});
	}

	function OpenCatalogSetPopup(element_id)
	{
		if (window.arSetParams)
		{
			for(var obj in window.arSetParams)
			{
				for(var obj2 in window.arSetParams[obj])
				{
					if (obj2 == element_id)
						var curSetParams = window.arSetParams[obj][obj2]
				}
			}
		}
	
		BX.CatalogSetConstructor =
		{
			bInit: false,
			popup: null,
			arParams: {}
		}
		BX.CatalogSetConstructor.popup = BX.PopupWindowManager.create("CatalogSetConstructor_"+element_id, null, {
			autoHide: false,
			offsetLeft: 0,
			offsetTop: 0,
			overlay : true,
			draggable: {restrict:true},
			closeByEsc: false,
			closeIcon: { right : "12px", top : "10px"},
			titleBar: {content: BX.create("span", {html: "<div><?=GetMessage("CATALOG_SET_POPUP_TITLE_BAR")?></div>"})},
			content: '<div style="width:250px;height:250px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="<?=$this->GetFolder()?>/images/wait.gif"/></span></div>',
			events: {
				onAfterPopupShow: function()
				{
					BX.ajax.post(
						'<? echo $this->GetFolder(); ?>/popup.php',
						{
							lang: BX.message('LANGUAGE_ID'),
							site_id: BX.message('SITE_ID') || '',
							arParams:curSetParams
						},
						BX.delegate(function(result)
						{
							this.setContent(result);
							BX("CatalogSetConstructor_"+element_id).style.left = (window.innerWidth - BX("CatalogSetConstructor_"+element_id).offsetWidth)/2 +"px";
							var popupTop = document.body.scrollTop + (window.innerHeight - BX("CatalogSetConstructor_"+element_id).offsetHeight)/2;
							BX("CatalogSetConstructor_"+element_id).style.top = popupTop > 0 ? popupTop+"px" : 0;
						},
						this)
					);
				}
			}
		});

		BX.CatalogSetConstructor.popup.show();
	}
</script>