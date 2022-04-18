<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Главная");
?><?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"",
	Array(
		"FORGOT_PASSWORD_URL" => "/forget.php",
		"PROFILE_URL" => "/profile.php",
		"REGISTER_URL" => "/registration.php",
		"SHOW_ERRORS" => "N"
	)
);?><br><?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>