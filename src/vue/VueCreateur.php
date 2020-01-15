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
                $contenu = $this->afficherListesSouhaits();
                break;
            case 6 :
                $contenu = $this->modifierListe();
                break;
            case 7 :
                // place libre
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
		<link rel="stylesheet" href="$path/css/style.css">
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

    private function afficherListesSouhaits() : string {
        $res = "";
        foreach ($this->elem as $liste){
            $token = $liste['token_modif'];
            $res = $res . "<p><a href=\"".$this->path."/creation/liste/".$token."\">".$liste['titre'].'</a></p>';
        }
        $res = $res /*. var_dump($this->elem)*/."";
        $html = <<<END
<div class="souhaits"> 
    $res
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
