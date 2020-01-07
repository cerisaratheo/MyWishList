<?php

namespace mywishlist\vue;

class VueParticipant
{

    private $elem;

    function __construct($tab)
    {
        $this->elem = $tab;
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
        if (isset($_COOKIE[ 'capp_cookie'])) {
            $p=$_COOKIE['pseudo'];
        }
        else {
            $p="";
        }
        $res = "<p>saisissez votre nom/pseudo : <br /></p>";
        $formulaire = "<form action=\"\" method=\"post\">
                           <p>
                                <input type=\"text\" name=\"pseudo\" value=$p/> <input type=\"submit\" value=\"Valider\" />
                           </p>
		               </form>";
        $res = $res.$formulaire;
        $html = <<<END
        <div class="formulaireReservation">
        $res
        </div>
END;
    return $html;
    }
}