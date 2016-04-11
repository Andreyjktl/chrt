<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if( !empty( $arResult ) ){?>
	<ul class="mini-menu">
		<li><a href="#"><?=GetMessage('MENU_NAME')?></a></li>
	</ul>
	<ul class="menu">
		<?foreach( $arResult as $key => $arItem ){?>
			<li><a href="<?=$arItem["LINK"]?>" <?if( $arItem["SELECTED"] ):?>class="current"<?endif?>><?=$arItem["TEXT"]?></a>
				<?if( $arItem["IS_PARENT"] == 1 ){?>
					<div class="child submenu">
						<?foreach( $arItem["ITEMS"] as $arSubItem ){?>
							<a href="<?=$arSubItem["LINK"]?>"><?=$arSubItem["TEXT"]?></a>
						<?}?>
					</div>
				<?}?>
				<?if( $arItem["LINK"] == $arParams["IBLOCK_CATALOG_DIR"] ){?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section.list",
						"top_menu",
						Array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_CATALOG_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_CATALOG_ID"],
							"SECTION_ID" => "",
							"SECTION_CODE" => "",
							"COUNT_ELEMENTS" => "N",
							"TOP_DEPTH" => "2",
							"SECTION_FIELDS" => array(0=>"",1=>"",),
							"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
							"SECTION_URL" => "",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600",
							"CACHE_GROUPS" => "Y",
							"ADD_SECTIONS_CHAIN" => "N"
						)
					);?>
				<?}?>
			</li>
		<?}?>
	</ul>
<?}?>