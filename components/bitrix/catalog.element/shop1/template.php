<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	if (($arParams["SHOW_MEASURE"]=="Y")&&($arResult["CATALOG_MEASURE"]))
	{ $arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arResult["CATALOG_MEASURE"]), false, false, array())->GetNext(); }	
?>
<?$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);?>

<?$totalCount = CIshop::GetTotalCount($arResult);
$arAddToBasketData=CIshop::GetAddToBasketArray($arResult, $totalCount);
?>


<div class="shadow-item_info"><img border="0" alt="" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info.png"></div>


<div class="item_info">
	<div class="item_slider">
		<ul class="slides">
			<?$images = array();
			if( is_array( $arResult["DETAIL_PICTURE"] ) ){
				$images[] = $arResult["DETAIL_PICTURE"];
			}
			foreach( $arResult["MORE_PHOTO"] as $arPhoto ){
				$images[] = $arPhoto;
			}?>
			<?foreach( $images as $key => $arPhoto ){?>
				<li id="photo-<?=$key?>" <?=$key == 0 ? 'class="current"' : ''?>>
					<?$img = CFile::ResizeImageGet( $arPhoto, array( "width" => 800, "height" => 600 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, array() );?>
					<a href="<?=$img["src"]?>" alt="<?=($arPhoto["ALT"] ? $arPhoto["ALT"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"] ? $arPhoto["TITLE"] : $arResult["NAME"])?>" rel="item_slider" class="fancy">
						<span class="lupa" style="display: none;" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>"></span>
						<div class="marks">
							<?if( $arResult["PROPERTIES"]["STOCK"]["VALUE"] ){?>
								<span class="mark share"></span>
							<?}?>
							<?if( $arResult["PROPERTIES"]["HIT"]["VALUE"] ){?>
								<span class="mark hit"></span>
							<?}?>
							<?if( $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
								<span class="mark like"></span>
							<?}?>
							<?if( $arResult["PROPERTIES"]["NEW"]["VALUE"] ){?>
								<span class="mark new"></span>
							<?}?>
						</div>
						<?$img = CFile::ResizeImageGet( $arPhoto, array( "width" => 280, "height" => 280 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, array() );?>
						<img border="0" src="<?=$img["src"]?>" alt="<?=($arPhoto["ALT"] ? $arPhoto["ALT"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"] ? $arPhoto["TITLE"] : $arResult["NAME"])?>" />
					</a>
				</li>
			<?}?>
			<?if( count($images) == 0 ){?>
				<li class="current">
					<div class="marks">
						<?if( $arResult["PROPERTIES"]["STOCK"]["VALUE"] ){?>
							<span class="mark share"></span>
						<?}?>
						<?if( $arResult["PROPERTIES"]["HIT"]["VALUE"] ){?>
							<span class="mark hit"></span>
						<?}?>
						<?if( $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
							<span class="mark like"></span>
						<?}?>
						<?if( $arResult["PROPERTIES"]["NEW"]["VALUE"] ){?>
							<span class="mark new"></span>
						<?}?>
					</div>
					<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimagebig.gif" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				</li>
			<?}?>
		</ul>
		<?if( count($images) > 1 ){?>
			<div class="thumbs">
				<ul id="thumbs">
					<?foreach( $images as $key => $arPhoto ){?>
						<?$img = CFile::ResizeImageGet( $arPhoto, array( "width" => 80, "height" => 80 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, array() );?>
						<li <?=$key == 0 ? 'class="current"' : ''?>>
							<a href="#photo-<?=$key?>">
								<img border="0" src="<?=$img["src"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
							</a>
						</li>
					<?}?>
				</ul>
			</div>
		<?}?>
	</div>
	<div class="right_info">
		
		<div class="info_block">
		
			<?if( !empty($arResult["PROPERTIES"]["BRAND"]["VALUE"]) ){?>
				<?$rsBrand = CIBlockElement::GetList( array(), array("IBLOCK_ID" => $arResult["PROPERTIES"]["BRAND"]["LINK_IBLOCK_ID"], "ID" => $arResult["PROPERTIES"]["BRAND"]["VALUE"] ));
					$rsBrand->SetUrlTemplates($arParams["SEF_MODE_BRAND_SECTIONS"].$arParams["SEF_MODE_BRAND_ELEMENT"]);
					$arBrand = $rsBrand->GetNext();?>
				<div class="brand<?if (!(($arParams["SHOW_BRAND_PICTURE"]!="Y")||(!($arBrand["PREVIEW_PICTURE"]||$arBrand["DETAIL_PICTURE"])))):?> img<?endif;?>">
					<?if (($arParams["SHOW_BRAND_PICTURE"]!="Y")||(!($arBrand["PREVIEW_PICTURE"]||$arBrand["DETAIL_PICTURE"]))):?>
						<b><?=GetMessage("BRAND");?>:</b> <a href="<?=$arBrand["DETAIL_PAGE_URL"]?>"><?=$arBrand["NAME"]?></a>
					<?else:?>
						<?	
							$img = array();
							if($arBrand["PREVIEW_PICTURE"]) { $img = CFile::ResizeImageGet( $arBrand["PREVIEW_PICTURE"], array( "width" => 120, "height" => 40 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true );}
							elseif($arBrand["DETAIL_PICTURE"]) { $img = CFile::ResizeImageGet( $arBrand["DETAIL_PICTURE"], array( "width" => 120, "height" => 40 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true );}
						?>
						<a class="img" href="<?=$arBrand["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$img["src"]?>" alt="<?=$arBrand["NAME"]?>" title="<?=$arBrand["NAME"]?>" style="margin-top: -10px;" /></a>
					<?endif;?>
				</div>
			<?}?>
			
			<div class="compare" id="compare"></div>
			
		
			<div class="likes_icons">
				<!--noindex-->
					<?if (empty($arResult["OFFERS"])&&$arResult["CAN_BUY"]):?>
						<a rel="nofollow" href="#<?=$arResult["ID"]?>" class="wish_item"></a>
						<div class="tooltip wish_item_tooltip">
							<?=GetMessage('CT_BCE_CATALOG_IZB')?>
						</div>
					<?endif;?>
					<?if( $arParams["USE_COMPARE"] == "Y" ){?>
						<a rel="nofollow" element_id="#<?=$arResult["ID"]?>" href="<?=$arResult["COMPARE_URL"]?>" onclick="return addToCompare(this, 'detail', '/catalog/<?=str_replace( "#ACTION_CODE#", "DELETE_FROM_COMPARE_RESULT&ID=".$arResult["ID"], $arParams["SEF_URL_TEMPLATES"]['compare'])?>');" class="compare_item"></a>
						<div class="tooltip compare_item_tooltip">
							<?=GetMessage('CT_BCE_CATALOG_COMPARE')?>
						</div>
					<?}?>
				<!--/noindex-->
			</div>
			
			<div style="clear: right;"></div>
		</div>
		<div class="information item_ws">
		
		
			<?if ($arResult["CAN_BUY"] || (!empty( $arResult["OFFERS"])) || !empty( $arResult["PRICES"])){?>
				<div class="middle_info">
					<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td>
					
						<?if( !empty( $arResult["OFFERS"] ) ){?>
							<div class="price_block bottom10">
								<div class="price">
									<?if($arResult["MIN_PRICE_OFFER"]["DISCOUNT_VALUE"]!=$arResult["MIN_PRICE_OFFER"]["VALUE"]){?>
										<span class="new"><?=GetMessage("CATALOG_FROM");?> <?=$arResult["MIN_PRICE_OFFER"]["PRINT_DISCOUNT_VALUE"]?></span>
										<span class="old">
											<?=GetMessage("CATALOG_FROM");?> <?=$arResult["MIN_PRICE_OFFER"]["PRINT_VALUE"];?>
										</span>
									<?}else{?>
										<span><?=GetMessage("CATALOG_FROM");?> <?=$arResult["MIN_PRICE_OFFER"]["PRINT_VALUE"]?></span>
									<?}?>
									<?/*<span><?=GetMessage("CATALOG_FROM");?> <?=$arResult["MIN_PRODUCT_OFFER_PRICE_PRINT"]?></span>*/?>
								</div>
							</div>
						<?}elseif( !empty( $arResult["PRICES"] )){?>
							<?
								$arCountPricesCanAccess = 0;
								foreach( $arResult["PRICES"] as $key => $arPrice ) { if($arPrice["CAN_ACCESS"]){$arCountPricesCanAccess++;} }
							?>
							<div class="price_block<?if(!$arResult["CAN_BUY"]):?> bottom10<?endif;?>">
								<?foreach( $arResult["PRICES"] as $key => $arPrice ){?>
									<?if( $arPrice["CAN_ACCESS"] ){?>
										<?$price = CPrice::GetByID($arPrice["ID"]); ?>
										<?if($arCountPricesCanAccess>1):?><div class="price_name"><?=$price["CATALOG_GROUP_NAME"];?></div><?endif;?>
										<div class="price">
											<?if( $arPrice["VALUE"] > $arPrice["DISCOUNT_VALUE"] ){?>
												<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arMeasure["SYMBOL_RUS"]):?>
													<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
													<span class="new"><?=str_replace($symb, "", $arPrice["PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
													<span class="old"><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
												<?else:?>
													<span class="new"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
													<span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
												<?endif;?>
											<?}else{?>
												<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arMeasure["SYMBOL_RUS"]):?>
													<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
													<span><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arMeasure["SYMBOL_RUS"]."</small>";?></span>
												<?else:?><span><?=$arPrice["PRINT_VALUE"]?></span><?endif;?>
											<?}?>
										</div>
									<?}?>
								<?}?>
							</div>
						<?}?>

						<nobr>
							<?if (($arParams["USE_PRODUCT_QUANTITY"]=="Y")&&$arResult["CAN_BUY"]&&(!( is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])))):?>
								<div class="counter_block" element_id="#<?=$arResult["ID"];?>">
									<input type="text" class="text" name="count_items" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
									<span class="plus" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
									<span class="minus">-</span>
								</div>
							<?endif;?>
							<!--noindex-->
							<?if( $arResult["CAN_BUY"] && empty($arResult["OFFERS"])){?>
								<a rel="nofollow" element_id="#<?=$arResult["ID"];?>" data-quantity="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" data-float_ratio="<?=$arAddToBasketData["FLOAT_RATIO"]?>" data-ratio="<?=$arAddToBasketData["RATIO_ITEM"]?>" href="<?=$arResult["ADD_URL"]?>" onclick="return addToCart(this, 'detail', '<?=GetMessage("CATALOG_IN_CART")?>', 'cart', '<?=$arParams["BASKET_URL"]?>', '<?=$arResult["ID"]?>');" class="button add_item" alt="<?=$arResult["NAME"]?>">
									<span><?=GetMessage('CATALOG_ADD_TO_BASKET')?></span>
								</a>
								</td>
								<?if ($arParams["USE_ONE_CLICK_BUY"]!="N"):?>
									<td class="shadow"><i class="shadow_right"></i></td>
									<td class="one-click">									
									<a id="one_click_buy_open" class="one_click_buy button" data-quantity="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" onclick="return oneClickBuy('<?=$arResult["ID"];?>', '<?=$arResult["IBLOCK_ID"]?>');">
										<span><?=GetMessage('ONE_CLICK_BUY')?></span>
									</a>
								<?endif;?>
							<?}?>
							<!--/noindex-->	
						</nobr>

					</td></tr></table>
					<div style="clear: right;"></div>
				</div>
			<?}?>
		
			
		
			<div class="top_info<?if( !empty( $arResult["OFFERS"]) && !$arResult["MIN_PRODUCT_OFFER_PRICE_PRINT"] ):?> cut<?endif;?>">
				<?if( is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
					<?if ($arParams["SHOW_QUANTITY"]!="N"){?>
						<?if( !$arResult["OFFERS_CATALOG_QUANTITY"] ){?>
							<div class="noavailable_block">
								<?if ($arResult["DISPLAY_PROPERTIES"]["NOTAVAIBLE"]):?><?=$arResult["DISPLAY_PROPERTIES"]["NOTAVAIBLE"]["VALUE"]?>
								<?else:?><?=GetMessage('CATALOG_NOT_AVAILABLE')?><?endif;?>
							</div>
						<?}else{?>
							<div class="available_block"><?=GetMessage('CT_IS_AVAILABLE')?> <?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"):?>( <?=$arResult["OFFERS_CATALOG_QUANTITY"];?> )<?endif;?></div>
						<?}?>
					<?}?>
					<?if ($arResult["MIN_PRODUCT_OFFER_PRICE_PRINT"] && ($arParams["SHOW_FOUND_CHEAPER"]!="N")):?>
					<!--noindex-->
						<div class="center_info">
							<a rel="nofollow" href="#" class="found_cheaper" item-name="<?=$arResult["NAME"]?>"><span><?=GetMessage('CT_BCE_CATALOG_FIND_CHEAPER')?></span></a>
						</div>
					<!--/noindex-->
					<?endif;?>
				<?else:?>
					<?if ($arParams["SHOW_QUANTITY"]!="N"){?>
						<?if( $arResult["CATALOG_QUANTITY"]<=0 ){?>
							<div class="noavailable_block">
								<?if ($arResult["DISPLAY_PROPERTIES"]["NOTAVAIBLE"]):?><?=$arResult["DISPLAY_PROPERTIES"]["NOTAVAIBLE"]["VALUE"]?>
								<?else:?><?=GetMessage('CATALOG_NOT_AVAILABLE')?><?endif;?>
							</div>
						<?}else {?>
							<div class="available_block"><?=GetMessage('CT_IS_AVAILABLE')?> <?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"):?>( <?=$arResult["CATALOG_QUANTITY"]?> )<?endif;?></div>
						<?}?>
					<?}?>
					<?if ($arCountPricesCanAccess && ($arParams["SHOW_FOUND_CHEAPER"]!="N")):?>
					<!--noindex-->
						<div class="center_info">
							<a rel="nofollow" href="#" class="found_cheaper" item-name="<?=$arResult["NAME"]?>"><span><?=GetMessage('CT_BCE_CATALOG_FIND_CHEAPER')?></span></a>
						</div>
					<!--/noindex-->
					<?endif;?>
				<?endif;?>	
			</div>
		
			<?if( is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ){?>
				<?if(($arParams["SKU_DISPLAY_LOCATION"]=="RIGHT")||(!$arParams["SKU_DISPLAY_LOCATION"])):?>
					<?
						$numProps = count($arResult["SKU_ELEMENTS"]);
						foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp)
						{
							$noProp = 0;
							foreach ($arResult["SKU_ELEMENTS"] as $i => $arSKU) { if (empty( $arSKU[$key] )) { $noProp++; } }
							if ($noProp==$numProps) { unset($arResult["SKU_PROPERTIES"][$key]); }

						}
						$showPrices = false;
						foreach ($arResult["SKU_ELEMENTS"] as $key => $arSKU) { if ($arSKU["DISCOUNT_PRICE"] || $arSKU["PRICE"]){$showPrices = true; break;} }
						$showPhotoColumn = false;
						if ($arParams["SKU_SHOW_PICTURES"]=="Y")
						{
							foreach ($arResult["SKU_ELEMENTS"] as $arSKU)
								{ if( !empty($arSKU["PREVIEW_PICTURE"]) && !empty($arSKU["PREVIEW_PICTURE"] )) { $showPhotoColumn = true; break; } }
						}
					?>	
					<table class="equipment" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<?if ($showPhotoColumn):?><td><?=GetMessage("CATALOG_PHOTO")?></td><?endif;?>
								<?foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp){?><td class="property"><?=$arProp["NAME"]?></td><?}?>
								<?if ($showPrices):?><td><?=GetMessage("CATALOG_PRICE")?></td><?endif;?>
								<?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"){?><td class="offer_count"><?=GetMessage("AVAILABLE")?></td><?}?>
								<?if ($arParams["USE_ONE_CLICK_BUY"]!="N"):?><td colspan="2"></td><?else:?><td></td><?endif;?>
							</tr>
						</thead>
						<tbody>
							<?$numProps = count($arResult["SKU_PROPERTIES"]);?>
							<?foreach ($arResult["SKU_ELEMENTS"] as $key => $arSKU){?>
								<?if ($arSKU["ID"]):?>
									<?
										if (($arParams["SHOW_MEASURE"]=="Y")&&($arSKU["CATALOG_MEASURE"]))
										{ 
											$symb = substr($arSKU["PRICE"], strrpos($arSKU["PRICE"], ' '));
											$arSCUMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arSKU["CATALOG_MEASURE"]), false, false, array())->GetNext(); 
										}
									?>
									<tr>
										<?if ($showPhotoColumn):?>	
											<td class="photo">
												<?if( !empty($arSKU["PREVIEW_PICTURE"]) ){?>
													<a href="<?=($arSKU["DETAIL_PICTURE"]["SRC"]?$arSKU["DETAIL_PICTURE"]["SRC"]:$arSKU["PREVIEW_PICTURE"]["SRC"])?>" class="fancy" title="<?=$arSKU["NAME"]?>">
														<?$img_preview = CFile::ResizeImageGet( $arSKU["PREVIEW_PICTURE"]["ID"], array( "width" => 40, "height" => 40 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
														<img border="0" src="<?=$img_preview["src"]?>" alt="<?=$arSKU["NAME"]?>" />
													</a>
												<?}elseif( !empty($arSKU["DETAIL_PICTURE"]) ){?>
													<a href="<?=$arSKU["DETAIL_PICTURE"]["SRC"]?>" class="fancy" title="<?=$arSKU["NAME"]?>">
														<?$img_preview = CFile::ResizeImageGet( $arSKU["DETAIL_PICTURE"]["ID"], array( "width" => 40, "height" => 40 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
														<img border="0" src="<?=$img_preview["src"]?>" alt="<?=$arSKU["NAME"]?>"  />
													</a>
												<?}else{?>
													<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage40.gif" alt="<?=$arSKU["NAME"]?>" title="<?=$arSKU["NAME"]?>" />
												<?}?>
											</td>
										<?endif;?>
										<?for( $i = 0; $i < $numProps; $i++ ){?><?=!empty( $arResult["SKU_PROPERTIES"][$i] ) ? '<td class="property">'.$arSKU[$i].'</td>' : ''?><?}?>
										<?if ($showPrices):?><td class="price">
											<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arSCUMeasure["SYMBOL_RUS"]):?>
												<?if( intval($arSKU["DISCOUNT_PRICE"]) > 0 && $arSKU["PRICE"] > 0){?>
													<span class="new"><?=str_replace($symb, "", $arSKU["DISCOUNT_PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?></span>												
													<span class="old"><?=str_replace($symb, "", $arSKU["PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?></span>
												<?}elseif($arSKU["PRICE"]){?>
													<?=str_replace($symb, "", $arSKU["PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?>
												<?}?>												
											<?else:?>
												<?if( intval($arSKU["DISCOUNT_PRICE"]) > 0 && $arSKU["PRICE"] > 0){?>
													<span class="new"><?=$arSKU["DISCOUNT_PRICE"]?> </span> <span class="old"><?=$arSKU["PRICE"]?> </span>
												<?}else{?>
													<?=$arSKU["PRICE"]?>
												<?}?>
											<?endif;?>
										</td><?endif;?>
										<?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"){?>									
											<td class="offer_count">
												<?if($arParams["USE_STORE"] == "Y"):?><a class="show_offers_stores" onclick="return showOffersStores('<?=$arSKU["ID"]?>', '<?=$arParams["MIN_AMOUNT"]?>', '<?=$arParams["USE_MIN_AMOUNT"]?>', '<?=$arParams["USE_STORE_SCHEDULE"]?>', '<?=$arParams["USE_STORE_PHONE"]?>', '<?=$arParams["STORE_PATH"]?>');"><?endif;?>
													<?=$arSKU["CATALOG_QUANTITY"]?>
												<?if($arParams["USE_STORE"] == "Y"):?></a><?endif;?>
											</td>
										<?}?>
										
										<!--noindex-->
											<td class="buy_link">
												<?if( $arSKU["CAN_BUY"] ){?>
													<a rel="nofollow" element_id="#<?=$arSKU["ID"];?>" href="<?=$arSKU["ADD_URL"]?>" onclick="return addToCart(this, 'detail', '<?=GetMessage("CATALOG_IN_CART")?>', 'cart', '<?=$arParams["BASKET_URL"]?>', '<?=$arResult["ID"]?>', '<?=$arSKU["ID"]?>');"><?=GetMessage("CATALOG_BUY")?></a>
												<?} elseif ($arNotify[SITE_ID]['use'] == 'Y'){?>
													<?if( $USER->IsAuthorized() ){?>
														<noindex>
															<a rel="nofollow" href="<?=$arSKU["SUBSCRIBE_URL"]?>" onclick="return addToSubscribe(this, '<?=GetMessage("CATALOG_IN_SUBSCRIBE")?>');"><?=GetMessage("CATALOG_SUBSCRIBE")?></a>
															<sup class="notavailable"><?=GetMessage("CATALOG_NOT_AVAILABLE2")?></sup>
														</noindex>
													<?}else{?>
														<noindex>
															<a rel="nofollow" href="#" onclick="showAuthForSubscribe(this, <?=$arSKU["ID"]?>, '<?=$arSKU["SUBSCRIBE_URL"]?>')"><?=GetMessage("CATALOG_SUBSCRIBE")?></a>
															<sup class="notavailable"><?=GetMessage("CATALOG_NOT_AVAILABLE2")?></sup>
														</noindex>
													<?}?>
												<?}?>
											</td>
											<?if ($arParams["USE_ONE_CLICK_BUY"]!="N"):?>
												<td class="buy_link">
													<?if( $arSKU["CAN_BUY"] ){?>
														<a data-props="<?=$arOfferProps;?>" onclick="return oneClickBuy('<?=$arSKU["ID"];?>', '<?=$arResult["IBLOCK_ID"]?>');"><?=GetMessage('ONE_CLICK_BUY')?></a>	
													<?}?>
												</td>
											<?endif;?>
										<?if( $arParams["DISPLAY_COMPARE"] == "Y" ){?>
											<td>
												<a rel="nofollow" href="#<?=$arSKU["ID"]?>" class="wish_item"><?=GetMessage("CATALOG_IZB")?></a>
											</td>
										<?}?>
									<!--/noindex-->
									</tr>
								<?endif;?>
							<?}?>
						</tbody>
					</table>
				<?endif;?>
			<?}?>
		</div>
		<?if ($arResult["PREVIEW_TEXT"]):?>
			<div class="description"><?=$arResult["PREVIEW_TEXT"];?></div>
		<?endif;?>

	</div>
	<div style="clear:both"></div>

	<?if( is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ){?>

		<?if($arParams["SKU_DISPLAY_LOCATION"]=="BOTTOM"):?>
			<?
				$numProps = count($arResult["SKU_ELEMENTS"]);


				foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp)
				{
					$noProp = 0;
					foreach ($arResult["SKU_ELEMENTS"] as $i => $arSKU) { if (empty( $arSKU[$key] )) { $noProp++; } }
					if ($noProp==$numProps) { unset($arResult["SKU_PROPERTIES"][$key]); }

				}
				$showPrices = false;
				foreach ($arResult["SKU_ELEMENTS"] as $key => $arSKU) { if ($arSKU["DISCOUNT_PRICE"] || $arSKU["PRICE"]){$showPrices = true; break;} }
				$showPhotoColumn = false;
				if ($arParams["SKU_SHOW_PICTURES"]=="Y")
				{
					foreach ($arResult["SKU_ELEMENTS"] as $arSKU)
						{ if( !empty($arSKU["PREVIEW_PICTURE"]) && !empty($arSKU["PREVIEW_PICTURE"] )) { $showPhotoColumn = true; break; } }
				}
			?>			
			<table class="equipment" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<?if ($showPhotoColumn):?><td><?=GetMessage("CATALOG_PHOTO")?></td><?endif;?>
						<?$numProps = 0;?>
						<?foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp){ $numProps++; ?><td class="property"><?=$arProp["NAME"]?></td><?}?>
						<?if ($showPrices):?><td><?=GetMessage("CATALOG_PRICE")?></td><?endif;?>
						<?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"){?><td class="offer_count"><?=GetMessage("AVAILABLE")?></td><?}?>
						<?if ($arParams["USE_ONE_CLICK_BUY"]!="N"):?><td colspan="2"></td><?else:?><td></td><?endif;?>
					</tr>
				</thead>
				<tbody>
					
					<?foreach ($arResult["SKU_ELEMENTS"] as $key => $arSKU){?>
						<?if ($arSKU["ID"]):?>
							<tr>
								<?if ($showPhotoColumn):?>	
									<td class="photo">
										
										
										<?if( !empty($arSKU["PREVIEW_PICTURE"]) ){?>
											<a href="<?=($arSKU["DETAIL_PICTURE"]["SRC"]?$arSKU["DETAIL_PICTURE"]["SRC"]:$arSKU["PREVIEW_PICTURE"]["SRC"])?>" class="fancy" title="<?=$arSKU["NAME"]?>">
												<?$img_preview = CFile::ResizeImageGet( $arSKU["PREVIEW_PICTURE"]["ID"], array( "width" => 50, "height" => 50 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
												<img border="0" src="<?=$img_preview["src"]?>" alt="<?=$arSKU["NAME"]?>" />
											</a>
										<?}elseif( !empty($arSKU["DETAIL_PICTURE"]) ){?>
											<a href="<?=$arSKU["DETAIL_PICTURE"]["SRC"]?>" class="fancy" title="<?=$arSKU["NAME"]?>">
												<?$img_preview = CFile::ResizeImageGet( $arSKU["DETAIL_PICTURE"]["ID"], array( "width" => 50, "height" => 50 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
												<img border="0" src="<?=$img_preview["src"]?>" alt="<?=$arSKU["NAME"]?>"  />
											</a>
										<?}else{?>
											<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage40.gif" alt="<?=$arSKU["NAME"]?>" title="<?=$arSKU["NAME"]?>" />
										<?}?>
									</td>
								<?endif;?>
								<?foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp) {?><?='<td class="property">'.$arSKU[$key].'</td>'?><?}?>
								<?if ($showPrices):?><td class="price">
									<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arSCUMeasure["SYMBOL_RUS"]):?>
										<?if( intval($arSKU["DISCOUNT_PRICE"]) > 0 && $arSKU["PRICE"] > 0){?>
											<span class="new"><?=str_replace($symb, "", $arSKU["DISCOUNT_PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?></span>											
											<span class="old"><?=str_replace($symb, "", $arSKU["PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?></span>
										<?}else{?>
											<?=str_replace($symb, "", $arSKU["PRICE"])."<small>".$symb."/".$arSCUMeasure["SYMBOL_RUS"]."</small>";?>
										<?}?>												
									<?else:?>
										<?if( intval($arSKU["DISCOUNT_PRICE"]) > 0 && $arSKU["PRICE"] > 0){?>
											<span class="new"><?=$arSKU["DISCOUNT_PRICE"]?> </span> <span class="old"><?=$arSKU["PRICE"]?> </span>
										<?}elseif($arSKU["PRICE"]){?>
											<?=$arSKU["PRICE"]?>
										<?}?>
									<?endif;?>

								</td><?endif;?>	
								<?if ($arParams["SHOW_QUANTITY_COUNT"]!="N"){?>							
									<td class="offer_count">
										<?if($arParams["USE_STORE"] == "Y"):?><a class="show_offers_stores" onclick="return showOffersStores('<?=$arSKU["ID"]?>', '<?=$arParams["MIN_AMOUNT"]?>', '<?=$arParams["USE_MIN_AMOUNT"]?>', '<?=$arParams["USE_STORE_SCHEDULE"]?>', '<?=$arParams["USE_STORE_PHONE"]?>', '<?=$arParams["STORE_PATH"]?>');"><?endif;?>
											<?=$arSKU["CATALOG_QUANTITY"]?>
										<?if($arParams["USE_STORE"] == "Y"):?></a><?endif;?>
									</td>
								<?}?>
								<!--noindex-->
										<td class="buy_link">
											<?if( $arSKU["CAN_BUY"] ){?>
												<a rel="nofollow" element_id="#<?=$arSKU["ID"];?>" href="<?=$arSKU["ADD_URL"]?>" onclick="return addToCart(this, 'detail', '<?=GetMessage("CATALOG_IN_CART")?>', 'cart', '<?=$arParams["BASKET_URL"]?>', '<?=$arResult["ID"]?>', '<?=$arSKU["ID"]?>');"><?=GetMessage("CATALOG_BUY")?></a>
											<?} elseif ($arNotify[SITE_ID]['use'] == 'Y'){?>
												<?if( $USER->IsAuthorized() ){?>
													<noindex>
														<a rel="nofollow" href="<?=$arSKU["SUBSCRIBE_URL"]?>" onclick="return addToSubscribe(this, '<?=GetMessage("CATALOG_IN_SUBSCRIBE")?>');"><?=GetMessage("CATALOG_SUBSCRIBE")?></a>
														<sup class="notavailable"><?=GetMessage("CATALOG_NOT_AVAILABLE2")?></sup>
													</noindex>
												<?}else{?>
													<noindex>
														<a rel="nofollow" href="#" onclick="showAuthForSubscribe(this, <?=$arSKU["ID"]?>, '<?=$arSKU["SUBSCRIBE_URL"]?>')"><?=GetMessage("CATALOG_SUBSCRIBE")?></a>
														<sup class="notavailable"><?=GetMessage("CATALOG_NOT_AVAILABLE2")?></sup>
													</noindex>
												<?}?>
											<?}?>
										</td>
										<?if ($arParams["USE_ONE_CLICK_BUY"]!="N"):?>
											<td class="buy_link">
												<?if( $arSKU["CAN_BUY"] ){?>
													<a data-props="<?=$arOfferProps;?>" data-id="el_<?=$arSKU["ID"];?>" onclick="return oneClickBuy('<?=$arSKU["ID"];?>', '<?=$arResult["IBLOCK_ID"]?>');"><?=GetMessage('ONE_CLICK_BUY')?></a>	
												<?}?>
											</td>
										<?endif;?>
									<?if( $arParams["DISPLAY_COMPARE"] == "Y" ){?>
										<td>
											<a rel="nofollow" href="#<?=$arSKU["ID"]?>" class="wish_item"><?=GetMessage("CATALOG_IZB")?></a>
										</td>
									<?}?>
								<!--/noindex-->
							</tr>
						<?endif;?>
					<?}?>
				</tbody>
			</table>
			<br />
		<?endif;?>
	<?}?>
</div>


<?if (($arParams["SHOW_KIT_PARTS"]=="Y") && !empty($arResult["SET_ITEMS"])):?>
	<div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div>
	<div class="set_wrapp">
		<h4 class="char"><?=GetMessage("GROUP_PARTS_TITLE")?></h4>
		<div class="display_table">
			<?foreach ($arResult["SET_ITEMS"] as $iii => $arSetItem):?>	
				<div class="table_item item_ws <?if( $i % 4 == 0 ):?>last-in-line<?endif;?>">
					<div class="table_item_inner">
						<div class="image">
							<a href="<?=$arSetItem["DETAIL_PAGE_URL"]?>" class="thumb_cat">
								<?if( !empty($arSetItem["PREVIEW_PICTURE"]) ):?>
									<?$img = CFile::ResizeImageGet($arSetItem["PREVIEW_PICTURE"], array( "width" => 140, "height" => 140 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
									<img border="0" src="<?=$img["src"]?>" alt="<?=$arSetItem["NAME"];?>" title="<?=$arSetItem["NAME"];?>" />		
								<?else:?>
									<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage170.gif" alt="<?=$arSetItem["NAME"]?>" title="<?=$arSetItem["NAME"]?>" />
								<?endif;?>
							</a>
						</div>
						<div class="marks">
							<?if( $arSetItem["PROPERTIES"]["STOCK"]["VALUE"] == true ){?><span class="mark share"></span><?}?>
							<?if( $arSetItem["PROPERTIES"]["HIT"]["VALUE"] == true ){?><span class="mark hit"></span><?}?>
							<?if( $arSetItem["PROPERTIES"]["RECOMMEND"]["VALUE"] == true ){?><span class="mark like"></span><?}?>
							<?if( $arSetItem["PROPERTIES"]["NEW"]["VALUE"] == true ){?><span class="mark new"></span><?}?>
						</div>
						<a class="desc_name" href="<?=$arSetItem["DETAIL_PAGE_URL"]?>"><?
						
							if ($arResult["SET_ITEMS_IDS"][$arSetItem["ID"]]["QUANTITY"]>1) {
								echo $arResult["SET_ITEMS_IDS"][$arSetItem["ID"]]["QUANTITY"].$arSetItem["MEASURE"]["SYMBOL_RUS"].' - ';
							}
						?><?=$arSetItem["NAME"]?></a>
						
						<?if ($arParams["SHOW_KIT_PARTS_PRICES"]=="Y"):?>								
							<div class="price_block">	
								<?
									$arCountPricesCanAccess = 0;
									foreach( $arSetItem["PRICES"] as $key => $arPrice ) { if($arPrice["CAN_ACCESS"]){$arCountPricesCanAccess++;} }
								?>
								<?foreach($arSetItem["PRICES"] as $key => $arPrice ){?>
									<?if( $arPrice["CAN_ACCESS"] ){?>
										<?$price = CPrice::GetByID($arPrice["ID"]); ?>
										<?if($arCountPricesCanAccess>1):?><div class="price_name"><?=$price["CATALOG_GROUP_NAME"];?></div><?endif;?>
										<div class="price">
											<?if( $arPrice["VALUE"] > $arPrice["DISCOUNT_VALUE"] ){?>
												<div class="price">
													<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arSetItem["MEASURE"]["SYMBOL_RUS"]):?>
														<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
														<span class="new"><?=str_replace($symb, "", $arPrice["PRINT_DISCOUNT_VALUE"])."<small>".$symb."/".$arSetItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
														<span class="old"><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arSetItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
													<?else:?>
														<span class="new"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
														<span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
													<?endif;?>
												</div>
											<?}else{?>
												<?if (($arParams["SHOW_MEASURE"]=="Y")&&$arSetItem["MEASURE"]["SYMBOL_RUS"]):?>
													<?$symb = substr($arPrice["PRINT_VALUE"], strrpos($arPrice["PRINT_VALUE"], ' '));?>
													<span><?=str_replace($symb, "", $arPrice["PRINT_VALUE"])."<small>".$symb."/".$arSetItem["MEASURE"]["SYMBOL_RUS"]."</small>";?></span>
												<?else:?><span><?=$arPrice["PRINT_VALUE"]?></span><?endif;?>
											<?}?>
										</div>
									<?}?>
								<?}?>
							</div>
						<?endif;?>
					</div>
					<?if(($iii+1) % 4 != 0 && $arResult["SET_ITEMS"][$iii+1]){?><div class="plus"></div><?}?>
				</div>			
				<?if( ($iii+1) % 4 == 0 && ($iii+1) < count($arResult["SET_ITEMS"]) ){?>
					<div class="long_separator"></div>
				<?}?>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>

<? if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
		if ($arResult['OFFER_GROUP']) { foreach ($arResult['OFFERS'] as $arOffer) { if (!$arOffer['OFFER_GROUP']) continue;
	?>
	<span id="<? echo $arItemIDs['OFFER_GROUP'].$arOffer['ID']; ?>" style="display: none;">
			<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor", "shop",
				array(
					"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
					"ELEMENT_ID" => $arOffer['ID'],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
				), $component, array("HIDE_ICONS" => "Y")
			);?>
	</span>
<?}}} else {?>
		<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor", "shop",
			array(
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ELEMENT_ID" => $arResult["ID"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
			), $component, array("HIDE_ICONS" => "Y")
		);?>
<?}?>	

<? /*Product Description */ ?>
<?		$rsStock = CIBlockElement::GetList(array(), array("ACTIVE" => "Y", "IBLOCK_ID" => $arParams["IBLOCK_STOCK_ID"], "PROPERTY_LINK" => $arResult["ID"]));
		$stockShadowShown = false;
		if($rsStock->SelectedRowsCount()>0):?>
			<div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div>
			<?	$stockShadowShown = true;
				$rsStock->SetUrlTemplates($arParams["SEF_MODE_STOCK_SECTIONS"].$arParams["SEF_MODE_STOCK_ELEMENT"]);
				$stockNumber = 1;
				while( $arStock = $rsStock->GetNext() ){?>
				<div class="stock_board<?=($stockNumber==1?" first": "")?>"><?$stockNumber++;?>
					<div class="name"><?=GetMessage("CATALOG_STOCK_TITLE")?> <a class="read_more" href="<?=$arStock["DETAIL_PAGE_URL"]?>"><?=GetMessage("CATALOG_STOCK_VIEW")?></a> <i></i> </div>
					<div class="txt"><?=$arStock["PREVIEW_TEXT"]?></div>				
				</div>
			<?}?>
		<?endif;?>
		<?if ($arResult["DETAIL_TEXT"]):?>
			<?if (!$stockShadowShown):?><div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div><?endif;?>
			<div class="detail_text"><?=$arResult["DETAIL_TEXT"]?></div>
		<?endif;?>
		
		
		<?if ($arParams["PROPERTIES_DISPLAY_LOCATION"]!="TAB"):?>
			<?
				$showProps = false;
				foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp )
				{
					if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")&&trim($arProp["VALUE"])){$showProps=true;}
				}
			?>
			<?if ($showProps):?>
				<div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div>
				<h4 class="char"><?=GetMessage('CT_NAME_DOP_CHAR')?></h4>
				<div class="char-wrapp">			
					<?if ($arParams["PROPERTIES_DISPLAY_TYPE"]!="TABLE"):?>
						<?foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp ){?>
							<?if (!in_array($arProp["CODE"], array("NOTAVAIBLE", "HIT", "RECOMMEND", "NEW", "STOCK"))):?>
								<?if( !empty( $arProp["VALUE"] ) ){?>
									<div class="char">
										<div class="char_name">
										<?if ($arProp["HINT"]):?><div class="hint"><span class="icon"><i>i</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
										<?=$arProp["NAME"]?>:</div>
										<div class="char_value">
											<?
												if(count($arProp["DISPLAY_VALUE"])>1) 
													{ foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
												else 
													{ echo $arProp["DISPLAY_VALUE"]; }
											?>
										</div>
									</div>
								<?}?>
							<?endif;?>
						<?}?>
					<?else:?>
						<table class="props_table">
							<?foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp ){?>
								<?if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")):?>				
									<?if( !empty( $arProp["VALUE"] ) ){?>
										<tr>
											<td class="char_name"><span><?if($arProp["HINT"]):?><div class="hint"><span class="icon"><i>i</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?><?=$arProp["NAME"]?></span></td>
											<td class="char_value"><span>
												<?
													if(count($arProp["DISPLAY_VALUE"])>1) 
														{ foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
													else 
														{ echo $arProp["DISPLAY_VALUE"]; }
												?></span>
											</td>
										</tr>
									<?}?>
								<?endif;?>
							<?}?>
						</table>
					<?endif;?>
				</div>			
			<?endif;?>
		<?endif;?>
		
		<?if( !empty($arResult["PROPERTIES"]["INSTRUCTIONS"]["VALUE"]) ){?>
			<div class="shadow-item_info"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/shadow-item_info_revert.png" alt="" /></div>
			<h4 class="char"><?=GetMessage('CT_NAME_INSTRUCTIONS')?></h4><br/>
			<?foreach( $arResult["PROPERTIES"]["INSTRUCTIONS"]["VALUE"] as $arItem ){?>
				<?$arItem = CFile::GetFileArray($arItem);?>
				<div class="<? if( $arItem["CONTENT_TYPE"] == 'application/pdf' ){ echo "pdf"; } elseif( $arItem["CONTENT_TYPE"] == 'application/octet-stream' ){ echo "word"; } elseif( $arItem["CONTENT_TYPE"] == 'application/xls' ){ echo "excel"; }?>">
					<?$FileName = substr($arItem["ORIGINAL_NAME"], 0, strrpos($arItem["ORIGINAL_NAME"], '.'));?>
					<a href="<?=$arItem["SRC"]?>"><?if($arItem["DESCRIPTION"]){echo $arItem["DESCRIPTION"];} else {echo $FileName;}?></a>
					<?=GetMessage('CT_NAME_SIZE')?>:
					<?
						$filesize = $arItem["FILE_SIZE"];
						if($filesize > 1024) {
							$filesize = ($filesize/1024);
							if($filesize > 1024) {
								$filesize = ($filesize/1024);
								if($filesize > 1024) {
									$filesize = ($filesize/1024);
									$filesize = round($filesize, 1);
									echo $filesize.GetMessage('CT_NAME_GB');
								} else {
									$filesize = round($filesize, 1);
									echo $filesize.GetMessage('CT_NAME_MB');
								}
							} else {
								$filesize = round($filesize, 1);
								echo $filesize.GetMessage('CT_NAME_KB');
							}
						} else {
							$filesize = round($filesize, 1);
							echo $filesize.GetMessage('CT_NAME_b');
						}
					?>
				</div>
			<?}?>
		<?}?>
<? /*Product tabs */ ?>
<div class="tabs_section">
<br/><br/>
	<ul class="tabs">
		<? 
			global $first_tab;
			$show_tabs = false;
			$first_tab=-1;
		?>		
		<?if ($arParams["PROPERTIES_DISPLAY_LOCATION"]=="TAB"){?>
			<?
				$showProps = false;
				foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp )
				{
					if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")&&trim($arProp["VALUE"])){$showProps=true;}
				}				
				if ($showProps){
			?>
			<li <? echo !$show_tabs?'class="current"':''; ?>>
				<span><i><?=GetMessage('CT_NAME_DOP_CHAR')?></i></span>
			</li>
			<?
				if (!$show_tabs) {
					$first_tab=1;
					$show_tabs=true;
				}
			?>
		<?}}?>
		<?if( !$arResult["OFFERS"]):?>
			<?if($arParams["USE_STORE"] == "Y"):?>
				<li <? echo !$show_tabs?'class="current"':''; ?>>
					<span><i><?=$arParams["MAIN_TITLE"]?></i></span>
				</li>
				<?
					if (!$show_tabs) {
						$first_tab=2;
						$show_tabs=true;
					}
				?>
			<?endif;?>
		<?endif;?>
		<?if ($arParams["USE_ALSO_BUY"]=="Y"):?>
			<?if( !empty($arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"]) ):?>
				<li <? echo !$show_tabs?'class="current"':''; ?>>
					<span><i><?=GetMessage('CT_NAME_ASSOCIATED_TITLE')?> (<?=count($arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"])?>)</i></span>
				</li>
				<?
					if (!$show_tabs) {
						$first_tab=3;
						$show_tabs=true;
					}
				?>
			<?endif;?>	
		<?endif;?>						
		
		<?if( !empty( $arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"] ) ){ ?>
			<li <? echo !$show_tabs?'class="current"':''; ?>>
				<span><i><?=GetMessage('CT_NAME_DOP_OBORUDOVANIE')?> (<?=count($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"])?>)</i></span>
			</li>
			<?
				if (!$show_tabs) {
					$first_tab=4;
					$show_tabs=true;
				}
			?>
		<?}?>
		<?if (($arParams["SHOW_ASK_BLOCK"]=="Y")&&(intVal($arParams["ASK_FORM_ID"]))):?>
			<li <? echo !$show_tabs?'class="current"':''; ?>>
				<span><i><?=GetMessage('CT_NAME_ASK_BLOCK_TITLE')?></i></span>
				<?
					if (!$show_tabs) {
						$first_tab=5;
						$show_tabs=true;
					}
				?>
			</li>
		<?endif;?>
		<?if ($arParams["USE_REVIEW"]=="Y"):?>
			<li <? echo !$show_tabs?'class="current"':''; ?>>
				<span><i id="product_reviews_title"><?=GetMessage('PRODUCT_REVIEWS')?><span class="count empty"></span></i></span>
				<?
					if (!$show_tabs) {
						$first_tab=6;
						$show_tabs=true;
					}
				?>
			</li>
		<?endif;?>	
	</ul>
	
	
	<!--noindex-->
		<?/*if(!$arResult["CATALOG_QUANTITY"]){?>
			<?if( $USER->IsAuthorized() ){?>
				<a rel="nofollow" href="<?=$arResult["SUBSCRIBE_URL"]?>" class="button add_order" onclick="return addToSubscribe(this, '<?=GetMessage("CATALOG_IN_SUBSCRIBE")?>');" class="bt2" id="catalog_add2cart_link"><span><?=GetMessage('CATALOG_ORDER_NAME')?></span></a>
			<?}else{?>
				<a rel="nofollow" href="#" class="button add_order" onclick="showAuthForSubscribe(this, <?=$arResult["ID"]?>, '<?=$arResult["SUBSCRIBE_URL"]?>')" class="bt2"><span><?=GetMessage('CATALOG_ORDER_NAME')?></span></a>
			<?}?><br/><br/>
		<?}*/?>
	<!--/noindex-->	
	<?
		$showProps = false;
		foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp )
		{
			if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")&&trim($arProp["VALUE"])){$showProps=true;}
		}
	?>	
	<?if ($arParams["PROPERTIES_DISPLAY_LOCATION"]=="TAB" && $showProps):?>
		<div class="box" <? echo $first_tab==1?'style="display: block;"':''; ?>>	
			<div class="char-wrapp">			
				<?if ($arParams["PROPERTIES_DISPLAY_TYPE"]!="TABLE"):?>
					<?foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp ){?>
						<?if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")):?>				
							<?if( !empty( $arProp["VALUE"] ) ){?>
								<div class="char">
									<div class="char_name"><?if ($arProp["HINT"]):?><div class="hint"><span class="icon"><i>i</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?><?=$arProp["NAME"]?>:</div>
									<div class="char_value">
										<?
											if(count($arProp["DISPLAY_VALUE"])>1) 
												{ foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
											else 
												{ echo $arProp["DISPLAY_VALUE"]; }
										?>
									</div>
								</div>
							<?}?>
						<?endif;?>
					<?}?>
				<?else:?>
					<table class="props_table">
						<?foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp ){?>
							<?if (($arProp["CODE"]!="HIT")&&($arProp["CODE"]!="RECOMMEND")&&($arProp["CODE"]!="NEW")&&($arProp["CODE"]!="STOCK")):?>				
								<?if( !empty( $arProp["VALUE"] ) ){?>
									<tr>
										<td class="char_name"><span><?if ($arProp["HINT"]):?><div class="hint"><span class="icon"><i>i</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?><?=$arProp["NAME"]?></span></td>
										<td class="char_value"><span>
											<?
												if(count($arProp["DISPLAY_VALUE"])>1) 
													{ foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
												else 
													{ echo $arProp["DISPLAY_VALUE"]; }
											?></span>
										</td>
									</tr>
								<?}?>
							<?endif;?>
						<?}?>
					</table>
				<?endif;?>
			</div>			
		</div>
	<?endif;?>
	<?if( !$arResult["OFFERS"]):?>
		<?if($arParams["USE_STORE"] == "Y"){?>	
			<div class="box" <? echo $first_tab==2?'style="display: block;"':''; ?>>	
				<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "shop", array(
						"PER_PAGE" => "10",
						"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
						"SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
						"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
						"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
						"ELEMENT_ID" => $arResult["ID"],
						"STORE_PATH"  =>  $arParams["STORE_PATH"],
						"MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
					),
					$component
				);?>	
			</div>
		<?}?>
	<?endif;?>
		
	<?if ($arParams["USE_ALSO_BUY"]=="Y"):?>
		<?if( !empty($arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"]) ){?>
		<div class="box" <? echo $first_tab==3?'style="display: block;"':''; ?>>
			<div class="associated_items">			
					<?$GLOBALS['arrFilterAssociated'] = array( "ID" => $arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"] );
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"shop_table_preview",
						Array(					
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"SECTION_ID" => 0,
							"SECTION_CODE" => "",
							"ELEMENT_SORT_FIELD" => "sort",
							"ELEMENT_SORT_ORDER" => "asc",
							"FILTER_NAME" => "arrFilterAssociated",
							"INCLUDE_SUBSECTIONS" => "Y",
							"SHOW_ALL_WO_SECTION" => "Y",
							"PAGE_ELEMENT_COUNT" => "99999",
							"LINE_ELEMENT_COUNT" => 4,
							"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
							"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
							"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
							"AJAX_MODE" => $arParams["AJAX_MODE"],
							"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
							"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
							"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
							"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
							"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
							"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
							"ADD_SECTIONS_CHAIN" => "N",
							"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
							"SET_TITLE" => $arParams["SET_TITLE"],
							"SET_STATUS_404" => $arParams["SET_STATUS_404"],
							"CACHE_FILTER" => $arParams["CACHE_FILTER"],
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"USE_PRODUCT_QUANTITY" => $arParams["SET_STATUS_404"],
							"OFFERS_CART_PROPERTIES" => array(),
							"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
							"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
							"PAGER_TITLE" => $arParams["PAGER_TITLE"],
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
							"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
							"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
							"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
							"AJAX_OPTION_ADDITIONAL" => "",
							"ADD_CHAIN_ITEM" => "N",
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
						),
					$component
					);?>		
			</div>
		</div>		
		<?}?>
	<?endif;?>
	
	<?if( !empty($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]) ){?>
		<div class="box" <? echo $first_tab==4?'style="display: block;"':''; ?>>
			<?$GLOBALS['arrFilterExpandables'] = array( "ID" => $arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"] );
			$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"shop_table_preview",
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "asc",
				"FILTER_NAME" => "arrFilterExpandables",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"PAGE_ELEMENT_COUNT" => "99999",
				"LINE_ELEMENT_COUNT" => 4,
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"AJAX_MODE" => $arParams["AJAX_MODE"],
				"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
				"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
				"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
				"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
				"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
				"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
				"ADD_SECTIONS_CHAIN" => "N",
				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => $arParams["SET_STATUS_404"],
				"OFFERS_CART_PROPERTIES" => array(),
				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
				"AJAX_OPTION_ADDITIONAL" => "",
				"ADD_CHAIN_ITEM" => "N",
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"CURRENCY_ID" => $arParams["CURRENCY_ID"],
				"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
			),
		$component
		);?>
		</div>
	<?}?>




