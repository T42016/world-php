<?php
    require __DIR__.'/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
    $twig = new Twig_Environment($loader, array('debug' => true));

    $db = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');

    if (isset($_GET["code"])) {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population FROM city JOIN country ON city.CountryCode = country.Code WHERE CountryCode = ?');
        $stmt->execute([$_GET['code']]);
    }
    else {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population FROM city JOIN country ON city.CountryCode = country.Code');
        $stmt->execute();
    }

    echo $twig->render('city.twig', array('cities' => $stmt->fetchAll(),));
?>