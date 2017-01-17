<?php
    require_once('orderBy.php');

    require __DIR__.'/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
    $twig = new Twig_Environment($loader, array('debug' => true));

    $db = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');

    if (isset($_GET['orderBy']) && isset($_GET['continent'])) {
        $stmt = $db->prepare('SELECT country.Name, country.Code, country.Continent, country.Region, city.Name AS Capital, country.SurfaceArea, country.Population
            FROM country JOIN city ON country.Capital = city.ID WHERE Continent = ?'.orderBy::GetOrderBy($_GET['orderBy']));
        $stmt->execute([$_GET['continent']]);
    }
    else if (isset($_GET['continent'])) {
        $stmt = $db->prepare('SELECT country.Name, country.Code, country.Continent, country.Region, city.Name AS Capital, country.SurfaceArea, country.Population
            FROM country JOIN city ON country.Capital = city.ID WHERE Continent = ?');
        $stmt->execute([$_GET['continent']]);
    }
    else if (isset($_GET['orderBy'])) {
        $stmt = $db->prepare('SELECT country.Name, country.Code, country.Continent, country.Region, city.Name AS Capital, country.SurfaceArea, country.Population
            FROM country JOIN city ON country.Capital = city.ID '.orderBy::GetOrderBy($_GET['orderBy']));
        $stmt->execute([$_GET['orderBy']]);
    }
    else {
        $stmt = $db->prepare('SELECT country.Name, country.Code, country.Continent, country.Region, city.Name AS Capital, country.SurfaceArea, country.Population
            FROM country JOIN city ON country.Capital = city.ID');
        $stmt->execute();
    }

    echo $twig->render('country.twig', array('countries' => $stmt->fetchAll(),));
?>