<?php


namespace mywishlist\controleur;


use mywishlist\vue\VueCompte;
use mywishlist\vue\VueCreateur;

class ControleurCompte
{

    public function creerCompte($rq, $rs, $args){
        $path = $rq->getURI()->getBasePath();

        if (! isset($rq->getParsedBody()['username'])){
            $vue = new VueCompte("", $path);
            $html = $vue->render(0);
        }
        else {
            // A filter !
            $pseudo = $rq->getParsedBody()['username'];
            $mdp = $rq->getParsedBody()['password'];

            // On sanitize
            filter_var($pseudo, FILTER_SANITIZE_STRING);
            filter_var($mdp, FILTER_SANITIZE_STRING);

            Authentification::createUser($pseudo, $mdp);

            $vue = new VueCompte("",$path);
            $html = $vue->render(0);
        }

        $rs->getBody()->write($html);
        return $rs;
    }

    public function seConnecter($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();

        if (! isset($rq->getParsedBody()['username'])){
            $vue = new VueCompte(true, $path);
            $html = $vue->render(1);
        }
        else {
            // A filter !
            $pseudo = $rq->getParsedBody()['username'];
            $mdp = $rq->getParsedBody()['password'];

            // On sanitize
            filter_var($pseudo, FILTER_SANITIZE_STRING);
            filter_var($mdp, FILTER_SANITIZE_STRING);

            $etat = Authentification::authenticate($pseudo, $mdp);

            $vue = new VueCompte($etat, $path);
            $html = $vue->render(1);
        }
        $rs->getBody()->write($html);
        return $rs;
    }
}