<?php
	require __DIR__ . '/../vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
	$twig = new Twig_Environment($loader,array('debug' => true));
			
	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
			
	if (isset($_GET['countrycode'])) 
	{
		$stmt = $pdo->prepare('SELECT language, countrycode FROM countrylanguage WHERE countrycode = ?');
		$stmt->execute([$_GET['countrycode']]);
	}
	else
	{
		$stmt = $pdo->prepare('SELECT language, countrycode FROM countrylanguage');
		$stmt->execute();
	}
			
	echo $twig->render('languages.twig',array('languages' => $stmt->fetchAll(),));
?>
	