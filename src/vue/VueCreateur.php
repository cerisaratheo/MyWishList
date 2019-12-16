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
        $contenu = "";
        switch ($index){
            case 1 :
                $contenu = $this->afficherToken();
                break;
        }
        $html = <<<END
<!DOCTYPE html> 
<body>  
    <form action="index.php" method="GET">
      <input type="button" name="generer_token" value="Générer token">
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