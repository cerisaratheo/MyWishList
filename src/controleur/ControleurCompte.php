<?php


namespace mywishlist\controleur;


use mywishlist\models\Utilisateur;
use mywishlist\vue\VueCompte;

/**
 * Class ControleurCompte
 * @package mywishlist\controleur
 */
class ControleurCompte
{

    /**
     * Methode qui permet d'acceder à l'accueil
     * @param $rq
     * @param $rs
     * @param $args
     * @return mixed la reponse http
     */
    public function afficherAccueil($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();
        $vue = new VueCompte("", $path);

        $html = $vue->render(2);
        $rs->getBody()->write($html);
        return $rs;
    }



    /**
     * Methode qui permet de creer un compte createur
     * @param $rq
     * @param $rs
     * @param $args
     * @return mixed la reponse http
     */
    public function creerCompte($rq, $rs, $args){
        $path = $rq->getURI()->getBasePath();

        if (! isset($rq->getParsedBody()['username'])) {
            $vue = new VueCompte("", $path);
            $html = $vue->render(0);
        }
        else {
            $pseudo = $rq->getParsedBody()['username'];
            $mdp = $rq->getParsedBody()['password'];

            // Filtrage
            filter_var($pseudo, FILTER_SANITIZE_STRING);
            filter_var($mdp, FILTER_SANITIZE_STRING);

            $compteDejaCree = Utilisateur::where ('username', '=', $pseudo)->first();

            if (is_null($compteDejaCree)) {
                Authentification::createUser($pseudo, $mdp);
                $vue = new VueCompte("",$path);
                $html = $vue->render(1);
            }
            else {
                $vue = new VueCompte(true, $path);
                $html = $vue->render(0);
            }
        }

        $rs->getBody()->write($html);
        return $rs;
    }

    /**
     * Methode qui permet de se connecter
     * @param $rq
     * @param $rs
     * @param $args
     * @return mixed la reponse http
     */
    public function seConnecter($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();

        if (! isset($rq->getParsedBody()['username'])){
            $vue = new VueCompte(true, $path);
            $html = $vue->render(1);
        }
        else {
            $pseudo = $rq->getParsedBody()['username'];
            $mdp = $rq->getParsedBody()['password'];

            // Filtrage
            filter_var($pseudo, FILTER_SANITIZE_STRING);
            filter_var($mdp, FILTER_SANITIZE_STRING);

            $etat = Authentification::authenticate($pseudo, $mdp);
            if ($etat == true) {
                $vue = new VueCompte($etat, $path);
                $html = $vue->render(2);
            }
            else {
                $vue = new VueCompte($etat, $path);
                $html = $vue->render(1);
            }
        }
        $rs->getBody()->write($html);
        return $rs;
    }

    /**
     * Methode qui permet de se deconnecter
     * @param $rq
     * @param $rs
     * @param $args
     * @return mixed la reponse http
     */
    public function seDeconnecter($rq, $rs, $args) {
        $path = $rq->getURI()->getBasePath();

        if (isset($_SESSION['profile'])){
            unset($_SESSION['profile']);
        }

        $vue = new VueCompte('', $path);
        $html = $vue->render(2);
        $rs->getBody()->write($html);
        return $rs;
    }
}