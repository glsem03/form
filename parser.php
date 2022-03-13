<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
$el = new CIBlockElement;
$PROP = array();
$block_id = 4;
$file_path = "../parser/test.csv";
$file_res = [];
if (($fp = fopen($file_path, "r")) !== FALSE) {
	while (($data = fgetcsv($fp, filesize($file_path), ",")) !== FALSE) {
		$file_res[] = $data;
	}
	fclose($fp);
}
for($i = 1; $i <= count($file_res); $i++)
{
	$PROP["NAME"] = $file_res[$i][1];
	$PROP["FNAME"] = $file_res[$i][2];
	$PROP["AGE"] = $file_res[$i][3];
	$PROP["STREET"] = $file_res[$i][4];
	$PROP["CITY"] = $file_res[$i][5];
	$PROP["STATE"] = $file_res[$i][6];
	$PROP["ZIP"] = $file_res[$i][7];
	$PROP["SALARY"] = $file_res[$i][8];
	$PROP["PIC"] = $file_res[$i][9];
	$arLoadArray = [
		"MODIFED_BY" => $USER->GetId(),
		"IBLOCK_ID" => $block_id,
		"IBLOCK_SECTION_ID" => false,
		"PROPERTY_VALUES" => $PROP,
		"NAME" => "test",
		"ACTIVE" => "Y"
	];
	if ($PRODUCT_ID = $el->Add($arLoadArray)) {
		echo "Добавлен элемент с ID : " . $PRODUCT_ID . "<br>";
	} else {
		echo "Error: " . $el->LAST_ERROR . '<br>';
	}
}
?>