<?php
echo "bonjour";




abstract class Pokemon
{
    private $nom;
    private $poids;



    public function __construct(int $nom, int $poids)
    {
        $this->nom = $nom;
        $this->poids = $poids;

//        self::$nombre++;
    }

//    public function (){
//        echo "<h2>kkukuhkjkj</h2>";
//    }



    abstract protected function seDplacer();




    abstract protected function fqc();
    abstract protected function vitesse();
    abstract protected function nbh_tv();



    public function __toString()
    {
        return "<h2>Je suis un ".get_class($this)."<br>Je pese $this->poids kg</h2>";
    }
}