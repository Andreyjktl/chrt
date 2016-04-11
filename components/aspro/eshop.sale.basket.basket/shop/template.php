<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (StrLen($arResult["ERROR_MESSAGE"])<=0)
{
	$arUrlTempl = Array(
		"delete" => $APPLICATION->GetCurPage()."?action=delete&id=#ID#",
		"shelve" => $APPLICATION->GetCurPage()."?action=shelve&id=#ID#",
		"add" => $APPLICATION->GetCurPage()."?action=add&id=#ID#",
	);
	?>
	<script>
	function ShowBasketItems(val)
	{
		if(val == 2)
		{
			if(document.getElementById("id-cart-list"))
				document.getElementById("id-cart-list").style.display = 'none';
			if(document.getElementById("id-shelve-list"))
				document.getElementById("id-shelve-list").style.display = 'block';
			if(document.getElementById("id-subscribe-list"))
				document.getElementById("id-subscribe-list").style.display = 'none';
			if(document.getElementById("id-na-list"))
				document.getElementById("id-na-list").style.display = 'none';
		}
		else if(val == 3)
		{
			if(document.getElementById("id-cart-list"))
				document.getElementById("id-cart-list").style.display = 'none';
			if(document.getElementById("id-shelve-list"))
				document.getElementById("id-shelve-list").style.display = 'none';
			if(document.getElementById("id-subscribe-list"))
				document.getElementById("id-subscribe-list").style.display = 'block';
			if(document.getElementById("id-na-list"))
				document.getElementById("id-na-list").style.display = 'none';
		}
		else if (val == 4)
		{
			if(document.getElementById("id-cart-list"))
				document.getElementById("id-cart-list").style.display = 'none';
			if(document.getElementById("id-shelve-list"))
				document.getElementById("id-shelve-list").style.display = 'none';
			if(document.getElementById("id-subscribe-list"))
				document.getElementById("id-subscribe-list").style.display = 'none';
			if(document.getElementById("id-na-list"))
				document.getElementById("id-na-list").style.display = 'block';
		}
		else
		{
			if(document.getElementById("id-cart-list"))
				document.getElementById("id-cart-list").style.display = 'block';
			if(document.getElementById("id-shelve-list"))
				document.getElementById("id-shelve-list").style.display = 'none';
			if(document.getElementById("id-subscribe-list"))
				document.getElementById("id-subscribe-list").style.display = 'none';
			if(document.getElementById("id-na-list"))
				document.getElementById("id-na-list").style.display = 'none';
		}
	}
	</script>
	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form">
		<input id="cur_page" type="hidden" name="CUR_PAGE" value='<?=$APPLICATION->GetCurPage()?>' />
		<?
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribe.php");
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_notavail.php");
		?>
	</form>
<?}else{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
}?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.link_block.remove_all_basket').click(function(e){
			if(!$(this).hasClass('disabled')){
				$(this).addClass('disabled');

				delete_all_items($(this).data("type"), $(".tabs_content li:eq("+$(this).index()+")").attr("item-section"), 350, $(this).data('href'));
			}
			$(this).removeClass('disabled');
		})
		function delete_all_items(type, item_section, correctSpeed, url){
			$.post( arIShopOptions['SITE_DIR']+"ajax/action_basket.php", "TYPE="+type+"&CLEAR_ALL=Y", $.proxy(function( data ){		
				// basketAjaxReload();
				basketReload();
			}));
		}

		function basketReload() {
			location.reload();
		}

		function basketAjaxReload() {
			if(!$('input[name="COUPON"]').val()){
				$('input[name="COUPON"]').attr('name', 'tmp_COUPON');
			}

			$.post( $('#cur_page').val(), $("form[name^=basket_form]").serialize(), $.proxy(function( data){	
				$("#basket-replace").html(data);
			}));
		}
	})
</script>
