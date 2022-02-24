<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?>
<?if ($arResult["isFormNote"] != "Y")
{
?>

<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований
        </div>
    </div>
	<?=str_replace('<form','<form class="contact-form__form"',$arResult['FORM_HEADER']);?>
	<div class="contact-form__form-inputs">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
		?>
			<?if($arQuestion['CAPTION'] != 'Сообщение'):?>
			<div class="input contact-form__input">
				<label class="input__label">
                	<div class="input__label-text">
						<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?if($arResult["REQUIRED_SIGN"]) echo '*';?><?endif;?>
					</div>
                	<?echo str_replace('<input','<input class="input__input"',$arQuestion['HTML_CODE']);?>
                	<div class="input__notification">
						Поле должно содержать не менее 3-х символов
					</div>
            	</label>
			</div>
			<?endif;?>
			<?continue;?>
	<?
		}
	} //endwhile
	?>
	</div>

	<div class="contact-form__form-message">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
		?>
			<?if($arQuestion['CAPTION'] == 'Сообщение'):?>
			<div class="input">
				<label class="input__label">
                	<div class="input__label-text">
						<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?if($arResult["REQUIRED_SIGN"]) echo '*';?><?endif;?>
					</div>
                	<?echo str_replace('<textarea','<textarea class="input__input"',$arQuestion['HTML_CODE']);?>
                	<div class="input__notification">
						Поле должно содержать не менее 3-х символов
					</div>
            	</label>
			</div>
			<?endif;?>
			<?continue;?>
	<?
		}
	} //endwhile
	?>
	</div>
	
	<div class="contact-form__bottom">
        <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
            ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
            данных&raquo;.
         </div>
		<input class="form-button contact-form__bottom-button" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Оставить заявку" />
    </div>

</div>

<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
	<?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
	<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
	<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
	<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
<?
} // isUseCaptcha
?>
</form>
<?=$arResult["FORM_FOOTER"]?>
<?
}
