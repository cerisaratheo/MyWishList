<?php


namespace mywishlist\controleur;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueCreateur;

class ControleurCreateur
{

    public function creerListe($rq, $rs, $args){
        if (! isset($rq->getParsedBody()['titre']) || ! isset($rq->getParsedBody()['desc']) || ! isset($rq->getParsedBody()['expiration'])){
            $vue = new VueCreateur("");
            $html = $vue->render(0);
        }
        else {
            // A filter !
            $titre = $rq->getParsedBody()['titre'];
            $desc = $rq->getParsedBody()['desc'];
            $date = $rq->getParsedBody()['expiration'];

            // Generation du token de modification
            $token = $this->genererToken($rq, $rs, $args);

            // On sauvegarde la liste dans la BDD
            $liste = new Liste();
            $liste->titre = $titre;
            $liste->description = $desc;
            $liste->expiration = $date;
            $liste->token_modif = $token;
            $liste->save();

            $vue = new VueCreateur("");
            $html = $vue->render(0);
        }

        $rs->getBody()->write($html);
        return $rs;
    }

    private function genererToken($rq, $rs, $args){
        // On verifie que le token est n'existe pas deja dans la BDD
        do {
            $token = random_bytes(5);
            $res = Liste::select('no')
                    ->where('token_modif',"=",$token)
                    ->first();
        } while (! is_null($res));

        $url = $rq->getURI()->getHost(). $rq->getURI()->getBasePath().'/participation/'.bin2hex($token);
        return $url;
    }

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
            -> where('token_modif','=',$token)
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
            $vue = new VueCreateur($infos);
            $html = $vue->render(2);
            $rs->getBody()->write($html);
        }
        else {

        }
        return $rs;
    }

    public function modifierListe($rq,$rs,$args){
        $token = $args['token'];
        $liste = Liste::select("*")
            -> where('token_modif',"=",$token)
            -> first();

        //pareil qu'accederListe, il faut vérifier l'utilisateur

        if(!is_null($liste)){
            $liste->titre = $rq->getParsedBody()['titre'];
            $liste->description = $rq->getParsedBody()['desc'];
            $liste->expiration = $rq->getParsedBody()['expiration'];
            $liste->save();
            $vue = new VueCreateur("");
            $html = $vue->render(0);
        }
        else{

        }
        $rs->getBody()->write($html);
        return $rs;
    }
    public function ajoutItem($rq, $rs, $args){
        // à faire
    }
}