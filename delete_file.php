<?
require __DIR__.'/vendor/autoload.php';
if(!empty($_POST['delete_file']))
{
    $disk = new Arhitector\Yandex\Disk($_COOKIE['token']);
    $resource = $disk->getResource($_POST['delete_file']);
    if(!empty($resource))
        $resource->delete();
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