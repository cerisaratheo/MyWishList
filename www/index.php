<?php

namespace mywishlist;

require '../src/vendor/autoload.php';

use mywishlist\controleur\ControleurCompte;
use mywishlist\controleur\ControleurCreateur;
use mywishlist\controleur\ControleurParticipant;
use mywishlist\models\Liste;
use mywishlist\bd\Eloquent;
use\Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

session_start();

Eloquent::start('../src/conf/conf.ini');

$configuration = [
    'settings'=> [
        'displayErrorDetails' => true,
        'dbconf' => '/conf/db.conf.ini' ]
];
$c=new\Slim\Container($configuration);
$app = new \Slim\App($c);

//////////////////////////////////////////
////           ACCUEIL                ////
//////////////////////////////////////////

$app->get('/accueil[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCompte($this);
        return $controleur->afficherAccueil($req, $resp, $args);
    });


//////////////////////////////////////////
////           COMPTES                ////
//////////////////////////////////////////


$app->get('/inscription[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCompte($this);
        return $controleur->creerCompte($req, $resp, $args);
    });

$app->post('/inscription[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCompte($this);
        return $controleur->creerCompte($req, $resp, $args);
    });

$app->get('/connexion[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCompte($this);
        return $controleur->seConnecter($req, $resp, $args);
    });

$app->post('/connexion[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCompte($this);
        return $controleur->seConnecter($req, $resp, $args);
    });

$app->get('/deconnexion[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCompte($this);
        return $controleur->seDeconnecter($req, $resp, $args);
    });


//////////////////////////////////////////
////          CREATION                ////
//////////////////////////////////////////

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



$app->get('/creation/listes[/]',
    function(Request$req, Response$resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->getListeSouhaits($req, $resp, $args);
    });




$app->get('/creation/liste/{token}/modifier[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->modifierListe($req, $resp, $args);
    });

$app->post('/creation/liste/{token}/modifier[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->modifierListe($req, $resp, $args);
    });

$app->get('/creation/liste/{token}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurCreateur($this);
        return $controleur->accederListe($req, $resp, $args);
    });


$app->get('/creation/liste/{token}/ajouterItem[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->ajoutItem($req, $resp, $args);
    });

$app->post('/creation/liste/{token}/ajouterItem[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->ajoutItem($req, $resp, $args);
    });

$app->get('/creation/liste/{token}/{item}[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->accederItem($req, $resp, $args);
    });

$app->get('/creation/liste/{token}/{item}/modifier[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->modifierItem($req, $resp, $args);
    });

$app->post('/creation/liste/{token}/{item}/modifier[/]',
    function($req, $resp, $args){
        $controleur = new ControleurCreateur($this);
        return $controleur->modifierItem($req, $resp, $args);
    });


//////////////////////////////////////////
////          RESERVATION             ////
//////////////////////////////////////////

$app->get('/participation/{token}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->afficherParticipation($req, $resp, $args);
    });

$app->get('/participation/{token}/{item}[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->afficherParticipationItem($req, $resp, $args);
    });

$app->get('/participation/{token}/{item}/reservation[/]',
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->afficherFormulaireReservation($req, $resp, $args);
    });

$app->post("/participation/{token}/{item}/reservation[/]",
    function($req, $resp, $args) {
        $controleur = new ControleurParticipant($this);
        return $controleur->reserverItem($req, $resp, $args);
    });




$app->run();