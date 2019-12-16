<?php


namespace mywishlist\controleur;


use mywishlist\models\Utilisateur;

class Authentification
{

    public static function createUser($userName, $password){

    }

    public static function authenticate( $username, $password){
        $user = Utilisateur::select('*')
            ->get();
        if (password_verify($password, $user->password)) {
            $_SESSION[$user->id] = array(
                'username'   => $user->login,
                'role_id'    => 12,
                'client_ip'  => '201.456.23.128',
                'auth-level' => 10000 )
            );
        }
    }

    private static function loadProfile($uid){

    }

    public static function chechAccessRights($required){

    }


}