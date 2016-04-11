<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div>
	<div class="title"><?=GetMessage('FORM_HEADER_CAPTION')?></div>
	<a class="jqmClose close"><i></i></a>
	<div class="form-wr">
		<form method="post" id="one_click_buy_form" action="<?=$arResult['SCRIPT_PATH']?>/script.php">
			<?foreach($arParams['PROPERTIES'] as $field):?>	
				<div class="r">
					<label class="description">
						<?=GetMessage('CAPTION_'.$field)?>
						<?if (in_array($field, $arParams['REQUIRED'])):?><span class="starrequired">*</span><?endif;?>
					</label>
					<?if($field=="COMMENT"):?>
						<textarea name="ONE_CLICK_BUY[<?=$field?>]" id="one_click_buy_id_<?=$field?>"></textarea>
					<?else:?>
						<input type="text" name="ONE_CLICK_BUY[<?=$field?>]" value="<?=$value?>" id="one_click_buy_id_<?=$field?>" />
					<?endif;?>
				</div>
			<?endforeach;?>
			<?if($arParams['USE_SKU']=="Y"):?>
				<input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID']?>" />
				<input type="hidden" name="USE_SKU" value="Y" />
				<input type="hidden" name="SKU_CODES" value="<?=$arResult['SKU_PROPERTIES_STRING']?>" />
				<label><?=GetMessage('CAPTION_SKU_SELECT')?></label>
				<select name="ELEMENT_ID">
					<?foreach($arResult['OFFERS'] as $id => $offer_data):?>
						<option value="<?=$id?>"><?=$offer_data?></option>
					<?endforeach;?>
				</select>
			<?endif;?>
			<div class="but-r clearfix">
				<!--noindex-->
					<button class="button" type="submit" id="one_click_buy_form_button" name="one_click_buy_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>"><span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span></button>
					<div class="promt"><span class="starrequired">*</span> &mdash; <?=GetMessage("IBLOCK_FORM_IMPORTANT");?></div>
				<!--/noindex-->
			</div>
			<?if($arParams['USE_SKU']!="Y"):?>
				<input type="hidden" name="ELEMENT_ID" value="<?=$arParams['ELEMENT_ID']?>" />
			<?endif;?>
			<?if($arParams['BUY_ALL_BASKET']=="Y"):?>
				<input type="hidden" name="BUY_TYPE" value="ALL" />
			<?endif;?>
			<?if(intVal($arParams['ELEMENT_QUANTITY'])):?>
				<input type="hidden" name="ELEMENT_QUANTITY" value="<?=intVal($arParams['ELEMENT_QUANTITY']);?>" />
			<?endif;?>
			<input type="hidden" name="CURRENCY" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
			<input type="hidden" name="SITE_ID" value="<?=SITE_ID;?>" />
			<input type="hidden" name="PROPERTIES" value='<?=serialize(array_merge($arParams['PROPERTIES'], array("EMAIL", "LOCATION")))?>' />
			<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
			<input type="hidden" name="DELIVERY_ID" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
			<input type="hidden" name="PERSON_TYPE_ID" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
			<?if($_REQUEST['OFFER_PROPS']){
				$arSkuProps=explode(";", $_REQUEST['OFFER_PROPS']);
				?>
				<input type="hidden" name="OFFER_PROPS" value='<?=serialize($arSkuProps);?>' />
			<?}?>
			<input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID']?>" />
			<?=bitrix_sessid_post()?>	
		</form>
		<div class="one_click_buy_result" id="one_click_buy_result">
			<div class="one_click_buy_result_success"><?=GetMessage('ORDER_SUCCESS')?></div>
			<div class="one_click_buy_result_fail"><?=GetMessage('ORDER_ERROR')?></div>
			<div class="one_click_buy_result_text"><?=GetMessage('ORDER_SUCCESS_TEXT')?></div>
			<?if($arParams['BUY_ALL_BASKET']=="Y"):?>
				<div class="buy_type_field"></div>
			<?endif;?>
		</div>
	</div>
</div>
<script type="text/javascript">
$('#one_click_buy_form').validate({
	rules: {
	"ONE_CLICK_BUY[EMAIL]": {email : true},
		<?
		foreach($arParams['REQUIRED'] as $key => $value){
			echo '"ONE_CLICK_BUY['.$value.']": {required : true}';
			if($arParams['REQUIRED'][$key + 1]){
				echo ',';
			}
		}
		?>
	} 
});
$('.popup').jqmAddClose('.jqmClose');
<?if(trim(COption::GetOptionString("aspro.ishop", "PHONE_MASK", "+9 (999) 999-99-99", SITE_ID))){?>
	$('#one_click_buy_id_PHONE').mask('<?=trim(COption::GetOptionString("aspro.ishop", "PHONE_MASK", "+9 (999) 999-99-99", SITE_ID));?>');
<?}?>
</script>