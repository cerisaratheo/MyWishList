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
        $res = "<p>saisissez votre nom/pseudo : <br /></p>";
        $formulaire = "<form action=\"\" method=\"post\">
                           <div class=\"formLise\">
                                <input type=\"text\" name=\"pseudo\" value='$p' required>
                           </div>
                           <div class=\"formLise\">
                                <p>saisissez votre message (facultatif) : <br /></p>
                                <input type=\"text\" name=\"message\">
                           </div>
                           <div class=\"formLise\">
                                <p><br /></p>
                                <input type=\"submit\" value=\"Valider\" />
                           </div>
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