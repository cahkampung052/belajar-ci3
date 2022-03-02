<?php
require_once 'vendor/autoload.php';

function view($path, $data = []) {
    $loader = new \Twig\Loader\FilesystemLoader('application/views/');

    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);

    echo $twig->render($path, $data);
}