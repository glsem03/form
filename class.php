<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class testComponent extends CBitrixComponent
{
    public function getIBlockData($arParams)
    {
        CModule::IncludeModule("iblock");
        $res = array();
        if(empty($arParams['IBLOCK_ID']))
            $ib = CIBlockElement::GetList(array("iblock_id" => "asc"), array("IBLOCK_TYPE" => $this->arParams['IBLOCK_TYPE']));
        else
            $ib = CIBlockElement::GetList(array("iblock_id" => "asc"), array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "IBLOCK_TYPE" => $this->arParams['IBLOCK_TYPE']));
        while($el = $ib->GetNext())
        {
            if(empty($res[$el['IBLOCK_ID']]))
                $res[$el['IBLOCK_ID']] = array($el['ID'] => $el);
            else
                $res[$el['IBLOCK_ID']][$el['ID']] = $el;

        }
        $arResult["ITEMS"] = $res;
        return $arResult;
    }
    public function executeComponent()
    {
        $this->arResult = array_merge($this->arResult, $this->getIBlockData($this->arParams));
        $this->includeComponentTemplate();
    }
}
?>