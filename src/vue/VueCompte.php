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

        $path =  $this->path;
        $html = <<<END
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="$path/css/style.css">
		<title>MyWisList</title>
	</head>
		<header>
	 <div id="rubrique">
	 <h1 id="titreR"><a href="$path/accueil">MyWishList </a></h1>
	 <nav>
	 <ul>
		 <li><a href="creation/listes">Mes Listes</a></li>
		 <li><a href="connexion">Se connecter</a></li>
		 <li><a href="inscription">S'inscrire</a></li>
	 </ul>
	 </nav>
	 </div>
 </header>
<body>
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

}