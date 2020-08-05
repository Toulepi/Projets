<?php





abstract class pk_marins extends pokemon
{
    const CARACTERISTIQUE = "vie sous marine";

    function seDeplacer()
    {
        echo "<h2> je vais sous leau</h2>";
    }

//    public function __toString()
//    {
//        return parent::__toString()."<h2> J'ai des ".self::CARACTERISTIQUE."</h2>";
//    }
}