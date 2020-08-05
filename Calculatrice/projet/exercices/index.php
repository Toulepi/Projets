<?php
require_once "pokemon.php";
require_once "pk_terrresstre.php";
require_once "pk_marins.php";
require_once "pk_sportif.php";
require_once "pk_desmers.php";
require_once "pk_casaniers.php";
require_once "pk_croisieres.php";
require_once "Pickatchu.php";

$Pica = new Pickatchu(250, "Blanc");
//$lion->boire();
//$lion->manger();
//$lion->seDeplacer();
echo $Pica->__toString();
//echo $Picatchu->seDeplacer();




//    public function __toString()
//    {
//        //return "<h2>Je suis un ".get_class($this)."<br>Je pese $this->poids kg<br>Ma couleur est $this->couleur</h2>";
//    }
