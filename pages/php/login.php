<?php 
    try 
    {
        $host = "localhost";
        $dbname = "projet";
        $username = "utilisateur";
        $passw = "projetweb2022";
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','utilisateur', 'projetweb2022');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

?>