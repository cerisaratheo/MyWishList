<?php


namespace mywishlist\controleur;


use mywishlist\models\Role;
use mywishlist\models\Utilisateur;

class Authentification
{

    public static function createUser($userName, $password){
        // A faire : vérifier la conformité de $password avec la police
        // si ok :
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $newUser = new Utilisateur();
        $newUser->username = $userName;
        $newUser->password = $hash;
        $newUser->role_id = 1;
        $newUser->save();
    }

    public static function authenticate( $username, $password) {
        $user = Utilisateur::select('*')
            ->where("username","=",$username)
            ->first();

        if (is_null($user)) return false;
            if (password_verify($password, $user->password)) {
                self::loadProfile($user);
                return true;
            }
            else return false;
    }

    private static function loadProfile($user){
        $role = $user->role()
            ->first();

        $_SESSION['profile'] = array(
            'id' => $user->uid,
            'username'   => $user->username,
            'role_id'    => $user->role,
            'client_ip'  => $_SERVER['REMOTE_ADDR']
            );
    }

    public static function checkAccessRights($required){
        if ($_SESSION['profile']['level'] < $required)
            throw new AuthException ;
    }


}