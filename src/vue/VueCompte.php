<?php


namespace mywishlist\vue;


class VueCompte
{
    private $elem;
    private $path;

    function __construct($tab, $path)
    {
        $this->elem = $tab;
        $this->path = $path;
    }

    public function render(int $index) : string {
        switch ($index){
            case 0 :
                $contenu = $this->afficherFromulaireInscription();
                break;
            case 1 :
                $contenu = $this->afficherFromulaireConnexion();
                break;
            case 2 :
                $contenu = $this->afficherAccueil();
                break;
        }

        $path = $this->path;
        $header = self::getHeader($path);

        $html = <<<END
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="$path/../css/style.css">
		<title>MyWisList</title>
	</head>
<body>
	$header
    
    $contenu
</body>
<html>
END;
        return $html;
    }


    private function afficherAccueil() :string {
        $html = <<<END
<div class="accueil">
    <h1>Accueil</h1>
</div>
END;
        return $html;
    }

    private function afficherFromulaireInscription() : string {
        $html = <<<END
<form  action="" method="post">
    <h2>Inscription</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="username" placeholder="Pseudonyme" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <div class="formulaire">
        <input type="submit" value="Valider">
    </div>
</form>
END;
        return $html;
    }

    private function afficherFromulaireConnexion() : string {

        $erreur = "";
        if ($this->elem == false)
            $erreur = "<h3>Mot de passe ou nom d'utilisateur incorrect(s)</h3>";

        $html = <<<END
$erreur
<form  action="" method="post">
    <h2>Connexion</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="username" placeholder="Pseudonyme" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <div class="formulaire">
        <input type="submit" value="Valider">
    </div>
</form>
END;
        return $html;
    }

    public static function getHeader($path) : string {
        if (isset($_SESSION['profile'])) {
            $pseudo = $_SESSION['profile']['username'];
            $option = "<li><a href=\"$path/creation/listes\">Mes Listes</a></li>
                        <li><a href=\"$path/deconnexion\">Se déconnecter</a></li>
		                <li>$pseudo</li>";
        } else {
            $option = "<li><a href=\"$path/connexion\">Se connecter</a></li>
		                <li><a href=\"$path/inscription\">S'inscrire</a></li>";
        }

        $html = <<<END
<header>
     <div id="rubrique">
         <h1 id="titreR"><a href="$path/accueil">MyWishList </a></h1>
         <nav>
             <ul>
                  $option
             </ul>
         </nav>
     </div>
</header>

END;
        return $html;
    }

}