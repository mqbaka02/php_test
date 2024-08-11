<?php
use App\Connection;
require dirname(__DIR__) . '/vendor/autoload.php';

$faker= Faker\Factory::create('en_US');

$pdo= Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');

$posts= [];
$categories= [];

// echo($faker->word);
// exit();

function create_phrase(\Faker\Generator $the_faker, int $number_of): string{
	$out_put= ucfirst($the_faker->word);
	for ($i= 0; $i< ($number_of - 1); $i++){
		$out_put.= " " . $the_faker->word;
	}
	return $out_put . ".";
}

function create_slug(\Faker\Generator $the_faker, int $number_of){
	$out_put= $the_faker->word;
	for ($i= 0; $i< ($number_of - 1); $i++){
		$out_put.= "-" . $the_faker->word;
	}
	return $out_put;
}

function create_paragraph(\Faker\Generator $the_faker, int $number_of){
	$out_put= create_phrase($the_faker, rand(3, 7));
	for ($i= 0; $i< ($number_of - 1); $i++){
		$out_put.= " " . create_phrase($the_faker, rand(3, 7));
	}
	return $out_put;
}

for ($i= 0; $i< 50; $i++){
	$pdo->exec("INSERT INTO post SET name='{$faker->name()}', slug='" . create_slug($faker, 4) . "', created_at='{$faker->iso8601}', content='" . create_paragraph($faker, rand(4, 8)) ."'");
	$posts[]= $pdo->lastInsertId();
	// echo("INSERT INTO post SET name='{$faker->name()}', slug='" . create_slug($faker, 4) . "', created_at='{$faker->iso8601}', content='" . create_paragraph($faker, rand(4, 8)) ."'");
	// exit();
}

for($i= 0; $i< 5; $i++){
	$pdo->exec("INSERT INTO category SET name='{$faker->name(3)}', slug='" . create_slug($faker, 4) . "'");
	$categories[]= $pdo->lastInsertId();
}

foreach ($posts as $post) {
	$random_categories= $faker->randomElements($categories, rand(0, count($categories)));
	// echo($random_categories);
	foreach ($random_categories as $cat) {
		$pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$cat");
	}
}

$pass= password_hash('admin', PASSWORD_BCRYPT);

$pdo->exec("INSERT INTO user SET username='admin', password='$pass'");