<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult)) return "";
	
$strReturn = '';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	if($index > 0) $strReturn .= '<span>&rarr;</span>';
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($index <= count($arResult)-1) $strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>';
}

$strReturn .= '<span>&rarr;</span>';
return $strReturn;
?>
