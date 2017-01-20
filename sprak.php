<?php

require __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, array('cache' => __DIR__ .'/cache', debug => true));

	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
	
	if(isset($_GET['code']))
	{
		$stmt = $pdo->prepare('SELECT * FROM countrylanguage WHERE CountryCode = ?');
		$stmt->execute([$_GET['code']]);
	}
	else 
	{
		$stmt = $pdo->prepare('SELECT * FROM countrylanguage');
		$stmt->execute();
	}
	/*try {
		foreach($stmt->fetchAll() as $row) {
			echo $row['Name'].' '.$row['Population'].'<br/>'; 
		}
	} catch(PDOException $ex) {
		//handle me.
		echo "ERROR!";
	}*/
	
	echo $twig->render('sprak.twig', array('language' => $stmt->fetchAll(),));

?>