<?php


namespace mywishlist\vue;

/**
 * Class VueCreateur
 * @package mywishlist\vue
 */
class VueCreateur
{
    /**
     * @var valeurs quelconques
     */
    private $elem;

    /**
     * @var debut de l'url
     */
    private $path;

    /**
     * Constructeur de la classe.
     * @param $tab valeurs quelconques
     * @param $path debut de l'url
     */
    function __construct($tab, $path)
    {
        $this->elem = $tab;
        $this->path = $path;
    }

    /**
     * Methode qui creee la base de la page html dont le contenu est
     * cree par des fonctions privees
     * @param int $index numero de la methode à utiliser
     * @return string contenu html
     */
    public function render(int $index) : string {
        switch ($index){
            case 0 :
                $contenu = $this->creerListe();
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
                $contenu = $this->afficherListesSouhaits();
                break;
            case 6 :
                $contenu = $this->modifierListe();
                break;
            case 8 :
                $contenu = $this->afficherFormulaireModifierItem();
                break;
        }

        $path = $this->path;
        $header = VueCompte::getHeader($path);

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

    /**
     * Methode qui affiche le formulaire de creation d'une liste
     * @return string contenu html
     */
    private function creerListe() : string {
        $token = $this->elem;
        $server = $_SERVER['SERVER_NAME'];
        $url = $server . $this->path;
        $html = <<<END
<form  action="creerListe" method="post">
<h2>Création d'une liste de souhaits</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="titre" placeholder="Titre" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="desc" placeholder="Description" required>
    </div>
    <p>Date d'expiration :</p>
    <div class="formulaire">
        <input style="text-align:center" type="date" name="expiration" required>
    </div>
    <div class="formulaire">
        <input type="submit" value="Creer">
    </div>
</form>
END;
        return $html;
    }

    /**
     * Methode qui affiche le formulaire de modification d'une liste
     * @return string contenu html
     */
    private function modifierListe() : string {
       $token = $this->elem;
        $html = <<<END
<form  action="" method="post">
<h2>Modification d'une liste de souhaits</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="titre" placeholder="Titre" required>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="desc" placeholder="Description" required>
    </div>
    <p>Date d'expiration :</p>
    <div class="formulaire">
        <input style="text-align:center" type="date" name="expiration" required>
    </div>
    <div class="formulaire">
        <input type="submit" value="Modifier">
    </div>
</form>
END;
    return $html;
    }

    /**
     * Methode qui affiche une liste
     * @return string contenu html
     */
    private function afficherListe() : string {
        $titre = $this->elem['liste']->titre;
        $token = $this->elem['liste']->token_modif;
        $tokenmodif = $this->elem['liste']->token_participation;
        $server = $_SERVER['SERVER_NAME'];
        $url = $server . $this->path;
        $items = '';
        foreach ($this->elem['items'] as $item)
            $items = $items . '<p><a class="lienItem" href="'. $token. "/" . $item->id.'">'.$item->id.' - '.$item->nom.'</a></p>';
$html = <<<END
<p>Le lien de partage est le suivant : $url/participation/$tokenmodif</p>
<div class="liste">
    <h1>$titre</h1>
    <div>$items</div>
</div>
<form class="formSuppListe" action="$token/modifier">
    <input class="bouton" type="submit" value="Modifier">
</form>
<form class="formSuppListe" action="$token/ajouterItem">
    <input class="bouton" type="submit" value="Ajouter un Item">
</form>
END;
        return $html;
    }

    /**
     * Methode qui affiche toutes les listes d'un utilisateur
     * @return string contenu html
     */
    private function afficherListesSouhaits() : string {
        $res = "";
        foreach ($this->elem as $liste){
            if(isset($liste['token_modif'])&&isset($liste['titre'])){
                $token = $liste['token_modif'];
                $res = $res . "<div class='liste'><p><a  class='lienListe' href=\"".$this->path."/creation/liste/".$token."\">".$liste['titre'].'</a></p></div>';
            }

        }
        $res = $res /*. var_dump($this->elem)*/."";
        $html = <<<END
<form class="formNouvelleListe" action="creerListe">
    <input class="bouton" type="submit" name="creerListe" value="Créer une nouvelle Liste">
</form>
<div class="souhaits">
    $res
</div>
END;
        return $html;
    }

    /**
     * Methode qui affiche un item
     * @return string contenu html
     */
    private function afficherItem() : string {
        $nom = $this->elem->nom ;
        $descr = $this->elem->descr;
        $id = $this->elem->id;
        $img = 'Pas d\'image pour l\'instant';
        $html = <<<END
<div class="item">
    <h3>$nom :</h3>
    <p>$descr</p>
    <p>$img</p>
</div>
<form class="formModifItem" action="$id/modifier">
    <input class="bouton" type="submit" name="modifItem" value="Modifier">
</form>
END;
        return $html;
    }

    /**
     * Methode qui affiche le formulaire d'ajout d'un item
     * @return string contenu html
     */
    private function afficherFormulaireAjoutItem() : string {
        $html = <<<END
<form action="ajouterItem" method="POST">
    <h2>Ajouter un Item</h2>
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
        <input type="submit" value="valider">
    </div>
</form>
END;
        return $html;
    }

    /**
     * Methode qui affiche le formulaire de modification d'un item
     * @return string contenu html
     */
    private function afficherFormulaireModifierItem() : string {
        $idItem = $this->elem['id'];
        $nom = "Nom : " . $this->elem['nom'];
        $desc = "Desc : " . $this->elem['desc'];
        $prix = "Prix : " . $this->elem['prix'];
        $lien = "Lien : " . $this->elem['lien'];

        $html = <<<END
<form action="" method="POST">
    <h2>Modifier un Item</h2>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="nomItem" placeholder="$nom"><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="text" name="descItem" placeholder="$desc"><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="number" name="prixItem" placeholder="$prix" min="0" step="0.01"><br>
    </div>
    <div class="formulaire">
        <input style="text-align:center" type="url" name="lienItem" placeholder="$lien"><br>
    </div>
    <div class="formulaire">
        <input type="submit" value="valider">
    </div>
</form>
END;
        return $html;
  }

}
