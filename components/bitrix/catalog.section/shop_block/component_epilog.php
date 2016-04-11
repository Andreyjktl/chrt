<?
global $NavNum;
if($_REQUEST["SHOWALL_".$NavNum] == 1){
	?><style type="text/css">.drop_number{display:none !important;}</style><?
}

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $SectionPageProperties;
foreach($SectionPageProperties as $code => $value ) { if ($value) { $APPLICATION->SetPageProperty($code, $value); }}
?>