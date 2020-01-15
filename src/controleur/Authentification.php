<?php


namespace mywishlist\controleur;


use mywishlist\models\Role;
use mywishlist\models\Utilisateur;

/**
 * Class Authentification
 * @package mywishlist\controleur
 */
class Authentification
{

    /**
     * Methode static qui permet de creer un utilisateur
     * @param $userName nom de l'utilisateur
     * @param $password mot de passe de l'utilisation
     */
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

    /**
     * Methode static qui permet de s'authentifier
     * @param $userName nom de l'utilisateur
     * @param $password mot de passe de l'utilisation
     */
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

    /**
     * Methode qui charge un profile utilisateur dans une variable de session
     * @param $user utilisateur
     */
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

    /**
     * Methode qui permet de controler les droits d'accès
     * @param $required niveau requis
     * @throws AuthException
     */
    public static function checkAccessRights($required){
        if ($_SESSION['profile']['level'] < $required)
            throw new AuthException ;
    }


}
