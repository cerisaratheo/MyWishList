<?php

namespace mywishlist;

require '../src/vendor/autoload.php';

use mywishlist\controleur\ControleurCreateur;
use mywishlist\controleur\ControleurParticipant;
use mywishlist\models\Liste;
use mywishlist\bd\Eloquent;
use\Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

Eloquent::start('../src/conf/conf.ini');

$configuration = [
    'settings'=> [
        'displayErrorDetails' => true,
        'dbconf' => '/conf/db.conf.ini' ]
];
$c=new\Slim\Container($configuration);
$app = new \Slim\App($c);

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
        $controleur = new ControleurParticipant($this);
        return $controleur->getListeSouhaits($req, $resp, $args);
});

$app->get('/testVue/item/{id}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->getItem($req, $resp, $args);
    });

$app->get('/creation/creerListe[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->creerListe($req, $resp, $args);
    });

$app->post('/creation/creerListe[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->creerListe($req, $resp, $args);
    });

$app->get('/creation/liste/{token}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->accederListe($req, $resp, $args);
    });

$app->get('/participation/{token}[/]',
    function($req, $resp, $args) {
        return $resp;
    });

$app->get('/creation/{token}/ajouterItem[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->ajoutItem($req, $resp, $args);
    });

$app->post('/creation/{token}/ajouterItem[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->ajoutItem($req, $resp, $args);
    });



$app->get('/reservation/item/{id}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->reserverItem($req, $resp, $args);
    });




$app->run();