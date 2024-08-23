<?php
namespace App;
require '../vendor/autoload.php';

class Router {

	/**
	 * @var string
	 */
	private $view_path;

	/**
	 * @var AltoRouter
	 */
	private $router;

	public $layout= "layout/default";

	public function __construct(string $view_path) {
		$this->view_path= $view_path;
		$this->router= new \AltoRouter();
	}

	public function get(string $url, string $view, ?string $name= null) {
		$this->router->map('GET', $url, $view, $name);
		return $this;
	}
	public function post(string $url, string $view, ?string $name= null) {
		$this->router->map('POST', $url, $view, $name);
		return $this;
	}
	public function match(string $url, string $view, ?string $name= null) {
		$this->router->map('POST|GET', $url, $view, $name);
		return $this;
	}

	public function url(?string $name, array $params=[]) {
		return $this->router->generate($name, $params);
	}

	public function run() {
		$match= $this->router->match();
		$view= $match['target'];
		$params= $match['params'];
		$router= $this;
		$isAdmin= strpos($view, 'admin')!== false;
		$this->layout= $isAdmin? "admin/layout/default" : "layout/default";
		ob_start();
		require $this->view_path . DIRECTORY_SEPARATOR . $view . '.php';
		$content= ob_get_clean();
		require $this->view_path . DIRECTORY_SEPARATOR . $this->layout . '.php';
		return $this;
	}
}

function var_dump2($somevar){
	echo '<pre>';
	var_dump($somevar);
	echo '</pre>';
}