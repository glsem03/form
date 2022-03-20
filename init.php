<?
use App;
CModule::IncludeModule('iblock');
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("EventHandlers", "AddElemLog"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("EventHandlers", "UpdateElemLog"));

class EventHandlers
{
    public static function AddElemLog(array $arFields) : bool
    {
        $addBlock = CIBlock::GetByID($arFields['IBLOCK_ID'])->GetNext();
        if($addBlock['NAME'] != 'log')
        {
            $logBlock = CIBlock::GetList(array(), array('NAME' => 'log'))->GetNext();
            $logSections = CIBlockSection::GetTreeList(array('IBLOCK_ID' => $logBlock['ID']), array());
            $newLogEl = new CIBlockElement;
            $isSectionExist = false;
            //проверка на наличие раздела в инфоблоке log
            while($section = $logSections->GetNext())
            {
                if($section['NAME'] == $addBlock['NAME'])
                {
                    $isSectionExist = true;
                    break;
                }
            } 
            if($isSectionExist == false)
            {
                $newSection = new CIBlockSection;
                $newSection -> Add(array(
                    'IBLOCK_ID' =>  $logBlock['ID'],
                    'NAME' => $addBlock['NAME'],
                ));
            }
            //добавление элемента в инфоблок log
            $newElSection = CIBlockSection::GetTreeList(array('IBLOCK_ID' => $logBlock['ID'], 'NAME' => $addBlock['NAME']), array())->GetNext();
            $newLogEl->Add(array(
                'IBLOCK_SECTION_ID' => $newElSection['ID'],
                'IBLOCK_ID' => $logBlock['ID'],
                'NAME' => $arFields['ID'],
                'ACTIVE_FROM' => date('d.m.Y H:i:s'),
                'PREVIEW_TEXT' => $addBlock['NAME'].'->'.$newElSection['NAME'].'->'.$arFields['NAME'],
                "ACTIVE" => "Y",
            ));
        }
        return true;
    }
    public static function UpdateElemLog(array $arFields) : bool
    {
        $addBlock = CIBlock::GetByID($arFields['IBLOCK_ID'])->GetNext();
        if($addBlock['NAME'] != 'log')
        {
            $logBlock = CIBlock::GetList(array(), array('NAME' => 'log'))->GetNext();
            $updateElSection = CIBlockSection::GetTreeList(array('IBLOCK_ID' => $logBlock['ID'], 'NAME' => $addBlock['NAME']), array())->GetNext();
            $updateLogEl = new CIBlockElement;
            $updateLogID = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $addBlock['IBLOCK_ID'], 'IBLOCK_SECTION_ID' => $updateElSection['ID'],'NAME' => $arFields['ID']))->GetNext();
            $res = $updateLogEl->Update($updateLogID['ID'], [
                'IBLOCK_SECTION_ID' => $updateElSection['ID'],
                'IBLOCK_ID' => $logBlock['ID'],
                'NAME' => $arFields['ID'],
                'ACTIVE_FROM' => date('d.m.Y H:i:s'),
                'PREVIEW_TEXT' => $addBlock['NAME'].'->'.$updateElSection['NAME'].'->'.$arFields['NAME'],
                "ACTIVE" => "Y",
            ]);
        }
        return true;
    }
}

//функция удаляет все элементы инфоблока log кроме 10 самых новых
function clearOldElems()
{
    $logBlockId = CIBlock::GetList(array(), array('NAME' => 'log'))->GetNext()['ID'];
    $logBlockElements = CIBlockElement::GetList(array("active_from" => 'asc'), array('IBLOCK_ID'=>$logBlockId));
    $delRowsCount = $logBlockElements->SelectedRowsCount() - 10;
    while($el = $logBlockElements->Fetch())
    {
        if($delRowsCount > 0)
        {
            CIBlockElement::Delete($el['ID']);
            $delRowsCount--;
        }
    }
}
?>