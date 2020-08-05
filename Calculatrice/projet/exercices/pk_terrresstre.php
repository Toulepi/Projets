<?php
private $nbpattes;
    abstract protected function nbnageoires();
    abstract protected function taille();



abstract class pk_terrresstre extends pokemon
{
    private $nbnageoires;
    private $taille;

    const CARACTERISTIQUE = "vie terrestre";

    function SeDeplacer()
    {
        echo "<h2>Je me deplace sur mes pattes</h2>";
    }

//    public function __toString()
//    {
//        return parent::__toString()."<h2> J'ai des ".self::CARACTERISTIQUE."</h2>";
//    }
}