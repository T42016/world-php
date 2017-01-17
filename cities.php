<?php
	require __DIR__ .'/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ .'/templates');
	$twig = new Twig_Environment($loader, array('debug' => true,));
    $pdo = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');
	
	
	
   
   
    if(isset($_GET['code']))
    {
		$code = $_GET['code'];
        $stmt = $pdo->prepare('SELECT Name,CountryCode,Population FROM city WHERE CountryCode = ?');
        $stmt->execute([$_GET['code']]);
    }
	else if(isset($_GET['sort']))
	{
		$sort = $_GET['sort'];
		$stmt = $pdo->prepare('SELECT Name,CountryCode,Population FROM city Order BY '.$sort);
		$stmt->execute([$_GET['sort']]);
	}
    else
    {
        $stmt = $pdo->prepare('SELECT * FROM city');
        $stmt->execute();
    }
	
	
	echo $twig->render('cities.twig', array('countries' => $stmt->fetchAll(),));
?>