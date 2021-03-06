<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?global $APPLICATION; $fields = CSite::GetByID(SITE_ID)->Fetch();?>
	<?IncludeTemplateLangFile(__FILE__);?>
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowMeta("viewport");?>
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>


	<link rel="icon" type="image/x-icon" href="/favicon.ico" />
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/media.css');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/colors.css');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/colors_blue.css');?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery.fancybox-1.3.4.css');?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/flexslider.css');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-1.7.1.min.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.elastislide.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jqModal.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.fancybox-1.3.4.pack.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.ui-slider.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/slides.min.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.flexslider-min.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.maskedinput-1.2.2.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.easing.1.3.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.validate.js',true)?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/general.js',true)?>
	<?$APPLICATION->AddheadString("<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,500italic,700,700italic&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>")?>
	<?$APPLICATION->ShowHead()?>

	<script>
		jQuery.extend(jQuery.validator.messages, {
			required: "<?=GetMessage('VALIDATOR_REQUIRED')?>",
			remote: "<?=GetMessage('VALIDATOR_REMOTE')?>",
			email: "<?=GetMessage('VALIDATOR_EMAIL')?>",
			url: "<?=GetMessage('VALIDATOR_URL')?>",
			date: "<?=GetMessage('VALIDATOR_DATE')?>",
			dateISO: "<?=GetMessage('VALIDATOR_DATEISO')?>",
			number: "<?=GetMessage('VALIDATOR_NUMBER')?>",
			digits: "<?=GetMessage('VALIDATOR_DIGITS')?>",
			creditcard: "<?=GetMessage('VALIDATOR_CREDITCARD')?>",
			equalTo: "<?=GetMessage('VALIDATOR_EQUALtO')?>",
			accept: "<?=GetMessage('VALIDATOR_ACCEPT')?>",
			maxlength: jQuery.validator.format("<?=GetMessage('VALIDATOR_MAXLENGTH')?>"),
			minlength: jQuery.validator.format("<?=GetMessage('VALIDATOR_MINLENGTH')?>"),
			rangelength: jQuery.validator.format("<?=GetMessage('VALIDATOR_RANGELENGTH')?>"),
			range: jQuery.validator.format("<?=GetMessage('VALIDATOR_RANGE')?>"),
			max: jQuery.validator.format("<?=GetMessage('VALIDATOR_MAX')?>"),
			min: jQuery.validator.format("<?=GetMessage('VALIDATOR_MIN')?>")
		});
	</script>
	<?if(CModule::IncludeModule("aspro.ishop")){CIShop::Start(SITE_ID);}?>
	<?$isFrontPage = CSite::InDir(SITE_DIR.'index.php');?>
	<?$isStores = CSite::InDir(SITE_DIR.'stores/');?>
	<?$isCatalog = CSite::InDir(SITE_DIR.'catalog/');?>
	<?$isContacts = CSite::InDir(SITE_DIR.'contacts/');?>
	<?$issale = CSite::InDir(SITE_DIR.'sale/index.php');?>
	<?$isAdv = CSite::InDir(SITE_DIR.'catalog/sale/') || CSite::InDir(SITE_DIR.'catalog/hit/') || CSite::InDir(SITE_DIR.'catalog/recommend/') || CSite::InDir(SITE_DIR.'catalog/new/') || CSite::InDir(SITE_DIR.'company/') || CSite::InDir(SITE_DIR.'info/') || CSite::InDir(SITE_DIR.'personal/index.php') || CSite::InDir(SITE_DIR.'personal/profile/') || CSite::InDir(SITE_DIR.'help/');?>

</head>

