<?php 
    try 
    {
        $host = "localhost";
        $dbname = "projet";
        $username = "root";
        $passw = "";
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','root');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

?>