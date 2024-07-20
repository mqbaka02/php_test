<?php
require '../vendor/autoload.php';
// define('VIEW_PATH', dirname(__DIR__) . '/views');
define('DEBUG_TIME', microtime(true));

//whoops
$whoops= new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router= new App\Router(dirname(__DIR__) . '/views');
$router
	->get('/', 'post/index', 'blog')
	->get('/blog/category', 'category/show', 'category')
	->run();