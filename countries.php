<?php
	require __DIR__ .'/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ .'/templates');
	$twig = new Twig_Environment($loader, array('debug' => true,));
    $pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
	
   
    if(isset($_GET['continent']))
    {
        $stmt = $pdo->prepare('SELECT Name,Continent,Population FROM country WHERE Continent = ? ORDER BY Population DESC');
        $stmt->execute([$_GET['continent']]);
    }
	else if(isset($_GET['sort']))
	{
		$sort = $_GET['sort'];
		$stmt = $pdo->prepare('SELECT Name,Continent,Population FROM country Order BY '.$sort);
		$stmt->execute([$_GET['sort']]);
	}
    else
    {
        $stmt = $pdo->prepare('SELECT * FROM country Order BY Population DESC');
        $stmt->execute();
    }
	
	
    
	
	
	echo $twig->render('countries.twig', array('countries' => $stmt->fetchAll(),));
?>