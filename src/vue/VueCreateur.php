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
        }
        $html = <<<END
<!DOCTYPE html> 
<body>  
    <form action="creation" method="POST">
      <button type="submit" name="token" value="1">
        Générer le lien de partage
      </button>
    </form>
    $contenu
</body>
<html>
END;
        return $html;
    }

    private function afficherToken() : string {
        $html = <<<END
<div class="items"> 
    <p>Token : $this->elem</p>
</div>
END;
        return $html;
    }


}