<body>
	<?CAjax::Init();?>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<div class="top_bg">
		<div class="top_block">
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form", "top", Array(
					"REGISTER_URL" => "/auth/",
					"FORGOT_PASSWORD_URL" => "/auth/",
					"PROFILE_URL" => "/personal/",
					"SHOW_ERRORS" => "Y"
				)
			);?>
			<div class="phone_feedback">
				<span> <?$APPLICATION->IncludeFile("/include/phone_feedback.php", Array(), Array( "MODE" => "html", "NAME" => GetMessage("PHONE"), ) );?> </span>
			</div>
			<div class="social_link">
				<?$APPLICATION->IncludeComponent("aspro:social.info", ".default", array(
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_GROUPS" => "Y",
					"VK" => COption::GetOptionString("ishop", "shopVk", "", SITE_ID),
					"FACE" => COption::GetOptionString("ishop", "shopFacebook", "", SITE_ID),
					"TWIT" => COption::GetOptionString("ishop", "shopTwitter", "", SITE_ID)
					),
					false
				);?>
			</div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"shop",
	array(
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "5",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => "/catalog/",
		"CATEGORY_0_TITLE" => GetMessage("ITEMS"),
		"CATEGORY_0" => array(
			0 => "iblock_1c_catalog",
		),
		"CATEGORY_0_iblock_aspro_ishop_catalog" => array(
			0 => "all",
		),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"COMPONENT_TEMPLATE" => "shop",
		"CATEGORY_0_iblock_1c_catalog" => array(
			0 => "15",
		)
	),
	false
);?>
			<div class="clearboth"></div>
		</div>
	</div>
	<div class="wrapper">
		<div class="header">
			<div class="logo">
				<?$APPLICATION->IncludeFile("/include/logo.php", Array(), Array( "MODE"      => "html", "NAME"      => GetMessage("LOGO"), 	) );?>
			</div>
			<div class="shop_description">
				<?$APPLICATION->IncludeFile("/include/description.php", Array(), Array( "MODE"      => "html","NAME"      => GetMessage("DESCRIPTION"), ) );?>
			</div>
			<div id="basket_small" class="basket">
				<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small-basket", array(
					"PATH_TO_BASKET" => "/basket/",
					"PATH_TO_ORDER" => "/order/"
					), false
				);?>
			</div>
			<div class="clearboth"></div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"top_menu",
	array(
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "Y",
		"ALLOW_MULTI_SELECT" => "N",
		"IBLOCK_CATALOG_TYPE" => "1c_catalog",
		"IBLOCK_CATALOG_ID" => "15",
		"IBLOCK_CATALOG_DIR" => "/catalog/",
		"COMPONENT_TEMPLATE" => "top_menu"
	),
	false
);?>
		</div>

		<div class="content <?=$isFrontPage ? 'front' : ''?>">
			<?if( $isCatalog ):?><div id="ajax_catalog"><?endif;?>

			<?if( $issale ): ?>
			<?$APPLICATION->IncludeComponent("bitrix:news.list", "front_slider", array(
				"IBLOCK_TYPE" => "aspro_ishop_content",
				"IBLOCK_ID" => "4",
				"NEWS_COUNT" => "20",
				"SORT_BY1" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(
					0 => "DETAIL_PICTURE",
					1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "LINK",
					1 => "",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "42",
				"PARENT_SECTION_CODE" => "",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "N",
				"DISPLAY_PICTURE" => "N",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"AJAX_OPTION_ADDITIONAL" => ""
				),
				false
			);?>
			<?endif;?>
			<?if( $isAdv ):?>
				<div class="container left">
					<div class="inner_left no_right_side">
			<?endif;?>

			<?if( !$isFrontPage && !$isCatalog && !$issale ):?>
				<h1 class="title"><?$APPLICATION->ShowTitle(false)?></h1>
				<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "content", Array( "START_FROM" => "0", "PATH" => "", "SITE_ID" => "" ), 	false );?>
				<div class="shadow-item_info"><img border="0" alt="" src="<?=SITE_TEMPLATE_PATH?>/img/shadow-item_info.png"></div>
			<?endif;?>

			<?if( !$isCatalog ):?>
				<div class="content_menu_mini">
					<?$APPLICATION->IncludeComponent("bitrix:menu", "inner_menu", array(
						"ROOT_MENU_TYPE" => "left",
						"MENU_CACHE_TYPE" => "A",
						"MENU_CACHE_TIME" => "33600",
						"MENU_CACHE_USE_GROUPS" => "N",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "1",
						"CHILD_MENU_TYPE" => "left",
						"USE_EXT" => "N",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N"
						),
						false,
						array(
						"ACTIVE_COMPONENT" => "Y"
						)
					);?>
				</div>
				<?if (!$isFrontPage&&!$issale&&!$isStores&&!$isContacts):?>
					<div class="left_block">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "inner_menu_vertical", array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "33600",
							"MENU_CACHE_USE_GROUPS" => "N",
							"MENU_CACHE_GET_VARS" => "",
							"MAX_LEVEL" => "1",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "N",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N" ),
							false, array( "ACTIVE_COMPONENT" => "Y" )
						);?>

						<?if( $isAdv ):?>
							<?$APPLICATION->IncludeComponent("bitrix:news.list", "advt", array(
								"DISPLAY_DATE" => "N",
								"DISPLAY_NAME" => "N",
								"DISPLAY_PICTURE" => "N",
								"DISPLAY_PREVIEW_TEXT" => "N",
								"AJAX_MODE" => "N",
								"IBLOCK_TYPE" => "aspro_ishop_content",
								"IBLOCK_ID" => "4",
								"NEWS_COUNT" => "20",
								"SORT_BY1" => "ACTIVE_FROM",
								"SORT_ORDER1" => "DESC",
								"SORT_BY2" => "SORT",
								"SORT_ORDER2" => "ASC",
								"FILTER_NAME" => "",
								"FIELD_CODE" => array( 0 => "DETAIL_PICTURE", ),
								"PROPERTY_CODE" => array( 0 => "LINK", ),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"PREVIEW_TRUNCATE_LEN" => "",
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"SET_TITLE" => "N",
								"SET_STATUS_404" => "N",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"PARENT_SECTION" => "40",
								"PARENT_SECTION_CODE" => "",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "3600",
								"CACHE_FILTER" => "N",
								"CACHE_GROUPS" => "Y",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "N",
								"PAGER_TITLE" => "",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_TEMPLATE" => "",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N"
								),
								false, array( "ACTIVE_COMPONENT" => "Y" )
							);?>
						<?endif;?>
					</div>
				<?endif;?>
			<?endif;?>



	<?if( $isCatalog && $_REQUEST["mode"] == "ajax" ){ $APPLICATION->RestartBuffer();}?>
