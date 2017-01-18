<?php
    require __DIR__.'/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
    $twig = new Twig_Environment($loader, array('debug' => true));

    $db = new PDO('mysql:host=localhost;dbname=world;charset=utf8mb4', 'root', '');

    $stmt = $db->prepare('SELECT Language, ROUND(SUM(population*(Percentage/100))) AS Speakers FROM countrylanguage JOIN country ON countrylanguage.CountryCode = country.Code
      GROUP BY Language ORDER BY SUM(population*(Percentage/100)) DESC LIMIT 20');
        $stmt->execute();

    echo $twig->render('top20.twig', array('languages' => $stmt->fetchAll()));
?>