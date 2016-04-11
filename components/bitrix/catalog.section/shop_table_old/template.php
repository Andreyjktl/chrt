<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if( count($arResult["ITEMS"]) <= 0 ){?>
	<div class="empty_items">
		<?$APPLICATION->IncludeFile(SITE_DIR."/include/shop_zero_items.php", Array(), Array(
			"MODE"      => "html",
			"NAME"      => GetMessage('CT_NAME_NOT_FOUND'),
			));
		?>
	</div>
<?}else{?>
	<table class="display_rows" width="100%" border="0" cellspacing="0" cellpadding="0">
		<?foreach( $arResult["ITEMS"] as $arItem ){
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?			
				if (($arParams["SHOW_MEASURE"]=="Y")&&($arItem["CATALOG_MEASURE"]))
				{ $arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arItem["CATALOG_MEASURE"]), false, false, array())->GetNext(); }
			?>
				<td class="image">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb">
						<?if( !empty($arItem["PREVIEW_PICTURE"]) ){?>
							<?$img_preview = CFile::ResizeImageGet( $arItem["PREVIEW_PICTURE"], array( "width" => 40, "height" => 40 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
							<img border="0" src="<?=$img_preview["src"]?>" alt="<?=($arItem["PREVIEW_PICTURE"]["ALT"] ? $arItem["PREVIEW_PICTURE"]["ALT"] : $arItem["NAME"])?>" title="<?=($arItem["PREVIEW_PICTURE"]["TITLE"] ? $arItem["PREVIEW_PICTURE"]["TITLE"] : $arItem["NAME"])?>" />
						<?}else{?>
							<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage40.gif" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
						<?}?>
					</a>
				</td>
				<td class="desc_name">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
					<?if ($arItem["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><div class="article"><?=GetMessage("ARTICLE");?>: <?=$arItem["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></div><?endif;?>
				</td>
				<td class="price_block">
					<?if(( count( $arItem["OFFERS"] ) > 0 ) && $arItem["MIN_PRODUCT_OFFER_PRICE_PRINT"]){?>
						<span class="price">
							<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arMeasure["SYMBOL_RUS"]):?>
								<?$symb = substr($arItem["MIN_PRODUCT_OFFER_PRICE_PRINT"], strrpos($arItem["MIN_PRODUCT_OFFER_PRICE_PRINT"], ' '));?>
								<span><?=GetMessage("CATALOG_FROM");?> <?=str_replace($symb, "", $arItem["MIN_PRODUCT_OFFER_PRICE_PRINT"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
							<?else:?><span><?=GetMessage("CATALOG_FROM");?> <?=$arItem["MIN_PRODUCT_OFFER_PRICE_PRINT"]?></span><?endif;?>
						</span>
					<?}else{?>
						<?
							$arCountPricesCanAccess = 0;
							foreach( $arItem["PRICES"] as $key => $arPrice ) { if($arPrice["CAN_ACCESS"]){$arCountPricesCanAccess++;} }
						?>
						<?foreach( $arItem["PRICES"] as $key => $arPrice ){?>
							<?if($arPrice["CAN_ACCESS"]){?>
								<?$price = CPrice::GetByID($arPrice["ID"]); ?>
								<?if($arCountPricesCanAccess>1):?><div class="price_name"><?=$price["CATALOG_GROUP_NAME"];?></div><?endif;?>									
								<span class="price">
									<?if( $arPrice["VALUE"] > $arPrice["DISCOUNT_VALUE"] ){?>
										<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arMeasure["SYMBOL_RUS"]):?>
											<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
											<span class="new"><?=str_replace($symb, "", $arPrice["PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span><br />
											<span class="old"><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
										<?else:?>
											<span class="new"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span><br />
											<span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
										<?endif;?>
									<?}else{?>
										<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arMeasure["SYMBOL_RUS"]):?>
											<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
											<span><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
										<?else:?><span><?=$arPrice["PRINT_VALUE"]?></span><?endif;?>
									<?}?>
								</span>
							<?}?>
						<?}?>
					<?}?>
				</td>			

				
				
				<?if ($arParams["USE_PRODUCT_QUANTITY"]=="Y"):?>
					<?if ($arItem["CAN_BUY"]&&(!( is_array($arItem["OFFERS"]) && !empty($arItem["OFFERS"])))):?>
						<td class="quantity">
								<div class="counter_block" element_id="#<?=$arItem["ID"];?>">
									<input type="text" class="text" name="count_items" value="1" />
									<span class="plus">+</span>
									<span class="minus">-</span>
								</div>
						</td>
					<?endif;?>
				<?endif;?>
				<td class="buttons<?if (count($arItem["OFFERS"])):?> small<?endif;?>"<?if (!($arParams["USE_PRODUCT_QUANTITY"]=="Y"&&($arItem["CAN_BUY"]&&(!( is_array($arItem["OFFERS"]) && !empty($arItem["OFFERS"])))))):?> colspan="2"<?endif;?>>	
					<!--noindex-->
						<?if( $arItem["CAN_BUY"] || count($arItem["OFFERS"])){?>
							<div class="button_block">
								<?if (!count($arItem["OFFERS"]) && $arItem["CAN_BUY"]):?>
									<a rel="nofollow" element_id="#<?=$arItem["ID"]?>" href="<?=$arItem["ADD_URL"]?>" onclick="return addToCart(this, 'detail', '<?=GetMessage("CATALOG_IN_CART")?>', 'cart', '<?=$arParams["BASKET_URL"]?>', '<?=$arItem["ID"]?>');" class="button add_item" alt="<?=$arItem["NAME"]?>"><span><?=GetMessage('CATALOG_ADD_TO_BASKET')?></span></a>	
								<?else:?>
									<a rel="nofollow" href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="button add_item" alt="<?=$arItem["NAME"]?>"><span><?=GetMessage('CATALOG_MORE')?></span></a>
								<?endif;?>
							</div>
						<?}?>
						<div class="likes_icons">
							<?if(  $arItem["CAN_BUY"] ){?>
								<?if (empty($arItem["OFFERS"])):?>
									<a rel="nofollow" href="#<?=$arItem["ID"]?>" class="wish_item"></a>
									<span class="tooltip-wrapp"><div class="tooltip wish_item_tooltip"><?=GetMessage('CATALOG_IZB')?></div></span>
								<?endif;?>
							<?}?>
							<?if($arParams["DISPLAY_COMPARE"]){?>								
								<a rel="nofollow" element_id="#<?=$arItem["ID"]?>" href="<?=$arItem["COMPARE_URL"]?>" onclick="return addToCompare(this, 'detail', '/catalog/<?=str_replace( "#ACTION_CODE#", "DELETE_FROM_COMPARE_RESULT&ID=".$arItem["ID"], $arParams["SEF_URL_TEMPLATES"]['compare'])?>');" class="compare_item"></a>
								<span class="tooltip-wrapp"><div class="tooltip compare_item_tooltip"><?=GetMessage('CATALOG_COMPARE')?></div></span>
							<?}?>
						</div>
					<!--/noindex-->
				</td>
			</tr>
		<?}?>
	</table>
	<div class="shadow-item_info"><img border="0" alt="" src="/bitrix/templates/ishop/images/shadow-item_info.png"></div>
	<?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?>
		<?=$arResult["NAV_STRING"]?>
	<?}?>
	
	<?
		$show=$arParams["PAGE_ELEMENT_COUNT"];
		if (array_key_exists("show", $_REQUEST))
		{
			if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(20, 40, 60, 80, 100)) ) {$show=intVal($_REQUEST["show"]); $_SESSION["show"] = $show;}
			elseif ($_SESSION["show"]) {$show=intVal($_SESSION["show"]);}
		}
	?>
	
	<div class="drop_number">
		<?=GetMessage("CATALOG_DROP_TO")?>
		<a rel="nofollow" class="number" href="#"><span><?=$show?></span></a>
		<div class="number_list">
			<a rel="nofollow" class="number" href="#"><span><?=$show?></span></a>
			<?for( $i = 20; $i <= 100; $i+=20 ){
				if( $i == $show ) continue;?>
				<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('show='.$i, array('show', 'mode'))?>"><?=$i?></a>
			<?}?>
		</div>
	</div>
	<div style="clear:both"></div>
<?}?>


<div class="group_description"><?=$arResult["~DESCRIPTION"]?></div>
