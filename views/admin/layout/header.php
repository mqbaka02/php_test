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
            <li class="nav-item"><a href="<?= $router->url('admin_posts') ?>" class="nav-link">Posts</a></li>
            <li class="nav-item"><a href="<?= $router->url('admin_categories') ?>" class="nav-link">Categories</a></li>
            <li class="nav-item"><a href="#" class="nav-link" onclick="thingie()">Log out</a></li>
        </ul>
	</nav>
	<form action="<?= $router->url('logout') ?>" method="post" style="display:none" id="logoutform">
		<button type="submit">Log out</button>
	</form>
	<script>
		function thingie(){
			var logoutform= document.querySelector('#logoutform');
			logoutform.submit();
		}
	</script>
	<div class="container">