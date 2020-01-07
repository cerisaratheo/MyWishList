<?php


namespace mywishlist\controleur;


use mywishlist\models\Reservation;

class ControleurParticipant
{

    public function getItem($rq, $rs, $args){
        $id = $args['id'];

        $item = \mywishlist\models\Item::find($id);
        $vue = new \mywishlist\vue\VueParticipant( [$item] );
        $html = $vue->render( 3 );

        $rs->getBody()->write($html);
        return $rs;
    }

    public function getListeSouhaits($rq, $rs, $args){

        $list = \mywishlist\models\Liste::all();
        $vue = new \mywishlist\vue\VueParticipant( $list->toArray() );
        $html = $vue->render( 1 );

        $rs->getBody()->write($html);
        return $rs;
    }

    public function reserverItem($rq, $rs, $args) {
        $r = new Reservation();
        $r -> pseudo = '$_POST[\'pseudo\']';
        $r -> id_item = 1; // j'ai mis 1 pour tester
        $r->save();
        if(!isset($_COOKIE['pseudo'])){ // Teste si le cookie n'existe pas
            setcookie("pseudo", '$_POST[\'pseudo\']', time() + 60*60, "mywishlist" ) ;
        }
        $vue = new \mywishlist\vue\VueParticipant();
        $html = $vue->render( 4 );
    }
}