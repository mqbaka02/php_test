<?php
require '../vendor/autoload.php';
// define('VIEW_PATH', dirname(__DIR__) . '/views');
define('DEBUG_TIME', microtime(true));


//whoops errors
$whoops= new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if(isset($_GET['page']) && $_GET['page']== 1){
	//remove page=1 from the URL
	$uri= $_SERVER['REQUEST_URI'];
	$uri= explode('?', $uri)[0];
	$get= $_GET;
	unset($get['page']);
	$query= http_build_query($get);
	if(!empty($query)){
		$uri= $uri . '?' . $query;
	}
	http_response_code(301);
	header('Location: '. $uri);
	exit();
}

$router= new App\Router(dirname(__DIR__) . '/views');
$router
	->get('/', 'post/index', 'blog')
	->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
	->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
	->run();