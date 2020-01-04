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
                $contenu = "";
                break;
            case 1 :
                $contenu = $this->afficherToken();
                break;
            case 2 :
                $contenu = $this->afficherListe();
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

    private function creerListe() : string {
        $html = "";
        return $html;
    }

    private function afficherListe() : string {
        $titre = $this->elem->titre;

        $html = <<<END
<div class="liste"> 
    <h1>$titre</h1>
</div>
END;
        return $html;
    }

    private function afficherToken() : string {
        $html = <<<END
<form action="creer" method="POST">
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


}