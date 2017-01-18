<?php
	require __DIR__ . '/../vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
	$twig = new Twig_Environment($loader,array('debug' => true));
			
	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
			
	if (isset($_GET['countrycode'])) 
	{
		$stmt = $pdo->prepare('SELECT * FROM city WHERE countrycode = ? ORDER BY population DESC');
		$stmt->execute([$_GET['countrycode']]);
	}
	else
	{
		$stmt = $pdo->prepare('SELECT * FROM city ORDER BY population DESC');
		$stmt->execute();
	}
			
	echo $twig->render('cities.twig',array('cities' => $stmt->fetchAll(),));
?>
	