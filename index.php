<?php
	require __DIR__ . '/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader,array('debug' => true));
			
	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
			
	if (isset($_GET['code'])) 
	{
		$stmt = $pdo->prepare('SELECT * FROM city WHERE countrycode = ?');
		$stmt->execute([$_GET['code']]);
	}
	else
	{
		$stmt = $pdo->prepare('SELECT * FROM city');
		$stmt->execute();
	}
			
	echo $twig->render('index.twig',array('cities' => $stmt->fetchAll(),));
?>
	