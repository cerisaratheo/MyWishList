<?php

namespace mywishlist;

require 'src/vendor/autoload.php';

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

        // pour afficher la liste des listes de souhaits
        // A deplacer dans un controlleur
        $list = \mywishlist\models\Liste::all();
        $vue = new \mywishlist\vue\VueParticipant( $list->toArray() );
        $html = $vue->render( 1 );

        $resp->getBody()->write($html);
        return $resp;
});

$app->get('/testVue/item/{id}[/]',
    function(Request$req, Response$resp, $args) {
        $id = $args['id'];

        //pour afficher 1 item
        // A deplacer dans un controlleur
        $item = \mywishlist\models\Item::find($id);
        $vue = new \mywishlist\vue\VueParticipant( [$item] );
        $html = $vue->render( 3 );

        $resp->getBody()->write($html);
        return $resp;
    });

$app->run();