<?php


namespace mywishlist\vue;


class VueCreateur
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
                $contenu = $this->creerListe();
                break;
            case 1 :
                $contenu = $this->afficherToken();
                break;
            case 2 :
                $contenu = $this->afficherListe();
                break;
            case 3 :
                $contenu = $this->afficherFormulaireAjoutItem();
                break;
            case 4 :
                $contenu = $this->afficherItem();
                break;
            case 5 :
                $contenu = $this->afficherFromulaireInscription();
                break;
            case 6 :
                $contenu = $this->modifierListe();
                break;
            case 7 :
                $contenu = $this->afficherFromulaireConnexion();
                break;
            case 8 :
                $contenu = $this->afficherFormulaireModifierItem();

        }

        $path =  $this->path;
        $html = <<<END
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="$path/css/style.css">
		<title>MyWisList</title>
	</head>
<body>
    $path
    $contenu
</body>
<html>
END;
        return $html;
    }

    private function creerListe() : string {
        $html = <<<END
<h2>Création d'une liste de souhaits</h2>
<form  action="creerListe" method="post">
    <div class="formLise">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required>
    </div>
    <div class="formLise">
        <label for="desc">Description :</label>
        <input type="text" name="desc" required>
    </div>
    <div class="formLise">
        <label for="expiration">Date d'expiration :</label>
        <input type="date" name="expiration" required>
    </div>
    <div class="formLise">
        <input type="submit" value="Creer">
    </div>
</form>
END;
        return $html;
    }

    private function modifierListe() : string {
       $token = $this->elem;
        $html = <<<END
<h2>Modification d'une liste de souhaits</h2>
<form  action="$token" method="post">
    <div class="formLise">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required>
    </div>
    <div class="formLise">
        <label for="desc">Description :</label>
        <input type="text" name="desc" required>
    </div>
    <div class="formLise">
        <label for="expiration">Date d'expiration :</label>
        <input type="date" name="expiration" required>
    </div>
    <div class="formLise">
        <input type="submit" value="Modifier">
    </div>
</form>
END;
    return $html;
    }

    private function afficherListe() : string {
        $titre = $this->elem['liste']->titre;
        $token = $this->elem['liste']->token_modif;
        $items = '';
        foreach ($this->elem['items'] as $item)
            $items = $items . '<p><a href="'. $token . "/" . $item->id.'">'.$item->id.' - '.$item->nom.'</a></p>';
$html = <<<END
<div class="liste">
    <h1>$titre</h1>
    <div>$items</div>
</div>
END;
        return $html;
    }

    private function afficherItem() : string {
        $nom = $this->elem->nom ;
        $descr = $this->elem->descr;
        $img = 'Pas d\'image pour l\'instant';
        $html = <<<END
<div class="item">
    <h3>$nom :</h3>
    <p>$descr</p>
    <p>$img</p>
</div>
END;
        return $html;
    }

    private function afficherToken() : string {
        $html = <<<END
<form action="creerListe" method="POST">
  <button type="submit" name="token" value="1">
    Générer le lien de partage
  </button>
</form>
<div class="items">
    <p>Token : $this->elem</p>
</div>
END;
        return $html;
    }

    private function afficherFormulaireAjoutItem() : string {
        $html = <<<END
<form action="ajouterItem" method="POST">
    <input type="text" name="nomItem" placeholder="nom" required><br>
    <input type="text" name="descItem" placeholder="description" required><br>
    <input type="number" name="prixItem" placeholder="prix" min="0" step="0.01" required><br>
    <input type="url" name="lienItem" placeholder="lien"><br>
    <button type="submmit" name="validerAjoutItem">valider</button>
</form>
END;
        return $html;
    }

    private function afficherFromulaireInscription() : string {
        $html = <<<END
<h2>Inscription</h2>
<form  action="" method="post">
    <div class="formLigne">
        <label for="">Username:</label>
        <input type="text" name="username" required>
    </div>
    <div class="formLigne">
        <label for="desc">Password :</label>
        <input type="password" name="password" required>
    </div>
    <div class="formLigne">
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
<h2>Connexion</h2>
$erreur
<form  action="" method="post">
    <div class="formLigne">
        <label for="">Username:</label>
        <input type="text" name="username" required>
    </div>
    <div class="formLigne">
        <label for="desc">Password :</label>
        <input type="password" name="password" required>
    </div>
    <div class="formLigne">
        <input type="submit" value="Valider">
    </div>
</form>
END;
        return $html;
    }

    private function afficherFormulaireModifierItem() : string {
        $idItem = $this->elem['id'];
        $nom = "Nom : " . $this->elem['nom'];
        $desc = "Desc : " . $this->elem['desc'];
        $prix = "Prix : " . $this->elem['prix'];
        $lien = "Lien : " . $this->elem['lien'];

        $html = <<<END
<form action="$idItem" method="POST">
    <input type="text" name="nomItem" placeholder="$nom"><br>
    <input type="text" name="descItem" placeholder="$desc"><br>
    <input type="number" name="prixItem" placeholder="$prix" min="0" step="0.01"><br>
    <input type="url" name="lienItem" placeholder="$lien"><br>
    <button type="submmit" name="validerAjoutItem">valider</button>
</form>
END;
        return $html;
  }

}
