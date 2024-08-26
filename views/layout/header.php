<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/styles/style.css">
	<title><?= isset($title) ? htmlentities($title) : "No title page" ?></title>
</head>
	<style type="text/css">
	</style>
<body>
	<nav class="pd20 xt lg bg-prm">
		<a href="/" class="nav-brand">The Site</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="<?= $router->url('admin_posts') ?>" class="nav-link">Admin</a></li>
        </ul>
	</nav>
	<div class="container">