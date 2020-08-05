<?php


abstract class pk_desmers extends pk_marins
{
    const CARACTERISTIQUE = "marin";

    function seDplacer()
    {
        echo "<h2>Je suis un pokemon sous marin</h2>";
    }
    function nom()
    {
        echo "<h2>Je suis un pokemon sous marin(nom)</h2>";
    }
    function poids()
    {
        echo "<h2>Je pese ....</h2>";
    }



    function nbnageoires()
    {
        // TODO: Implement nbpattes() method.
    }



    function vitesse()
    {
        // TODO: Implement nbpattes() method.
    }


//    public function __toString()
//    {
//        return parent::__toString()."<h2> J'ai des ".self::CARACTERISTIQUE."</h2>";
//    }
}