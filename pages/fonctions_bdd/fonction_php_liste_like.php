<?php
require_once '../php/login.php';
$user = $_POST['user'];
$table = $_POST['table'];
$bool = $_POST['bool'];
$type = $_POST['type'];

/* Nb avis */

$sql = "SELECT id_avis FROM $table WHERE id_user = $user and $bool = '1'";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$nb_like = json_encode($resultats);

/* Images */

$sql = "SELECT photo_user.chemin
        FROM photo_user
        JOIN utilisateur ON utilisateur.id_image_user = photo_user.id_image_user
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$photos_users = $resultats;

/* Noms */

$sql = "SELECT utilisateur.Prenom
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$prenoms = $resultats;

/* admin */

$sql = "SELECT utilisateur.TypeCompte
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$verif = $resultats;

/* note */

$sql = "SELECT avis.CptEtoile
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$notes = $resultats;

/* avis */

$sql = "SELECT avis.Avis
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$avis = $resultats;

/* up */

$sql = "SELECT avis.CptPouceBleu
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$up = $resultats;

/* down */

$sql = "SELECT avis.CptPouceRouge
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$down = $resultats;

/* report */

$sql = "SELECT avis.CptReport
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.id_user = $user and $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$report = $resultats;

switch($type){
    case '0': echo($nb_like); break;
    case '1': echo(json_encode([$photos_users, $prenoms, $verif, $notes, $avis, $up, $down, $report])); break;
}

?>