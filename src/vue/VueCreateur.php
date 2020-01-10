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
        }
        $html = <<<END
<!DOCTYPE html> 
<body>  
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
        $html = <<<END
<h2>Modification d'une liste de souhaits</h2>
<form  action="modifierListe" method="post">
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
        $items = '';
        foreach ($this->elem['items'] as $item)
            $items = $items . '<p>'.$item->id.' - '.$item->nom.'</p>';
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

}