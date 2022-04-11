<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Главная</title>
</head>
<body>
<div class="main">
<?
require __DIR__.'/vendor/autoload.php';
$data['access_token'] = null;
if (!empty($_GET['code'])) {
	// Отправляем код для получения токена (POST-запрос).
	$params = array(
		'grant_type'    => 'authorization_code',
		'code'          => $_GET['code'],
		'client_id'     => '9ab6a75321f1449d9b2847da268d2d42',
		'client_secret' => '2c8fdd608a8b41ae9c0400a756beb7f3',
	);
	
	$ch = curl_init('https://oauth.yandex.ru/token');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data, true);
    if($data["error_description"] == "Code has expired")
    {
        $params = array(
	    'client_id'     => '9ab6a75321f1449d9b2847da268d2d42',
	    'redirect_uri'  => 'http://test.local/main.php',
	    'response_type' => 'code',
	    'state'         => '123'
        );
 
        $url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));
        header("Location: ".$url); 
        exit();
    }
    $_SESSION['token'] = $data['access_token'];
    setcookie("token", $data['access_token'], time()+36000, "/",'test.local');    
	if (!empty($data['access_token'])) {
		//Получение данных пользователя.
		$ch = curl_init('https://login.yandex.ru/info');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json')); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $_SESSION['token']));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$info = curl_exec($ch);
		curl_close($ch);
 
		$info = json_decode($info, true);
        echo '<div class="main__header">
                <div class="main__picture">
                    <img class="main__img" src="https://avatars.yandex.net/get-yapic/'.$info['default_avatar_id'].'/islands-retina-50"/>
                </div>
                <div class="main__info">
                    <p class="main__info_text main__info_name">Имя: '.$info['first_name'].'</p>
                    <p class="main__info_text main__info_fname">Фамилия: '.$info['last_name'].'</p>
                    <p class="main__info_text main__info_mail">Почта: '.$info['default_email'].'</p>
                </div>
            </div>
            <div class="main__forms">
                <form method="POST" action="add_file.php" enctype="multipart/form-data">
                    <input class="btn" id="fileupload" name="inputfile" type="file" />
                    <input class="btn" type="submit" value="Загрузить" id="submit_add" />
                </form>
                <form method="POST" action="delete_file.php">
                    <input id="delete_file" name="delete_file" placeholder="Название файла..." type="text"/>
                    <input class="btn" type="submit" value="Удалить" id="submit_delete" />
                </form>
            </div>';        
        $disk = new Arhitector\Yandex\Disk($data['access_token']);
        $collection = $disk->getResources(999)->toArray();
        $resource = $disk->getResource('include.php');
        echo '<ul class="main__list">';
        foreach($collection as $key => $value)
        {
            echo '<li class="main__list_item">
                    <a href="'.$value->toArray()['docviewer'].'" class="main__list_link">'.$value->toArray()['name'].'</a>
                    <p class="main__list_text">Дата создания: '.date('d.m.Y H:i:s', strtotime($value->toArray()['created'])).'</p>
                    <p class="main__list_text">Дата изменения: '.date('d.m.Y H:i:s', strtotime($value->toArray()['modified'])).'</p>
                </li>';
        }
        echo '</ul>';
	}
}
?>
</div>
</body>
</html>