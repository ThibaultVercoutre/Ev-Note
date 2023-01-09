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

// ============================================================

/* Nb avis */

$sql = "SELECT id_avis FROM $table WHERE $bool = '1'";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$nb_report = json_encode($resultats);

/* Images */

$sql = "SELECT photo_user.chemin
        FROM photo_user
        JOIN utilisateur ON utilisateur.id_image_user = photo_user.id_image_user
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$photos_usersR = $resultats;

/* Noms */

$sql = "SELECT utilisateur.Prenom
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$prenomsR = $resultats;

/* admin */

$sql = "SELECT utilisateur.TypeCompte
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$verifR = $resultats;

/* note */

$sql = "SELECT avis.CptEtoile
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$notesR = $resultats;

/* avis */

$sql = "SELECT avis.Avis
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$avisR = $resultats;

/* up */

$sql = "SELECT avis.CptPouceBleu
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$upR = $resultats;

/* down */

$sql = "SELECT avis.CptPouceRouge
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$downR = $resultats;

/* report */

$sql = "SELECT avis.CptReport
        FROM avis
        JOIN $table ON $table.id_avis = avis.id_avis
        WHERE $table.$bool = '1'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$reportR = $resultats;

/* supprimer avis */

$sql_suppr1 = "DELETE FROM `$table` WHERE id_avis = $bool";

/* supprimer avis dans table like */

$sql_suppr2 = "DELETE FROM `likes_avis` WHERE id_avis = $bool";

/* supprimer avis dans table dislike */

$sql_suppr3 = "DELETE FROM `dislikes_avis` WHERE id_avis = $bool";

/* supprimer avis dans table report */

$sql_suppr4 = "DELETE FROM `reports_avis` WHERE id_avis = $bool";

/* savoir si dev ou pas */

$sql = "SELECT id_user from $table WHERE TypeCompte = '$bool' AND id_user = $user";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$typeCompte = json_encode($resultats);


switch($type){
    case '0': echo($nb_like); break;
    case '1': echo(json_encode([$photos_users, $prenoms, $verif, $notes, $avis, $up, $down, $report])); break;
    case '2': echo($nb_report); break;
    case '3': echo(json_encode([$photos_usersR, $prenomsR, $verifR, $notesR, $avisR, $upR, $downR, $reportR])); break;
    case '4': $bdd->exec($sql_suppr1); $bdd->exec($sql_suppr2); $bdd->exec($sql_suppr3); $bdd->exec($sql_suppr4); break;
    case '5': echo($typeCompte); break;
}

?>