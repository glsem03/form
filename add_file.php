<?
require __DIR__.'/vendor/autoload.php';
if(isset($_FILES) && $_FILES['inputfile']['error'] == 0){ // Проверяем, загрузил ли пользователь файл
$destiation_dir = dirname(__FILE__) .'/'.$_FILES['inputfile']['name']; // Директория для размещения файла
move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
$disk = new Arhitector\Yandex\Disk($_COOKIE['token']);
$resource = $disk->getResource($_FILES['inputfile']['name']);
if(empty($resource))
    $resource->upload(__DIR__.'/'.$_FILES['inputfile']['name']);
else
    $resource->upload(__DIR__.'/'.$_FILES['inputfile']['name'], true);

unlink($_FILES['inputfile']['name']);
}

$params = array(
    'client_id'     => '9ab6a75321f1449d9b2847da268d2d42',
    'redirect_uri'  => 'http://test.local/main.php',
    'response_type' => 'code',
    'state'         => '123'
);
     
$url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));
header("Location: ".$url); 
exit();
?>