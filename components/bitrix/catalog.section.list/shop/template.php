<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="catalog_section_list">
	<?foreach( $arResult["SECTIONS"] as $arSection ){
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
	?>
		<div class="section_item" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
			<div class="section_item_inner">
				<div class="image">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
						<?if ($arSection["PICTURE"]["SRC"]):?>
							<?$img = CFile::ResizeImageGet( $arSection["PICTURE"], array( "width" => 60, "height" => 60 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, array() );?>
							<img border="0" src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arResult["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arResult["NAME"])?>" />
						<?else:?>
							<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/noimage40.gif" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arResult["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arResult["NAME"])?>" />
						<?endif;?>
					</a>
				</div>
				<ul>
					<li class="name">
						<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?><? echo $arSection["ELEMENT_CNT"]?'&nbsp;('.$arSection["ELEMENT_CNT"].')':'';?></a> 
					</li>
					<?foreach( $arSection["SECTIONS"] as $arItem )
					{
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "SECTION_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
					?>
						<li class="sect" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["SECTION_PAGE_URL"]?>"><?=$arItem["NAME"]?><? echo $arItem["ELEMENT_CNT"]?'&nbsp;('.$arItem["ELEMENT_CNT"].')':'';?></a></li>
					<?}?>
					
					<?$arSectiontmp = CIBlockSection::GetList(array(), array( "IBLOCK_ID" => $arSection["IBLOCK_ID"], "ID" => $arSection["ID"] ), false, array( "ID", "UF_SEO_TEXT"))->GetNext();?>

					<?if ($arSectiontmp["UF_SEO_TEXT"]):?>
						<li class="desc"><?=$arSectiontmp["UF_SEO_TEXT"]?></li>
					<?else:?>
						<li class="desc"><?=$arSection["DESCRIPTION"]?></li>						
					<?endif;?>
					
				</ul>
			</div>
		</div>
	<?}?>
</div>