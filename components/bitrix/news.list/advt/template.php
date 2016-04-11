<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?foreach( $arResult["ITEMS"] as $arItem ){
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if( is_array( $arItem["DETAIL_PICTURE"] ) ){?>
		<div class="advt_banner" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if( !empty( $arItem["PROPERTIES"]["LINK"]["VALUE"] ) ){?>
				<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
			<?}?>
				<img border="0" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
			<?if( !empty( $arItem["PROPERTIES"]["LINK"]["VALUE"] ) ){?>
				</a>
			<?}?>
		</div>
	<?}?>
<?}?>