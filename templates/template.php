<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?foreach($arResult["ITEMS"] as $key => $value):?>
        <?foreach($value as $k => $v):?>
            <p>
                <?=$v["NAME"]?>
            </p>
        <?endforeach;?>
<?endforeach;?>

