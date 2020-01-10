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

    public function reserverItem($rq, $rs, $args)
    {
        $id = $args['id'];
        $item = \mywishlist\models\Item::find($id);
        $vue = new \mywishlist\vue\VueParticipant("");
        $html = $vue->render(4);
        $rs->getBody()->write($html);
        $pseudo="";
        if (isset($rq->getParsedBody()['pseudo'])) {
            $pseudo = $rq->getParsedBody()['pseudo'];
        }

        $ir = \mywishlist\models\Reservation::find($id);
        if (isset($pseudo) && $pseudo!="" && !isset($ir)) {
            $r = new Reservation();
            $r->pseudo = $pseudo;
            $r->id_item = $id;
            $r->save();
        }
        if (!isset($_COOKIE['pseudo']) && isset($pseudo) || $pseudo != $_COOKIE['pseudo']) { // Teste si le cookie n'existe pas
            setcookie("pseudo", $pseudo, time() + 60 * 60, "mywishlist");
        }
        return $rs;
    }
}