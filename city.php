<?php
    require_once('orderBy.php');

    require __DIR__.'/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
    $twig = new Twig_Environment($loader, array('debug' => true));

    $db = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');

    if (isset($_GET['orderBy']) && isset($_GET['code'])) {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population, city.CountryCode FROM city JOIN country ON city.CountryCode = country.Code
          WHERE CountryCode = ? '.orderBy::GetOrderBy($_GET['orderBy']));
        $stmt->execute([$_GET['code']]);
    }
    else if (isset($_GET['code'])) {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population, city.CountryCode FROM city JOIN country ON city.CountryCode = country.Code
          WHERE CountryCode = ?');
        $stmt->execute([$_GET['code']]);
    }
    else if (isset($_GET['orderBy'])) {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population, city.CountryCode
            FROM city JOIN country ON city.CountryCode = country.Code '.orderBy::GetOrderBy($_GET['orderBy']));
        $stmt->execute([$_GET['orderBy']]);
    }
    else {
        $stmt = $db->prepare('SELECT city.Name, country.Name AS CountryName, city.District, city.Population, city.CountryCode FROM city JOIN country ON city.CountryCode = country.Code');
        $stmt->execute();
    }

    echo $twig->render('city.twig', array('cities' => $stmt->fetchAll(),));
?>