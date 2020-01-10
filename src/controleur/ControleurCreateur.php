<?php


namespace mywishlist\controleur;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Utilisateur;
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
            $tokenModif = $this->genererToken(1);
            $tokenParticipation = $this->genererToken(2);

            // On sauvegarde la liste dans la BDD
            $liste = new Liste();
            $liste->titre = $titre;
            $liste->description = $desc;
            $liste->expiration = $date;
            $liste->token_modif = $tokenModif;
            $liste->token_participation = $tokenParticipation;
            $liste->save();

            $vue = new VueCreateur("");
            $html = $vue->render(0);
        }

        $rs->getBody()->write($html);
        return $rs;
    }

    public function accederItem($rq, $rs, $args){
        $token = $args['token'];
            $liste = Liste::select("*")
                -> where('token_modif',"=",$token)
                -> first();
        if(!is_null($liste)) {
            $id = $args['item'];
            $item = Item::select('*')
                -> where ('liste_id','=',$liste->no)
                -> where ('id','=',$id)
                -> first();
            $vue = new VueCreateur($item);
            $html = $vue->render(4);
            $rs->getBody()->write($html);
        }
        return $rs;
    }

    private function genererToken($id){
        // On verifie que le token est n'existe pas deja dans la BDD
        do {
            switch ($id) {
                case 1 :
                    $token = random_bytes(5);
                    $res = Liste::select('no')
                        ->where('token_modif',"=",$token)
                        ->first();
                    break;
                case 2 :
                    $token = random_bytes(5);
                    $res = Liste::select('no')
                        ->where('token_participation',"=",$token)
                        ->first();
            }
        } while (! is_null($res));

        $url =/* $rq->getURI()->getHost(). $rq->getURI()->getBasePath().'/participation/'.*/bin2hex($token);
        return $url;
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
        $vue = new VueCreateur("");
        $html = $vue->render(6);
        if (! isset($rq->getParsedBody()['titre']) || ! isset($rq->getParsedBody()['desc']) || ! isset($rq->getParsedBody()['expiration'])){
            $token = $args['token'];
            $vue = new VueCreateur($token);
            $html = $vue->render(6);
        }
        else{

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
                $html = $vue->render(6);
            }

        }
        $rs->getBody()->write($html);
        return $rs;
        }

    public function ajoutItem($rq, $rs, $args)
    {
        if (!isset($rq->getParsedBody()['nomItem']) || !isset($rq->getParsedBody()['descItem']) || !isset($rq->getParsedBody()['prixItem'])) {
            $vue = new VueCreateur("");
            $html = $vue->render(3);
        } else {
            $token = $args['token'];
            $numero = Liste::select("no")
                ->where('token_modif', '=', $token)
                ->first();

            // WOW FILTRE / ! \
            $nom = $rq->getParsedBody()['nomItem'];
            $desc = $rq->getParsedBody()['descItem'];
            $prix = $rq->getParsedBody()['prixItem'];
            $url = $rq->getParsedBody()['lienItem'];

            $item = new Item();
            $item->liste_id = $numero->no;
            $item->nom = $nom;
            $item->descr = $desc;
            $item->url = $url;
            $item->tarif = $prix;
            $item->save();

            $vue = new VueCreateur("");
            $html = $vue->render(3);
        }
        $rs->getBody()->write($html);
        return $rs;
    }

    public function creerCompte($rq, $rs, $args){
        if (! isset($rq->getParsedBody()['username'])){
            $vue = new VueCreateur("");
            $html = $vue->render(5);
        }
        else {
            // A filter !
            $pseudo = $rq->getParsedBody()['username'];
            $mdp = $rq->getParsedBody()['password'];

            Authentification::createUser($pseudo, $mdp);

            $vue = new VueCreateur("");
            $html = $vue->render(5);
        }

        $rs->getBody()->write($html);
        return $rs;
    }
}
