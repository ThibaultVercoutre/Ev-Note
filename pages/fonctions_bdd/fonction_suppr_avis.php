<?php
require_once '../php/login.php';
$user = $_POST['user'];
$avis = $_POST['avis'];

/* supprimer avis */

$sql_suppr1 = "DELETE FROM `avis` WHERE id_avis = $avis AND id_user = $user";
$bdd->exec($sql_suppr1);

?>