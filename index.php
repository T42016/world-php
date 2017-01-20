<?php
require __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, array('cache' => __DIR__ .'/cache', 'debug' => true));
echo $twig->render('index.twig');
	?>