<?php


namespace mywishlist\controleur;


use mywishlist\vue\VueCreateur;

class ControleurCreateur
{

    public function createToken($rq, $rs, $args){
        $id = $args['id'];
        if ($id == 1) {
            $token = random_bytes(32);
            $token = bin2hex($token);
            $vue = new VueCreateur($token);
            $html = $vue->render( 1 );
        }
        else {
            $vue = new VueCreateur("");
            $html = $vue->render(0);
        }
        $rs->getBody()->write($html);
        return $rs;
    }
}