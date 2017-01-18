<?php
    require_once('orderBy.php');

    require __DIR__.'/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
    $twig = new Twig_Environment($loader, array('debug' => true));

    $db = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');

    if (isset($_GET['limit']) && isset($_GET['orderBy'])) {
        $stmt = $db->prepare('SELECT Language, ROUND(SUM(population*(Percentage/100))) AS Speakers FROM countrylanguage JOIN country ON countrylanguage.CountryCode = country.Code
            GROUP BY Language '.orderBy::GetOrderBy($_GET['orderBy']).' LIMIT :limit');
        if (ctype_digit($_GET['limit']))
            $stmt->bindValue(':limit', (int)$_GET['limit'], PDO::PARAM_INT);
        else
            $stmt->bindValue(':limit', 20, PDO::PARAM_INT);
        $stmt->execute();
    }
    else if (isset($_GET['limit'])) {
        $stmt = $db->prepare('SELECT Language, ROUND(SUM(population*(Percentage/100))) AS Speakers FROM countrylanguage JOIN country ON countrylanguage.CountryCode = country.Code
            GROUP BY Language ORDER BY SUM(population*(Percentage/100)) DESC LIMIT ?');
        if (ctype_digit($_GET['limit']))
            $stmt->bindValue(':limit', (int)$_GET['limit'], PDO::PARAM_INT);
        else
            $stmt->bindValue(':limit', 20, PDO::PARAM_INT);
        $stmt->execute();
    }
    else if (isset($_GET['orderBy'])) {
        $stmt = $db->prepare('SELECT Language, ROUND(SUM(population*(Percentage/100))) AS Speakers FROM countrylanguage JOIN country ON countrylanguage.CountryCode = country.Code
            GROUP BY Language '.orderBy::GetOrderBy($_GET['orderBy']));
        $stmt->execute();
    }
    else {
        $stmt = $db->prepare('SELECT Language, ROUND(SUM(population*(Percentage/100))) AS Speakers FROM countrylanguage JOIN country ON countrylanguage.CountryCode = country.Code
            GROUP BY Language ORDER BY SUM(population*(Percentage/100)) DESC LIMIT 20');
        $stmt->execute();
    }

    echo $twig->render('language2.twig', array('languages' => $stmt->fetchAll()));
?>