<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Авторизация</title>
</head>
<body>
<div class="authorization">
<?
session_start();
$params = array(
	'client_id'     => '9ab6a75321f1449d9b2847da268d2d42',
	'redirect_uri'  => 'http://test.local/main.php',
	'response_type' => 'code',
	'state'         => '123'
);
 
$url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));
echo '<a class="authorization__link" href="' . $url . '">Авторизация через Яндекс</a>';
?>
</div>
</body>
</html>