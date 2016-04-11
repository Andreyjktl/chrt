<?
	define("NOT_CHECK_PERMISSIONS", true);
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$APPLICATION->ShowAjaxHead();
	$APPLICATION->AddHeadScript("/bitrix/js/main/dd.js");
	if (!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog")) return;
	if (SITE_CHARSET != "utf-8") $_REQUEST["arParams"] = $APPLICATION->ConvertCharsetArray($_REQUEST["arParams"], "utf-8", SITE_CHARSET);
	if (!is_array($_REQUEST["arParams"]["ELEMENT"])) return;

	$curElementId = intval($_REQUEST["arParams"]["ELEMENT"]["ID"]);
	$arCurElementInfo = $_REQUEST["arParams"]["ELEMENT"];
	$arSetItemsInfo = $_REQUEST["arParams"]["SET_ITEMS"];
	$arMessage = $_REQUEST["arParams"]["MESS"];
	$curTemplatePath = $_REQUEST["arParams"]["CURRENT_TEMPLATE_PATH"];

	$arSetElementsDefault = $_REQUEST["arParams"]["SET_ITEMS"]["DEFAULT"];
	$arSetElementsOther = $_REQUEST["arParams"]["SET_ITEMS"]["OTHER"];

	$setPrice = $_REQUEST["arParams"]["SET_ITEMS"]["PRICE"];
	$setOldPrice = $_REQUEST["arParams"]["SET_ITEMS"]["OLD_PRICE"];
	$setPriceDiscountDifference = $_REQUEST["arParams"]["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"];
?>

<div class="bx_modal_container bx_kit set_wrapp">
	<div class="bx_modal_body" id="bx_catalog_set_construct_popup_<?=$curElementId?>">
		<div class="bx_kit_one_section">
			<div class="item_block_title"><?=$arMessage["CATALOG_SET_MAIN_PRODUCT_BLOCK_TITLE"]?></div>
			<div class="bx_kit_item table_item main">
				<div class="table_item_inner">
					<div class="bx_kit_item_children">						
						<div class="image">
							<a href="<?=$arCurElementInfo["DETAIL_PAGE_URL"]?>" class="thumb_cat" target="_blank">
								<?if( !empty($arCurElementInfo["PREVIEW_PICTURE"]) ):?>
									<?$img = CFile::ResizeImageGet($arCurElementInfo["PREVIEW_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
									<img border="0" src="<?=$img["src"]?>" alt="<?=$arCurElementInfo["NAME"];?>" title="<?=$arCurElementInfo["NAME"];?>" />		
								<?elseif( !empty($arCurElementInfo["DETAIL_PICTURE"]) ):?>
									<?$img = CFile::ResizeImageGet($arCurElementInfo["DETAIL_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
									<img border="0" src="<?=$img["src"]?>" alt="<?=$arCurElementInfo["NAME"];?>" title="<?=$arCurElementInfo["NAME"];?>" />		
								<?else:?>
									<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage170.gif" alt="<?=$arCurElementInfo["NAME"]?>" title="<?=$arCurElementInfo["NAME"]?>" />
								<?endif;?>
							</a>
						</div>
						<div class="marks">
							<?if( $arCurElementInfo["PROPERTIES"]["STOCK"]["VALUE"] == true ){?><span class="mark share"></span><?}?>
							<?if( $arCurElementInfo["PROPERTIES"]["HIT"]["VALUE"] == true ){?><span class="mark hit"></span><?}?>
							<?if( $arCurElementInfo["PROPERTIES"]["RECOMMEND"]["VALUE"] == true ){?><span class="mark like"></span><?}?>
							<?if( $arCurElementInfo["PROPERTIES"]["NEW"]["VALUE"] == true ){?><span class="mark new"></span><?}?>
						</div>
						<div class="info">
							<a class="desc_name" target="_blank" href="<?=$arCurElementInfo["DETAIL_PAGE_URL"]?>"><?=$arCurElementInfo["NAME"]?></a>
							<div class="price_block">
								<?if (!($arCurElementInfo["PRICE_VALUE"] == $arCurElementInfo["PRICE_DISCOUNT_VALUE"])):?>
									<div class="price">							
										<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arCurElementInfo["MEASURE"]["SYMBOL_RUS"]):?>
											<?$symb = substr($arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
											<span class="new bx_item_set_price"><?=str_replace($symb, "", $arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arCurElementInfo["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
											<span class="old bx_item_set_price bx_kit_item_price"><?=str_replace($symb, "", $arCurElementInfo["PRICE_PRINT_VALUE"])."<small>".$symb."/".$arCurElementInfo["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
										<?else:?>
											<span class="new bx_item_set_price"><?=$arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"]?></span>
											<span class="old bx_item_set_price bx_kit_item_price"><?=$arCurElementInfo["PRICE_PRINT_VALUE"]?></span>
										<?endif;?>
									</div>
								<?else:?>
									<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arCurElementInfo["MEASURE"]["SYMBOL_RUS"]):?>
										<?$symb = substr($arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
										<div class="price"><span class="bx_item_set_price"><?=str_replace($symb, "", $arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arCurElementInfo["MEASURE"]["SYMBOL_RUS"]."</small>";?></span></div>
									<?else:?>
										<div class="price"><span class="bx_item_set_price bx_kit_item_price"><?=$arCurElementInfo["PRICE_PRINT_DISCOUNT_VALUE"]?></span></div>
									<?endif;?>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?$curCountDefaultSetItems = 0;?>
			<?foreach($arSetElementsDefault as $key => $arItem):?>
				
				<div class="bx_kit_item table_item <?if ($arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]):?> discount<?endif?>">
					<div class="plus"></div>
					<div class="table_item_inner bx_drag_dest">
						<?if($key==0):?><div class="item_block_title"><?=$arMessage["CATALOG_SET_PRODUCTS_BLOCK_TITLE"]?></div><?endif;?>
						<div class="bx_kit_item_children">
							<div class="image bx_kit_img_container">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb_cat" target="_blank">
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
								<a class="desc_name bx_kit_item_title" data-item-id="<?=$arItem["ID"]?>" target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
								<div class="price_block bx_kit_item_price"
									data-discount-price="<?=($arItem["PRICE_CONVERT_DISCOUNT_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_VALUE"] : $arItem["PRICE_DISCOUNT_VALUE"]?>"
									data-price="<?=($arItem["PRICE_CONVERT_VALUE"]) ? $arItem["PRICE_CONVERT_VALUE"] : $arItem["PRICE_VALUE"]?>"
									data-discount-diff-price="<?=($arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"] : $arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>">

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
							<div class="bx_kit_item_del" onclick="catalogSetPopupObj.catalogSetDelete(this.parentNode);"></div>
						</div>
						<div style="clear:both"></div>
					</div >
				</div>
				<?$curCountDefaultSetItems++;?>
			<?endforeach?>

			<?if ($curCountDefaultSetItems<3): for($j=1; $j<=(3-$curCountDefaultSetItems); $j++){ ?>
				<div class="bx_kit_item table_item bx_kit_item_empty bx_drag_dest"></div>
			<?} endif;?>

			<div class="bx_kit_item table_item">
				<div class="bx_kit_item_equally"></div>
				<div class="bx_kit_result <?if (!$setOldPrice && !$setPriceDiscountDifference):?>not_sale<?endif?>" id="bx_catalog_set_construct_price_block_<?=$curElementId?>">
					<div class="price">
						<div class="total_title"><?=$arMessage["CATALOG_SET_SUM"]?>:</div>
						<?if ($setOldPrice && ($setOldPrice != $setPrice)):?>
							<span class="new bx_item_set_current_price" id="bx_catalog_set_construct_sum_price_<?=$curElementId?>"><?=$setPrice?></span>
							<span class="old bx_item_set_old_price" id="bx_catalog_set_construct_sum_old_price_<?=$curElementId?>"><?=$setOldPrice?></span>
						<?else:?>
							<span class="bx_item_set_price" id="bx_catalog_set_construct_sum_price_<?=$curElementId?>"><?=$setPrice?></span>
						<?endif;?>
						<?if ($setPriceDiscountDifference):?>
							<span class="bx_item_set_economy_price">
								<?=$arMessage["CATALOG_SET_DISCOUNT_POPUP_DIFF"];?> 
								<span id="bx_catalog_set_construct_sum_diff_price_<?=$curElementId?>"><?=$setPriceDiscountDifference?></span>
							</span>
						<?endif?>
					</div>
					<a class="button add_item" onclick="catalogSetPopupObj.Add2Basket();"><span><?=$arMessage["CATALOG_SET_BUY"]?></span></a>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>

		
		
		<div class="bx_kit_two_section">
			<div class="title"><?=$arMessage["CATALOG_SET_POPUP_TITLE"]?></div>
			<div class="bx_modal_description"><?=$arMessage["CATALOG_SET_POPUP_DESC"]?></div>
			<div class="bx_kit_two_section_ova">
				<div class="bx_kit_two_item_slider" id="bx_catalog_set_construct_slider_<?=$curElementId?>" data-style-left="0" style="left:0%;width:<?=(count($arSetElementsOther) <=5) ? 100 : 100 + 20*(count($arSetElementsOther)-5)?>%">
				<?if (is_array($arSetElementsOther)):?>
					<?foreach($arSetElementsOther as $arItem):?>
					<div class="bx_kit_item_slider bx_drag_obj" style="width:<?=(count($arSetElementsOther) <=5) ? "20" : (100/count($arSetElementsOther))?>%" data-main-element-id="<?=$curElementId?>">
						<div class="bx_kit_item table_item <?if ($arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]):?> discount<?endif?>">
							<div class="table_item_inner">
								<div class="image bx_kit_img_container">
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb_cat" target="_blank">
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
								
								<div class="info">
									<a class="desc_name bx_kit_item_title" data-item-id="<?=$arItem["ID"]?>" target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
									<div class="price_block bx_kit_item_price"
										data-discount-price="<?=($arItem["PRICE_CONVERT_DISCOUNT_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_VALUE"] : $arItem["PRICE_DISCOUNT_VALUE"]?>"
										data-price="<?=($arItem["PRICE_CONVERT_VALUE"]) ? $arItem["PRICE_CONVERT_VALUE"] : $arItem["PRICE_VALUE"]?>"
										data-discount-diff-price="<?=($arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"]) ? $arItem["PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE"] : $arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>">								
										<?if (!($arItem["PRICE_VALUE"] == $arItem["PRICE_DISCOUNT_VALUE"])):?>
											<div class="price">							
												<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arItem["MEASURE"]["SYMBOL_RUS"]):?>
													<?$symb = substr($arItem["PRICE_PRINT_DISCOUNT_VALUE"], strrpos($arItem["PRICE_PRINT_DISCOUNT_VALUE"], ' '));?>
													<span class="new bx_item_set_price"><?=str_replace($symb, "", $arItem["PRICE_PRINT_VALUE"])."<small>".$symb."/".$arItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
													<span class="old bx_item_set_price"><?=str_replace($symb, "", $arItem["PRICE_PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
												<?else:?>
													<span class="new bx_item_set_price"><?=$arItem["PRICE_PRINT_VALUE"]?></span>
													<span class="old bx_item_set_price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></span>
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
								<div class="bx_kit_item_add" onclick="catalogSetPopupObj.catalogSetAdd(this.parentNode);"></div>
								<div style="clear:both"></div>
							</div>
						</div>
					</div>
					<?endforeach;?>
				<?endif?>
				</div>
			</div>
			<div class="bx_kit_item_slider_arrow_left" id="bx_catalog_set_construct_slider_left_<?=$curElementId?>" <?if (count($arSetElementsOther) < 5):?>style="display:none"<?endif?> onclick="catalogSetPopupObj.scrollItems('left')"></div>
			<div class="bx_kit_item_slider_arrow_right" id="bx_catalog_set_construct_slider_right_<?=$curElementId?>" <?if (count($arSetElementsOther) < 5):?>style="display:none"<?endif?> onclick="catalogSetPopupObj.scrollItems('right')"></div>
		</div>
	</div>
</div>

<?CJSCore::Init(array("popup"));?>
<script>
	var catalogSetPopupObj = new catalogSetConstructPopup(<?=count($arSetElementsOther)?>,
		<?=(count($arSetElementsOther) > 5) ? (100/count($arSetElementsOther)) : 20?>,
		"<?=CUtil::JSEscape($arCurElementInfo["PRICE_CURRENCY"])?>",
		"<?=CUtil::JSEscape($arCurElementInfo["PRICE_VALUE"])?>",
		"<?=CUtil::JSEscape($arCurElementInfo["PRICE_DISCOUNT_VALUE"])?>",
		"<?=CUtil::JSEscape($arCurElementInfo["PRICE_DISCOUNT_DIFFERENCE_VALUE"])?>",
		"<?=$_REQUEST["arParams"]["AJAX_PATH"]?>",
		<?=CUtil::PhpToJSObject($_REQUEST["arParams"]["DEFAULT_SET_IDS"])?>,
		"<?=$_REQUEST["arParams"]["SITE_ID"]?>",
		"<?=$curElementId?>",
		<?=CUtil::PhpToJSObject($_REQUEST["arParams"]["ITEMS_RATIO"])?>,
		"<?=$arCurElementInfo["DETAIL_PICTURE"]["src"] ? $arCurElementInfo["DETAIL_PICTURE"]["src"] : $curTemplatePath."/images/no_foto.png"?>"
	);
	
	$('.bx_kit_one_section').ready(function()
	{
		$('.bx_kit_one_section').equalize({children: '.info', reset: true}); 			
		$('.bx_kit_one_section').equalize({equalize: 'outerHeight', children: '.table_item_inner', reset: false}); 		
	});
	$('.bx_kit_two_section').ready(function()
	{
		$('.bx_kit_two_section').equalize({children: '.info', reset: true}); 		
	});

	BX.ready(function(){
		jsDD.Enable();

		var destObj = BX.findChildren(BX("bx_catalog_set_construct_popup_<?=$curElementId?>"), {className:"bx_drag_dest"}, true);
		for (var i=0; i<destObj.length; i++)
		{
			jsDD.registerDest(destObj[i]);
			destObj[i].onbxdestdragfinish =  catalogSetConstructDestFinish;  //node was thrown inside of dest
		}
		var dragObj = BX.findChildren(BX("bx_catalog_set_construct_popup_<?=$curElementId?>"), {className:"bx_drag_obj"}, true);
		for (var i=0; i<dragObj.length; i++)
		{
			dragObj[i].onbxdragstart = catalogSetConstructDragStart;
			dragObj[i].onbxdrag = catalogSetConstructDragMove;
			dragObj[i].onbxdraghover = catalogSetConstructDragHover;
			dragObj[i].onbxdraghout = catalogSetConstructDragOut;
			dragObj[i].onbxdragrelease = catalogSetConstructDragRelease;   //node was thrown outside of dest
			jsDD.registerObject(dragObj[i]);
		}
	});
	
	$(".popup-window-overlay").on("click", function()
	{
		BX.CatalogSetConstructor.popup.close();
	});
</script>