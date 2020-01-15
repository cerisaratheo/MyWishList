<?php

namespace mywishlist\vue;

class VueParticipant
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
            case 1 :
                $contenu = $this->afficherListesSouhaits();
                break;
            case 2 :
                $contenu = $this->afficherItemsListe();
                break;
            case 3:
                $contenu = $this->afficherItem();
                break;
            case 4:
                $contenu = $this->afficherFormulaireReservation();
                break;
            case 5:
                $contenu = $this->afficherParticipation();
                break;
            case 6:
                $contenu = $this->afficherParticipationItem();
                break;
        }

        $path =  $this->path;
        // $path/../css/style.css pour webetu
        $html = <<<END
<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="$path/../css/style.css">
		<title>MyWisList</title>
	</head>
	<header>
	 <div id="rubrique">
	 <h1 id="titreR"><a href="$path/accueil">MyWishList </a></h1>
	 <nav>
	 <ul>
          <li><a href="$path/creation/listes">Mes Listes</a></li>
		 <li><a href="$path/connexion">Se connecter</a></li>
		 <li><a href="$path/inscription">S'inscrire</a></li>
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


    private function afficherParticipation() {
        $titre = $this->elem['liste']->titre;
        $token = $this->elem['liste']->token_participation;
        $items = '';
        foreach ($this->elem['items'] as $item)
            $items = $items . '<p><a class="lienItem" href="'. $token . "/" . $item->id.'">'.$item->id.' - '.$item->nom.'</a></p>';
        $html = <<<END
<div class="liste">
    <h1>$titre</h1>
    <div>$items</div>
</div>
END;
        return $html;
    }

    private function afficherParticipationItem() {
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
<form class="formModifItem" action="reservation">
    <input class="bouton" type="submit" name="modifItem" value="Reserver">
</form>
END;
        return $html;
    }

    private function afficherItem() : string {
        $res = '<p>'. $this->elem[0]['nom'].'</p>';
        //$res = '<p>'. var_dump($this->elem).'</p>';
        $html = <<<END
<div class="item"> 
    $res
</div>
END;
        return $html;
    }

    private function afficherItemsListe() : string {
        $res = "<p> ";
        foreach ($this->elem as $i){
            $res = $res . $i['nom'] . '<br>';
        }
        $res = $res . "</p>";
        $html = <<<END
<div class="items"> 
    $res
</div>
END;
        return $html;
    }

    private function afficherListesSouhaits() : string {
    $res = "<p>";
    foreach ($this->elem as $liste){
        $res = $res . $liste['titre'] . '<br>';
    }
    $res = $res /*. var_dump($this->elem)*/."</p>";
    $html = <<<END
<div class="souhaits"> 
    $res
</div>
END;
return $html;
    }

    private function afficherFormulaireReservation() : string {
        if (isset($_COOKIE['pseudo'])) {
            $p=$_COOKIE['pseudo'];
        }
        else {
            $p="";
        }
        $formulaire = 
            "<form action=\"\" method=\"post\">
                <h2>Reserver un Item</h2>
                           <div class=\"formulaire\">
                                <input style=\"text-align:center\" type=\"text\" name=\"pseudo\" value='$p' placeholder='Pseudonyme' required>
                           </div>
                           <div class=\"formulaire\">
                                <input style=\"text-align:center\" type=\"text\" name=\"message\" placeholder='Message (facultatif)'>
                           </div>
                           <div class=\"formulaire\">
                                <input type=\"submit\" value=\"Valider\" />
                           </div>
		               </form>";
        $res = $formulaire;
        $html = <<<END
        <div class="formulaireReservation">
        $res
        </div>
END;
    return $html;
    }
}