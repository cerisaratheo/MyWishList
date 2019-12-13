<?php

namespace mywishlist;

require 'src/vendor/autoload.php';

use mywishlist\controleur\AfficherListe;
use mywishlist\models\Liste;
use mywishlist\bd\Eloquent;
use\Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

Eloquent::start('src/conf/conf.ini');
$app = new \Slim\App;

$app->get('/liste[/]',
    function(Request$req, Response$resp, $args) {
        $res = '<h3>Liste des souhaits</h3>';
        $souhaits = Liste::select('*')
            -> get();
        foreach ($souhaits as $souhait)
            $res = $res . '<p>'.$souhait->no.' - '.$souhait->titre.'</p>';
        $resp->getBody()->write($res);
        return $resp;
});

$app->get('/testVue/listes[/]',
    function(Request$req, Response$resp, $args) {
        $controleur = new AfficherListe($this);
        return $controleur->getListeSouhaits($req, $resp, $args);
});

$app->get('/testVue/item/{id}[/]',
    function($req, $resp, $args) {
        $controleur = new AfficherListe($this);
        return $controleur->getItem($req, $resp, $args);
    });

$app->run();