<?php
	require __DIR__ . '/../vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
	$twig = new Twig_Environment($loader,array('debug' => true));
			
	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
			
	if (isset($_GET['continent'])) 
	{
		$stmt = $pdo->prepare('SELECT * FROM country JOIN countrylanguage ON (country.code = countrylanguage.countrycode) WHERE continent = ? AND isofficial = "T" ORDER BY population DESC');
		$stmt->execute([$_GET['continent']]);
	}
	else
	{
		$stmt = $pdo->prepare('SELECT * FROM country JOIN countrylanguage ON (country.code = countrylanguage.countrycode) WHERE isofficial = "T" ORDER BY population DESC');
		$stmt->execute();
	}
			
	echo $twig->render('countries.twig',array('countries' => $stmt->fetchAll(),));
?>
	