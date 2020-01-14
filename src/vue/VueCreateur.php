<?php


namespace mywishlist\vue;


class VueCreateur
{
    private $elem;

    function __construct($tab)
    {
        $this->elem = $tab;
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
        $html = <<<END
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
		<title>MyWisList</title>
	</head>
<body>
    $contenu
</body>
<html>
END;
        return $html;
    }

    private function creerListe() : string {
        $html = <<<END
<form  action="creerListe" method="post">
<h2>Création d'une liste de souhaits</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="titre" placeholder="Titre" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="desc" placeholder="Description" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="date" name="expiration" placeholder="Date d'expiration" required>
    </div>
    <div class="formulaire">
        <input type="submit" value="Creer">
    </div>
</form>
END;
        return $html;
    }

    private function modifierListe() : string {
        $token = $this->elem;
        $html = <<<END
<form  action="$token" method="post">
<h2>Modification d'une liste de souhaits</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="titre" placeholder="Titre" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="desc" placeholder="Description" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="date" name="expiration" placeholder="Date d'expiration" required>
    </div>
    <div class="formulaire">
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
    <h2>Ajouer un Item</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="nomItem" placeholder="Nom" required><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="descItem" placeholder="Description" required><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="number" name="prixItem" placeholder="Prix" min="0" step="0.01" required><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="url" name="lienItem" placeholder="Lien"><br>
    </div>
    <div class="formulaire">
        <input type="submmit" value="valider">
    </div>
</form>
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
        <label for="">Username:</label>
        <input style="text-align:center" type="text" name="username" placeholder="Pseudonyme" required>
    </div>
    <div class="formulaire">
        <label for="desc">Password :</label>
        <input style="text-align:center" type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <div class="formulaire">
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
    <h2>Modifier un Item</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="nomItem" placeholder="$nom"><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="descItem" placeholder="$desc"><br>
    </div>
    <div calss="formulaire">
        <input style="text-align:center" type="number" name="prixItem" placeholder="$prix" min="0" step="0.01"><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="url" name="lienItem" placeholder="$lien"><br>
    </div>
    <div class="formulaire">
        <input type="submmit" value="valider">
    </div>
</form>
END;
        return $html;
  }

}
