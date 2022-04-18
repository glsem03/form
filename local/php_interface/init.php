<?
AddEventHandler("main", "OnBeforeUserLogin", array("CCustomHookEvent", "DoBeforeUserLoginHandler"));
class CCustomHookEvent {
        //  Проверяем пришел ли телефон или login и если телефон авторизуем по нему
        function DoBeforeUserLoginHandler( &$arFields )
        {
            $userLogin = $_POST["USER_LOGIN"];
            if (isset($userLogin))
            {
                $isPhone = strpos($userLogin,"+");
                if($isPhone == 0)
                {
                  $arFilter = Array("PERSONAL_PHONE"=>$userLogin);
                  $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $arFilter);
                  if($res = $rsUsers->Fetch())
                  {
                      if($res["PERSONAL_PHONE"]==$arFields["LOGIN"])
                          $arFields["LOGIN"] = $res["LOGIN"];
                  }
                }
            }
        }
}
?>