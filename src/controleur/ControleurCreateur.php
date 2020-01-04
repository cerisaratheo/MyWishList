<?php


namespace mywishlist\controleur;


use mywishlist\models\Liste;
use mywishlist\vue\VueCreateur;

class ControleurCreateur
{

    public function createToken($rq, $rs, $args){
        if (isset($rq->getParsedBody()['token']))
            $id = $rq->getParsedBody()['token'];
        else
            $id =  0;
        if ($id == 1 /*&& et liste remplie*/) {
            $token = random_bytes(5);
            $token = $rq->getURI()->getHost(). $rq->getURI()->getBasePath().'/participation/'.bin2hex($token);
            $vue = new VueCreateur($token);
            $html = $vue->render( 1 );
        }

        else {
            $vue = new VueCreateur("");
            $html = $vue->render(1);
        }
        $rs->getBody()->write($html);
        return $rs;
    }

    public function accederListe($rq, $rs, $args){
        $token = $args['token'];
        $liste = Liste::select("*")
            -> where('token_modif',"=",$token)
            -> first();

        // il faudra verifier que l'utilisateur qui veut acceder à cette
        // liste est bien celui qui l'a créé qd l'authentification sera en place
        if(! is_null($liste)){
            $vue = new VueCreateur($liste);
            $html = $vue->render(2);
            $rs->getBody()->write($html);
        }
        return $rs;
    }
}