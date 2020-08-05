<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>calculatrice</title>
</head>
<body>

<!--function calcul($a)-->
<!--{-->
<!---->
<!--   if ($a<1 && $a<10)-->
<!--    {-->
<!--        echo "BON";-->
<!--       return;-->
<!--    }-->
<!--    else{-->
<!--        echo "PAS BON" ;-->
<!--    }-->
<!---->
<!--}-->
<!--calcul(44);-->
<!---->
<!--var_dump();-->
<!---->

<!--<form method="POST">-->
<!--<p>-->
<!--    <label for="nom"> nom:</label> <input type="text" id="nom" placeholder="nom" name="nom">-->
<!--    </p>-->
<!--    <p>-->
<!--    <label for="age"> age:</label> <input type="number" id="age" placeholder="99" name="age">-->
<!--    </p>-->
<!--   <input type="submit" >-->
<!--</form>-->
<!---->
<?php
//
//echo "<h1>bonjour".$_POST[nom]."vous avez ".$_POST[age]."ans<h1>";
//
//
//?>
<!--<form action="index.php" method="post">-->
<!--<p>-->
<!--   <label for="temperature c"> temperature °c:</label><input type="text" id="temperature c" placeholder="temperature c" name="temperature_c">-->
<!--   </p><input type="submit" value="convertion">-->
<!--<p>-->
<!--   <label for="temperature f"> temperature °f:</label><input type="text" id="temperature f" placeholder="temperature f" name="temperature_f">-->
<!--   </p>-->
<!---->
<!---->
<!--</form>-->


<form>
    <p>
        <label > </label><input type="text"  placeholder="4" name='number1'>
        <select name="operation" >
            <option value="+"name="addition">+</option>
            <option value="-"name="soustraction">-</option>
            <option value="/"name="division">/</option>
            <option value="*"name="multiplacation">*</option></select>
        <label> </label><input type="text" placeholder="4" name="number2">
        <button name="submit">=</button>
    </p>
   <?php


   //if (isset($_GET['submit'])){
$resultat1 = $_GET["number1"];
$resultat2 = $_GET["number2"];
$operateur = $_GET["operation"];


switch ($operateur) {
    case "+":
        echo $resultat1 + $resultat2;
        break;
    case "-":
        echo $resultat1 - $resultat2;
        break;
    case '*':
        echo $resultat1 * $resultat2;
        break;
    case '/':
        echo $resultat1 / $resultat2;
        break;
}

?>







</body>
</html>
<?php


//if (!empty($_POST[t]))

//
//?>