<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$count = 0;
	$summ = 0;
	$currency = '';
	$itemsCount = 0;
	foreach( $arResult["ITEMS"] as $arItem )
	{
		if( $arItem["DELAY"] == 'N' )
		{
			$count++;
			$summ += $arItem["PRICE"]*$arItem["QUANTITY"];
			$currency = $arItem["CURRENCY"];
			$itemsCount++;
		}
	}
?>
<div class="basket-large">
	<form action="<?=$arParams["PATH_TO_ORDER"]?>" method="post" name="basket_form">
		<div class="counter">
			<div>
				<!--noindex-->
					<a rel="nofollow" id="popup_basket" class="popup_basket" href="<?=$arParams["PATH_TO_BASKET"]?>">
						<?if ($itemsCount):?><?=GetMessage('TOVAROV')?> <?=$count?>
						<?else:?><?=GetMessage("BASKET");?><?endif;?>
					</a>
				<!--/noindex-->
			</div>
			<div>
				<?if ($itemsCount):?><?=GetMessage('SUMM')?> <?=SaleFormatCurrency($summ, $currency);?>
				<?else:?><?=GetMessage("BASKET_EMPTY");?><?endif;?>
			</div>
		</div>
		<!--noindex-->
			<a rel="nofollow" href="<?=$arParams["PATH_TO_BASKET"]?>" class="button" type="submit" value="ќформить заказ" name="BasketOrder" id="basketOrderButton2"><span><?=GetMessage("BASKET_LINK");?></span></a>
		<!--/noindex-->
	</form>
</div>
<div class="basket-small">
	<!--noindex-->
		<a rel="nofollow" href="<?=$arParams["PATH_TO_BASKET"]?>"><?=GetMessage('BASKET')?></a> +<?=$count?>
	<!--/noindex-->
</div>