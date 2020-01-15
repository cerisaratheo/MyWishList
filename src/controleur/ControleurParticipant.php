<?php


namespace mywishlist\controleur;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Reservation;
use mywishlist\vue\VueParticipant;

class ControleurParticipant
{

    public function afficherParticipation($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();

        $token = $args['token'];
        $liste = Liste::select("*")
            -> where('token_participation','=',$token)
            -> first();

        // il faudra verifier que l'utilisateur qui veut acceder à cette
        // liste est bien celui qui l'a créé qd l'authentification sera en place
        if (! is_null($liste)) {
            $items = Item::select("*")
                -> where('liste_id','=',$liste->no)
                -> get();
            $infos = array(
                'liste' => $liste,
                'items' => $items
            );
            $vue = new VueParticipant($infos, $path);
            $html = $vue->render(5);
            $rs->getBody()->write($html);
        }
        else {

        }
        return $rs;
    }

    public function afficherParticipationItem($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();

        $token = $args['token'];
        $liste = Liste::select("*")
            -> where('token_participation',"=",$token)
            -> first();
        if(!is_null($liste)) {
            $id = $args['item'];
            $item = Item::select('*')
                -> where ('liste_id','=',$liste->no)
                -> where ('id','=',$id)
                -> first();
            $vue = new VueParticipant($item, $path);
            $html = $vue->render(6);
            $rs->getBody()->write($html);
        }
        return $rs;
    }


    public function getItem($rq, $rs, $args){
        $path = $rq->getURI()->getBasePath();

        $id = $args['id'];

        $item = \mywishlist\models\Item::find($id);
        $vue = new \mywishlist\vue\VueParticipant( [$item],$path );
        $html = $vue->render( 3 );

        $rs->getBody()->write($html);
        return $rs;
    }

    public function getListeSouhaits($rq, $rs, $args){
        $path = $rq->getURI()->getBasePath();

        $list = \mywishlist\models\Liste::all();
        $vue = new \mywishlist\vue\VueParticipant( $list->toArray(), $path );
        $html = $vue->render( 1 );

        $rs->getBody()->write($html);
        return $rs;
    }

    public function afficherFormulaireReservation($rq, $rs, $args)
    {
        $path = $rq->getURI()->getBasePath();

        $id = $args['item'];
        $item = \mywishlist\models\Item::find($id);
        $ir = \mywishlist\models\Reservation::find($id);
        $vue = new \mywishlist\vue\VueParticipant("", $path);
        if (isset($ir)) {
            echo "L'item est déjà réservé.";
        }
        else {
            $html = $vue->render(4);
            $rs->getBody()->write($html);
        }
        return $rs;
    }
    public function reserverItem($rq, $rs, $args)
    {
        $path = $rq->getURI()->getBasePath();

        $id = $args['item'];
        $item = \mywishlist\models\Item::find($id);
        $vue = new \mywishlist\vue\VueParticipant("", $path);
        $html = $vue->render(4);
        $rs->getBody()->write($html);
        if (isset($_COOKIE['pseudo']))
            $pseudo=$_COOKIE['pseudo'];
        else
            $pseudo = "";
        if (isset($rq->getParsedBody()['pseudo'])) {
            $pseudo = $rq->getParsedBody()['pseudo'];
        }

        if (isset($rq->getParsedBody()['message'])) {
            $message = $rq->getParsedBody()['message'];
        }
        else {
            $message = "";
        }

        $ir = \mywishlist\models\Reservation::find($id);
        if (isset($pseudo) && $pseudo!="" && !isset($ir)) {
            $r = new Reservation();
            $r->pseudo = $pseudo;
            $r->id_item = $id;
            $r->message = $message;
            $r->save();
        }
        if (!isset($_COOKIE['pseudo']) && isset($pseudo) || $pseudo != $_COOKIE['pseudo']) { // Teste si le cookie n'existe pas
            setcookie("pseudo", $pseudo, time() + 60 * 60, "mywishlist");
        }
        return $rs;
    }
}