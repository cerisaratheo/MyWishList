<?php


namespace mywishlist\controleur;


use mywishlist\models\Utilisateur;

class Authentification
{

    public static function createUser($userName, $password){
        $user = Utilisateur::select('login', 'password')
                    ->get();
        if (password_verify($password, $user->password)) {

        }
    }

    public static function authenticate( $username, $password){

    }

    private static function loadProfile($uid){

    }

    public static function chechAccessRights($required){

    }


}