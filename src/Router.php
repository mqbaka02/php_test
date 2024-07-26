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

	public function __construct(string $view_path) {
		$this->view_path= $view_path;
		$this->router= new \AltoRouter();
	}

	public function get(string $url, string $view, ?string $name= null) {
		$this->router->map('GET', $url, $view, $name);
		return $this;
	}

	public function url(?string $name, array $params=[]) {
		// dd($params);
		// var_dump2(['id'=>38, 'slug'=>"some-slug"]);
		// var_dump2($name);
		// dd($this->router->generate($name, $params));
		// exit();
		return $this->router->generate($name, $params);
	}

	public function run() {
		$match= $this->router->match();
		// dd($this->router);
		// dd($this->router->match());
		// var_dump($match);
		$view= $match['target'];
		$params= $match['params'];
		// dd($view);
		$router= $this;
		ob_start();
		require $this->view_path . DIRECTORY_SEPARATOR . $view . '.php';
		$content= ob_get_clean();
		require $this->view_path . DIRECTORY_SEPARATOR . 'layout/default.php';
		return $this;
	}
}

function var_dump2($somevar){
	echo '<pre>';
	var_dump($somevar);
	echo '</pre>';
}