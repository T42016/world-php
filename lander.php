<?php
	require __DIR__ . '/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ .'/templates');
	$twig = new Twig_Environment($loader, array('cache' => __DIR__ .'/cache', 'debug' => true));

	$pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
	if(isset($_GET['c']))
	{
		$stmt = $pdo->prepare('SELECT * FROM country WHERE Continent = ? ORDER BY Population DESC');
		$stmt->execute([$_GET['c']]);
	}
	else 
	{
		$stmt = $pdo->prepare('SELECT * FROM country ORDER BY Population DESC');
		$stmt->execute();
	}
	/*try {
		}
	} catch(PDOException $ex) {
		//handle me.
		echo "ERROR!";
	}*/

	echo $twig->render('country.twig', array('countrys' => $stmt->fetchAll(),));
?>